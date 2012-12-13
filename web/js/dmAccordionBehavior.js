(function($) {    
    
    var methods = {        
        init: function(behavior) {   
            var $this = $(this), data = $this.data('dmAccordionBehavior');
            if (data && behavior.dm_behavior_id != data.dm_behavior_id) {
                alert('You can not attach accordion behavior to same content'); 
            };
            $this.data('dmAccordionBehavior', behavior);
        },        
        start: function(behavior) {            
            var $this = $(this), self = this;
            
            var $copy = $this.children().clone(true, true);
            $this.data('dmAccordionBehaviorPreviousDOM', $this.children().detach());
            $this.children().remove();
            
            $this.addClass('dmAccordionBehavior').addClass(behavior.theme);
            
            var tCounter = 0, iCounter = 0;
            
            $.each($copy, function(index){
                var $element = $(this);
                tCounter++;
                if ((tCounter % 2) == 0) {
                    $element.addClass('accordion-content').addClass('accordion-content-index-' + iCounter).addClass('closed');
                    $element.css('display', 'none');
                    iCounter++;
                } else {
                    $element.addClass('accordion-title').addClass('accordion-title-index-' + iCounter).addClass('closed');
                    switch (behavior.event) {
                        case 'mouseover': {
                                $element.mouseover(function(){
                                    methods['animate'].apply(self, [behavior, $(this)]);
                                });
                        } break;
                        case 'click_open_close':
                        // FALL TROUGH!
                        case 'click_open_only': {
                                $element.click(function(){
                                    methods['animate'].apply(self, [behavior, $(this)]);
                                });
                        } break;
                    };                    
                };
                $element.addClass('closed');                
            });
            
            // Initialy opened
            if (behavior.initialy_open) {                
                var $titles = $copy.filter('.accordion-title'),
                $contents = $copy.filter('.accordion-content');
                $.each(behavior.initialy_open, function(){                    
                    if (this > iCounter) return; // User input error, just skip it                    
                    $($titles[this-1]).removeClass('closed').addClass('open');
                    $($contents[this-1]).removeClass('closed').addClass('open').css('display', 'block');
                });
            };
            $this.append($copy);
        },
        stop: function(behavior) {
            var $this = $(this);
            $this.removeClass('dm-working-class').children().remove();
            $this.append($this.data('dmAccordionBehaviorPreviousDOM'));  
        },
        destroy: function(behavior) {            
            var $this = $(this);
            $this.data('dmAccordionBehavior', null);
            $this.data('dmAccordionBehaviorPreviousDOM', null); 
        },
        animate: function(behavior, $sender) {
            var $this = $(this);
            if ($this.hasClass('dm-working-class') || (behavior.event == 'click_open_only' && $sender.hasClass('open'))) return;
            $this.addClass('dm-working-class');
            
            var $senderContent = $sender.next(), 
            $closer = $this.find('.accordion-title.open').not($sender), 
            $closerContent = $this.find('.accordion-content.open').not($senderContent);
            
            if ($sender.hasClass('closed')) {
                $sender.removeClass('closed').addClass('open');
                $senderContent.removeClass('closed').addClass('open'); 
            } else {
                $sender.removeClass('open').addClass('closed');
                $senderContent.removeClass('open').addClass('closed');                
            };                       
            
            if (behavior.colapsable) {
                $closer.removeClass('open').addClass('closed');
                $closerContent.removeClass('open').addClass('closed');
            };
            
            switch (behavior.animation) {
                case 'slide': {
                        if ($sender.hasClass('open')) {
                            $senderContent.slideDown(behavior.duration, behavior.easing, function(){
                                $this.removeClass('dm-working-class');
                            });
                        } else {
                            $senderContent.slideUp(behavior.duration, behavior.easing, function(){
                                $this.removeClass('dm-working-class');
                            });
                        };
                        if (behavior.colapsable) {
                            $closerContent.slideUp(behavior.duration, behavior.easing, function(){
                                $this.removeClass('dm-working-class');
                            });
                        };                        
                } break;
                case 'show': {
                        if ($sender.hasClass('open')) {
                            $senderContent.show(behavior.duration, behavior.easing, function(){
                                $this.removeClass('dm-working-class');
                            });
                        } else {
                            $senderContent.hide(behavior.duration, behavior.easing, function(){
                                $this.removeClass('dm-working-class');
                            });
                        };
                        if (behavior.colapsable) {
                            $closerContent.hide(behavior.duration, behavior.easing, function(){
                                $this.removeClass('dm-working-class');
                            });
                        }; 
                } break;
                case 'fade': {
                        if ($sender.hasClass('open')) {
                            $senderContent.fadeIn(behavior.duration, behavior.easing, function(){
                                $this.removeClass('dm-working-class');
                            });
                        } else {
                            $senderContent.fadeOut(behavior.duration, behavior.easing, function(){
                                $this.removeClass('dm-working-class');
                            });
                        };
                        if (behavior.colapsable) {
                            $closerContent.fadeOut(behavior.duration, behavior.easing, function(){
                                $this.removeClass('dm-working-class');
                            });
                        }; 
                } break;
                default: {
                        if ($sender.hasClass('open')) {
                            $senderContent.css('display', 'block');
                        } else {
                            $senderContent.css('display', 'none');
                        };
                        if (behavior.colapsable) {
                            $closerContent.css('display', 'none');
                        }; 
                        $this.removeClass('dm-working-class');
                } break;
            };
        }
    };
    
    $.fn.dmAccordionBehavior = function(method, behavior){
        return this.each(function() {
            if ( methods[method] ) {
                return methods[ method ].apply( this, [behavior]);
            } else if ( typeof method === 'object' || ! method ) {
                return methods.init.apply( this, [method] );
            } else {
                $.error( 'Method ' +  method + ' does not exist on jQuery.dmAccordionBehavior' );
            }; 
        });
    };

    $.extend($.dm.behaviors, {        
        dmAccordionBehavior: {
            init: function(behavior) {                
                $($.dm.behaviorsManager.getCssXPath(behavior, true) + ' ' + behavior.inner_target).dmAccordionBehavior('init', behavior);
            },
            start: function(behavior) {
                $($.dm.behaviorsManager.getCssXPath(behavior, true) + ' ' + behavior.inner_target).dmAccordionBehavior('start', behavior);
            },
            stop: function(behavior) {
                $($.dm.behaviorsManager.getCssXPath(behavior, true) + ' ' + behavior.inner_target).dmAccordionBehavior('stop', behavior);
            },
            destroy: function(behavior) {
                $($.dm.behaviorsManager.getCssXPath(behavior, true) + ' ' + behavior.inner_target).dmAccordionBehavior('destroy', behavior);
            }
        }
    });
    
})(jQuery);
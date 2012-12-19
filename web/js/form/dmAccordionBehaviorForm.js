(function($) {

$.fn.extend({
  
  dmAccordionBehaviorForm: function($form)
  {
    $form.find('div.dm_tabbed_form').dmCoreTabForm({});
  }
  
});

})(jQuery);
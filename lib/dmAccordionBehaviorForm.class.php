<?php
/**
 * @author TheCelavi
 */
class dmAccordionBehaviorForm extends dmBehaviorBaseForm {
    
    protected $animations = array(        
        'slide'=>'Slide',
        'show' => 'Show',
        'fade'=>'Fade',
        'none'=>'None'
    );
    
    protected $events = array(
        'click_open_close'=>'Mouse click opens/close',
        'click_open_only' => 'Mouse click opens only',
        'mouseover'=>'Mouse hover opens only'
    );
    
    protected $themes;
    
    public function __construct($behavior, $options = array(), $CSRFSecret = null)
    {        
        $keys = array_keys(sfConfig::get('dm_dmAccordionBehavior_themes'));        
        $values = array();
        foreach ($keys as $key) $values[] = dmString::humanize ($key);
        $this->themes = array_combine($keys, $values);        
        
        parent::__construct($behavior, $options, $CSRFSecret);
    }

    public function configure() {
        
        $this->widgetSchema['inner_target'] = new sfWidgetFormInputText();
        $this->validatorSchema['inner_target'] = new sfValidatorString(array(
            'required' => false
        ));
        
        $this->widgetSchema['theme'] = new sfWidgetFormChoice(array(
            'choices'=> $this->getI18n()->translateArray($this->themes)
        ));
        $this->validatorSchema['theme'] = new sfValidatorChoice(array(
            'choices'=>  array_keys($this->themes)
        )); 
                
        $this->widgetSchema['event'] = new sfWidgetFormChoice(array(
            'choices'=>$this->getI18n()->translateArray($this->events)
        ));
        $this->validatorSchema['event'] = new sfValidatorChoice(array(
            'choices'=>  array_keys($this->events)
        ));
        
        $this->widgetSchema['colapsable'] = new sfWidgetFormInputCheckbox();
        $this->validatorSchema['colapsable'] = new sfValidatorBoolean(); 
        
        $this->widgetSchema['initialy_open'] = new sfWidgetFormInputText();
        $this->validatorSchema['initialy_open'] = new sfValidatorString(array(
            'required' => false
        ));
        
        $this->widgetSchema['animation'] = new sfWidgetFormChoice(array(
            'choices'=> $this->getI18n()->translateArray($this->animations)
        ));
        $this->validatorSchema['animation'] = new sfValidatorChoice(array(
            'choices'=>  array_keys($this->animations)
        ));
        
        $this->widgetSchema['duration'] = new sfWidgetFormInputText();
        $this->validatorSchema['duration'] = new sfValidatorInteger(array(
            'min'=>0
        )); 
        
        $this->widgetSchema['easing'] = new dmWidgetFormChoiceEasing();
        $this->validatorSchema['easing'] = new dmValidatorChoiceEasing(array(
            'required' => true
        ));
        
        $this->getWidgetSchema()->setLabels(array(
            'initialy_open' => 'Initialy open'
        ));
        
        $this->getWidgetSchema()->setHelps(array(            
            'duration' => 'Duration of the animation in ms',
            'colapsable' => 'Opening one tab will close others',
            'initialy_open' => 'Enter index of initialy opened tab(s) separated with semicolon (;), or nothing for all to be closed.'
        ));
        
        $defaults = sfConfig::get('dm_dmAccordionBehavior_defaults');
        
        if (is_null($this->getDefault('inner_target'))) $this->setDefault ('inner_target', $defaults['inner_target']);
        if (is_null($this->getDefault('initialy_open'))) $this->setDefault ('initialy_open', $defaults['initialy_open']);
        if (is_null($this->getDefault('colapsable'))) $this->setDefault ('colapsable', $defaults['colapsable']);
        if (is_null($this->getDefault('theme'))) $this->setDefault ('theme', $defaults['theme']);
        if (is_null($this->getDefault('event'))) $this->setDefault ('event', $defaults['event']);
        if (is_null($this->getDefault('animation'))) $this->setDefault ('animation', $defaults['animation']);
        if (is_null($this->getDefault('easing'))) $this->setDefault ('easing', $defaults['easing']);
        if (is_null($this->getDefault('duration'))) $this->setDefault ('duration', $defaults['duration']);
        
        
        parent::configure();
    }
    
}


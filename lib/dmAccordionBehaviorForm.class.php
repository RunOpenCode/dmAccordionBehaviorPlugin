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
        
        $this->getWidgetSchema()->setLabels(sfConfig::get('dm_dmAccordionBehavior_labels'));        
        $this->getWidgetSchema()->setHelps(sfConfig::get('dm_dmAccordionBehavior_helps'));
        
        if (is_null($this->getDefault('inner_target'))) {
            $this->setDefaults(sfConfig::get('dm_dmAccordionBehavior_defaults'));
        }
        
        parent::configure();
    }
    
    public function getStylesheets()
    {
        return array(
            'lib.ui-tabs',
        );
    }

    public function getJavascripts()
    {
        return array(
            'lib.ui-tabs',
            'core.tabForm',
            'dmAccordionBehaviorPlugin.form'
        );
    }

    protected function renderContent($attributes)
    {
        return $this->getHelper()->renderPartial('dmBehavior', 'forms/dmAccordionBehavior', array(
                'form' => $this,
                'baseTabId' => 'dm_behavior_dmaccordion_' . $this->dmBehavior->getId()
            ));
    }
    
}


<?php
/**
 * @author TheCelavi
 */
class dmAccordionBehaviorView extends dmBehaviorBaseView {

    protected function filterBehaviorVars(array $vars = array()) {        
        $vars = array_merge(sfConfig::get('dm_dmAccordionBehavior_defaults'), parent::filterBehaviorVars($vars));
        
        // Initialy open is either null or array of indexes
        if (trim($vars['initialy_open']) == "") {
            $vars['initialy_open'] = null;
        } elseif (strpos($vars['initialy_open'], ';')) {            
            $tmp = explode(';', $vars['initialy_open']);
            $vars['initialy_open'] = array();
            foreach ($tmp as $t) {
                $vars['initialy_open'][] = intval(trim($t));
            }
        } else {
            $vars['initialy_open'] = array(intval($vars['initialy_open']));
        }
        
        $vars['colapsable'] = ($vars['colapsable']) ? true : false;
        //$vars['colapsable'] = intval($vars['colapsable']);
        return $vars;
        
    }
    
    public function getJavascripts() {
        return array_merge(
            parent::getJavascripts(),            
            array(
                'lib.easing',                
                'dmAccordionBehaviorPlugin.launch'
            )
        );
    } 
    
    public function getStylesheets() {
        $registeredThemes = sfConfig::get('dm_dmAccordionBehavior_themes');
        $vars = $this->getBehaviorVars();
        $theme = array();
        if (isset($registeredThemes[$vars['theme']])) $theme[] = $registeredThemes[$vars['theme']];
        return array_merge(
            parent::getStylesheets(),
            $theme
        );
    }
}


<?php

echo

$form->renderGlobalErrors(),

_open('div.dm_tabbed_form'),

_tag('ul.tabs',
  _tag('li', _link('#'.$baseTabId.'_basic')->text(__('Basic'))).
  _tag('li', _link('#'.$baseTabId.'_advance')->text(__('Advance')))
),

_tag('div#'.$baseTabId.'_basic',
  _tag('ul.dm_form_elements',
    $form['inner_target']->renderRow().
    $form['theme']->renderRow().
    $form['event']->renderRow().
    $form['initialy_open']->renderRow().
    $form['colapsable']->renderRow().    
    $form['dm_behavior_enabled']->renderRow() 
  )
),

_tag('div#'.$baseTabId.'_advance',
  _tag('ul.dm_form_elements',
    $form['animation']->renderRow().
    $form['duration']->renderRow().
    $form['easing']->renderRow()
  )
),

_close('div'); 
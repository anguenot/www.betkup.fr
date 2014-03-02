<?php
include_component('interface', 'select', array(
    'bloc' => 'kups_status_select',
    'width1' => '200',
    'width2' => '140',
    'width3' => '0',
    'widthGadget' => '100',
    'marginLeftError' => '386',
    'messageError' => '',
    'blocType' => 'text',
    'blocIcone' => '',
    'blocName' => 'kupsStatusSelect',
    'blocLegende' => __('text_me_display').' :',
    'blocFirstRow' => '',
    'blocValue' => $selectedKup,	
    'blocChoices' => $kupsStatus));  
?>
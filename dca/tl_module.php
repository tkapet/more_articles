<?php
/**
 * Created by PhpStorm.
 * User: tkapet-mac
 * Date: 09-Nov-16
 * Time: 11:52 PM
 */
/**
 * Add palettes to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['default']   = '{title_legend},name,headline,type;{config_legend},article_limit;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';


/**
 * Add fields to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['article_limit'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['article_limit'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('mandatory'=>true),
    'sql'                     => "int NOT NULL default 5"
);

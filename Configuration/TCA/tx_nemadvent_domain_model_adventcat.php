<?php
defined('TYPO3_MODE') or die();

return array (
    'ctrl' => array (
        'title'             => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xlf:Tx_Nemadvent_Domain_Model_Adventcat',
        'label' 			=> 'title',
        'tstamp' 			=> 'tstamp',
        'crdate' 			=> 'crdate',
        'languageField' 	=> 'sys_language_uid',
        'transOrigPointerField' 	=> 'l18n_parent',
        'transOrigDiffSourceField' 	=> 'l18n_diffsource',
        'delete' 			=> 'deleted',
        'enablecolumns' 	=> array(
            'disabled' => 'hidden'
        ),
        'iconfile' 			=> 'EXT:nemadvent/Resources/Public/Icons/icon_tx_nemadvent_domain_model_adventcat.gif'
    ) ,
    'interface' => array(
        'showRecordFieldList' => 'title,startdate,enddate,days'
    ),
    'columns' => array(
        'sys_language_uid' => Array (
            'exclude' => 0,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => Array (
                'type' => 'select',
                'renderType' => 'selectSingle' ,
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => Array(
                    Array('LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages',-1),
                    Array('LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.default_value',0)
                )
            )
        ),
        'l18n_parent' => Array (
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => 0,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => Array (
                'type' => 'select',
                'renderType' => 'selectSingle' ,
                'items' => Array (
                    Array('', 0),
                ),
                'foreign_table' => 'tx_nemadvent_domain_model_adventcat',
                'foreign_table_where' => 'AND tx_nemadvent_domain_model_adventcat.uid=###REC_FIELD_l18n_parent### AND tx_nemadvent_domain_model_adventcat.sys_language_uid IN (-1,0)',
            )
        ),
        'l18n_diffsource' => Array(
            'config'=>array(
                'type'=>'passthrough'
            )
        ),
        'hidden' => array(
            'exclude' => 0,
            'label'   => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config'  => array(
                'type' => 'check'
            )
        ),
        'title' => array(
            'exclude' => 0,
            'label'   => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xlf:Tx_Nemadvent_Domain_Model_Adventcat.title',
            'config'  => array(
                'type' => 'input',
                'size' => 40,
                'eval' => 'trim,required',
                'max'  => 256
            )
        ),
        'startdate' => array(
            'exclude' => 0,
            'label'   => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xlf:Tx_Nemadvent_Domain_Model_Adventcat.startdate',
            'config'  => array(
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 20,
                'eval' => 'datetime, required',
                'checkbox' => '0',
                'default' => '0'
            )
        ),
        'enddate' => array(
            'exclude' => 0,
            'label'   => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xlf:Tx_Nemadvent_Domain_Model_Adventcat.enddate',
            'config'  => array(
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 20,
                'eval' => 'datetime, required',
                'checkbox' => '0',
                'default' => '0'
            )
        ),
        'days' => array(
            'exclude' => 0,
            'label'   => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xlf:Tx_Nemadvent_Domain_Model_Adventcat.days',
            'config'  => array(
                'type' => 'input',
                'size' => 3,
                'default' => 24,
                'eval' => 'integer,required',
                'max'  => 3
            )
        ),
/*
        'advents' => array(
            'l10n_mode' => 'exclude',
            'config' => array(
                'type' => 'passthrough',
            )
        ),
*/
    ),
    'types' => array(
        '1' => array('showitem' => 'sys_language_uid, l18n_parent, hidden, title, startdate, enddate, days')
    ),
    'palettes' => array(
        '1' => array('showitem' => '')
    )
);
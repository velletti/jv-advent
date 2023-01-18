<?php
defined('TYPO3_MODE') or die();

return array (
    'ctrl' => array (
        'title'             => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xlf:Tx_Nemadvent_Domain_Model_Winner.winner',
        'label' 			=> 'title',
        'tstamp' 			=> 'tstamp',
        'crdate' 			=> 'crdate',
        'languageField' 	=> 'sys_language_uid',
        'transOrigPointerField' 	=> 'l18n_parent',
        'transOrigDiffSourceField' 	=> 'l18n_diffsource',
        'delete' 			=> 'deleted',
        'default_sortby' => 'ORDER BY sorting',
        'enablecolumns' 	=> array(
            'disabled' => 'hidden'
        ),
        'iconfile' 			=>  'EXT:nemadvent/Resources/Public/Icons/icon_tx_nemadvent_domain_model_winner.gif'
    ) ,
    'interface' => array(
        'showRecordFieldList' => 'date,feuser_uid,title,desc_short,sys_language_uid,hidden,sorting,points'
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
                'foreign_table' => 'tx_nemadvent_domain_model_winner',
                'foreign_table_where' => 'AND tx_nemadvent_domain_model_winner.uid=###REC_FIELD_l18n_parent### AND tx_nemadvent_domain_model_winner.sys_language_uid IN (-1,0)',
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
            'label'   => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xlf:Tx_Nemadvent_Domain_Model_Winner.prize',
            'config'  => array(
                'type' => 'input',
                'size' => 40,
                'eval' => 'trim',
                'max'  => 256
            )
        ),
        'desc_short' => array(
            'exclude' => 0,
            'label'   => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xlf:Tx_Nemadvent_Domain_Model_Winner.text',
            'config'  => array(
                'type' => 'text',
                'rows' => 4,
                'cols' => 40,

                'eval' => 'trim',
                'max'  => 256
            )
        ),
        'date' => array(
            'exclude' => 0,
            'label'   => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xlf:Tx_Nemadvent_Domain_Model_Winner.date',
            'config'  => array(
                'type' => 'input',
                'size' => 20,
                'eval' => 'datetime',
                'max'  => 20
            )
        ),
        'feuser_uid' => array (
            'exclude' => 0,
            'label'   => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xlf:Tx_Nemadvent_Domain_Model_Winner.winner_uid',
            'config' => array (
                'type' => 'input',
                'size' => 10,
                'eval' => 'required',
                'maxitem' => 1,
            )
        ),
        'sorting' => array (
            'exclude' => 0,
            'label'   => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xlf:Tx_Nemadvent_Domain_Model_Winner.sorting',
            'config' => array (
                'type' => 'input',
                'size' => 11,
                'eval' => 'required',
                'maxitem' => 1,
            )
        ),
        'points' => array (
            'exclude' => 0,
            'label'   => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xlf:Tx_Nemadvent_Domain_Model_Winner.points',
            'config' => array (
                'type' => 'input',
                'size' => 11,
                'eval' => 'integer,trim',
                'maxitem' => 1,
            )
        ),


    ),
    'types' => array(
        '1' => array('showitem' => 'hidden, date, sys_language_uid,title, desc_short,feuser_uid,sorting,points')
    ),
    'palettes' => array(
        '1' => array('showitem' => '')
    )
);
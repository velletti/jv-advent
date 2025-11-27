<?php
defined('TYPO3') or die();

return array (
    'ctrl' => array (
        'title'             => 'LLL:EXT:jvadvent/Resources/Private/Language/locallang_db.xlf:tx_jvadvent_domain_Model_Winner.winner',
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
        'iconfile' 			=>  'calc-jvadvent',
    ),
    'columns' => array(
        'sys_language_uid' => Array (
            'exclude' => 0,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => ['type' => 'language']
        ),
        'l18n_parent' => Array (
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => Array (
                'type' => 'select',
                'renderType' => 'selectSingle' ,
                'items' => Array (
                    Array('label' => '', 'value' => 0),
                ),
                'foreign_table' => 'tx_jvadvent_domain_model_winner',
                'foreign_table_where' => 'AND tx_jvadvent_domain_model_winner.uid=###REC_FIELD_l18n_parent### AND tx_jvadvent_domain_model_winner.sys_language_uid IN (-1,0)',
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
            'label'   => 'LLL:EXT:jvadvent/Resources/Private/Language/locallang_db.xlf:tx_jvadvent_domain_Model_Winner.prize',
            'config'  => array(
                'type' => 'input',
                'size' => 40,
                'eval' => 'trim',
                'max'  => 256
            )
        ),
        'desc_short' => array(
            'exclude' => 0,
            'label'   => 'LLL:EXT:jvadvent/Resources/Private/Language/locallang_db.xlf:tx_jvadvent_domain_Model_Winner.text',
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
            'label'   => 'LLL:EXT:jvadvent/Resources/Private/Language/locallang_db.xlf:tx_jvadvent_domain_Model_Winner.date',
            'config'  => array(
                'type' => 'input',
                'size' => 20,
                'eval' => 'datetime',
                'max'  => 20
            )
        ),
        'feuser_uid' => array (
            'exclude' => 0,
            'label'   => 'LLL:EXT:jvadvent/Resources/Private/Language/locallang_db.xlf:tx_jvadvent_domain_Model_Winner.winner_uid',
            'config' => array (
                'type' => 'input',
                'size' => 10,
                'maxitem' => 1,
                'required' => true,
            )
        ),
        'sorting' => array (
            'exclude' => 0,
            'label'   => 'LLL:EXT:jvadvent/Resources/Private/Language/locallang_db.xlf:tx_jvadvent_domain_Model_Winner.sorting',
            'config' => array (
                'type' => 'input',
                'size' => 11,
                'maxitem' => 1,
                'required' => true,
            )
        ),
        'points' => array (
            'exclude' => 0,
            'label'   => 'LLL:EXT:jvadvent/Resources/Private/Language/locallang_db.xlf:tx_jvadvent_domain_Model_Winner.points',
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
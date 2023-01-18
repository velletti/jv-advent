<?php
defined('TYPO3_MODE') or die();

return array (
    'ctrl' => array (
        'title'		=> 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xlf:Tx_Nemadvent_Domain_Model_User',
        'label'     => 'uid',
        'tstamp'    => 'tstamp',
        'crdate'    => 'crdate',
        'cruser_id' => 'cruser_id',
        'default_sortby' => 'ORDER BY crdate',
        'iconfile' 		=> 'EXT:nemadvent/Resources/Public/Icons/icon_tx_nemadvent_domain_model_user'
    ) ,
    'default_sortby' =>  'ORDER BY points DESC, tstamp, sys_language_uid',
    'interface' => array (
        'showRecordFieldList' => 'feuser_uid,customerno,usergroup,sys_language_uid,points,question_uid,question_date,question_datef,advent_uid,answer_uid'
    ),
    'columns' => array (
        'feuser_uid' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xlf:Tx_Nemadvent_Domain_Model_User.feuser_uid',
            'config' => array (
                'type' => 'input',
                'size' => 11,
                'maxitem' => 11,
            )
        ),
        'uid' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xlf:Tx_Nemadvent_Domain_Model_User.uid',
            'config' => array (
                'type' => 'input',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
            )
        ),
        'sys_language_uid' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xlf:Tx_Nemadvent_Domain_Model_User.sys_language_uid',
            'config' => array (
                'type' => 'input',
                'size' => 11,
                'maxitem' => 11,
            )
        ),

        'usergroup' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xlf:Tx_Nemadvent_Domain_Model_User.usergroup',
            'config' => array (
                'type' => 'input',
                'size' => 11,
                'maxitem' => 11,
            )
        ),
        'customerno' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xlf:Tx_Nemadvent_Domain_Model_User.customerno',
            'config' => array (
                'type' => 'input',
                'size' => 11,
                'maxitem' => 11,
            )
        ),
        'question_uid' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xlf:Tx_Nemadvent_Domain_Model_User.question_uid',
            'config' => array (
                'type' => 'input',
                'size' => 11,
                'maxitem' => 11,
            )
        ),
        'question_date' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xlf:Tx_Nemadvent_Domain_Model_User.question_date',
            'config' => array (
                'type' => 'input',
                'size' => 11,
                'maxitem' => 11,
                'eval' => 'date',
            )
        ),
        'crdate' => array (
            'exclude' => 1,
            'label' => 'crdate',
            'config' => array (
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 20,
                'eval' => 'datetime, required',
                'checkbox' => '0',
                'default' => '0'
            )
        ),
        'tstamp' => array (
            'exclude' => 1,
            'label' => 'Timestamp',
            'config' => array (
                'type' => 'input',
                'size' => 11,
                'maxitem' => 11,
                'eval' => 'date',
            )
        ),
        'question_datef' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xlf:Tx_Nemadvent_Domain_Model_User.question_datef',
            'config' => array (
                'type' => 'input',
                'size' => 10,
                'maxitem' => 10,
            )
        ),
        'advent_uid' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xlf:Tx_Nemadvent_Domain_Model_User.advent_uid',
            'config' => array (
                'type' => 'input',
                'size' => 11,
                'maxitem' => 1,
            )
        ),
        'answer_uid' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xlf:Tx_Nemadvent_Domain_Model_User.answer_uid',
            'config' => array (
                'type' => 'input',
                'size' => 11,
                'maxitem' => 11,
            )
        ),


        'points' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xlf:Tx_Nemadvent_Domain_Model_User.points',
            'config' => array (
                'type' => 'input',
                'size' => 11,
                'maxitem' => 11,
            )
        ),
        'subpoints' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xlf:Tx_Nemadvent_Domain_Model_User.subpoints',
            'config' => array (
                'type' => 'input',
                'size' => 11,
                'maxitem' => 11,
            )
        ),
    ),
    'types' => array (
        '0' => array('showitem' => 'feuser_uid,points,customerno,usergroup,sys_language_uid,question_date,question_datef,advent_uid,answer_uid,question_uid')
    ),
    'palettes' => array (
        '1' => array('showitem' => '')
    )
);
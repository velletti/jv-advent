<?php
defined('TYPO3') or die();
return
    array(
        'ctrl' => array (
            'title'             => 'LLL:EXT:jvadvent/Resources/Private/Language/locallang_db.xlf:tx_jvadvent_domain_Model_Advent',
            'label' 			=> 'title',
            'tstamp' 			=> 'tstamp',
            'crdate' 			=> 'crdate',
            'languageField' 	=> 'sys_language_uid',
            'transOrigPointerField' 	=> 'l18n_parent',
            'transOrigDiffSourceField' 	=> 'l18n_diffsource',
            'delete' 			=> 'deleted',
            'sortby' 			=> 'sorting',
            'default_sortby' 	=> 'ORDER BY date',
            'dividers2tabs'     => true,
            'enablecolumns' 	=> array(
                'disabled' => 'hidden'
            ),

            'iconfile' 			=> 'EXT:jvadvent/Resources/Public/Icons/icon_tx_jvadvent_domain_model_advent.gif'
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
                    'foreign_table' => 'tx_jvadvent_domain_model_advent',
                    'foreign_table_where' => 'AND tx_jvadvent_domain_model_advent.uid=###REC_FIELD_l18n_parent### AND tx_jvadvent_domain_model_advent.sys_language_uid IN (-1,0)',
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
                'label'   => 'LLL:EXT:jvadvent/Resources/Private/Language/locallang_db.xlf:tx_jvadvent_domain_Model_Advent.title',
                'config'  => array(
                    'type' => 'input',
                    'size' => 40,
                    'eval' => 'trim',
                    'max'  => 256,
                    'required' => true
                )
            ),

            'date' => array (
                'exclude' => 0,
                'label'   => 'LLL:EXT:jvadvent/Resources/Private/Language/locallang_db.xlf:tx_jvadvent_domain_Model_Advent.date',
                'config' => array (
                    'type' => 'datetime',
                    'size' => 12,
                    'checkbox' => '0',
                    'default' => 0,
                    'format' => 'date',
                    'required' => true
                )
            ),

            'desc_short' => array (
                'exclude' => 0,
                'label' => 'LLL:EXT:jvadvent/Resources/Private/Language/locallang_db.xlf:tx_jvadvent_domain_Model_Advent.desc_short',
                'richtextConfiguration' => 'connect_template',
                'config' => array(
                    'type' => 'text',
                    'cols' => 15,
                    'rows' => 5,
                    'enableRichtext' => true,
                )
            ),

            'desc_long' => array (
                'exclude' => 0,
                'label' => 'LLL:EXT:jvadvent/Resources/Private/Language/locallang_db.xlf:tx_jvadvent_domain_Model_Advent.desc_long',
                'richtextConfiguration' => 'connect_template',
                'config' => array(
                    'type' => 'text',
                    'cols' => 15,
                    'rows' => 5,
                    'enableRichtext' => true,
                )
            ),

            'solution' => array (
                'exclude' => 0,
                'label' => 'LLL:EXT:jvadvent/Resources/Private/Language/locallang_db.xlf:tx_jvadvent_domain_Model_Advent.solution',
                'richtextConfiguration' => 'connect_template',
                'config' => array(
                    'type' => 'text',
                    'cols' => 15,
                    'rows' => 5,
                    'enableRichtext' => true,
                )
            ),

            'image' => array(
                'label' => 'LLL:EXT:jvadvent/Resources/Private/Language/locallang_db.xlf:tx_jvadvent_domain_Model_Advent.image',
                'config' => [
                    ### !!! Watch out for fieldName different from columnName
                    'type' => 'file',
                    'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
                    'minitems' => 0,
                    'maxitems' => 1,
                    'foreign_types' => array(
                        // 2: FILETYPE_IMAGE
                        '2' => array(
                            'showitem' => '
                                                --palette--;LLL:EXT:marit_elearning/Resources/Private/Language/locallang_db.xml:tx_maritelearning_domain_model_lesson.image;basicoverlayPalette,
                                                --palette--;;filePalette, sys_language_uid'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => array(
                            'showitem' => '
                                                --palette--;LLL:EXT:marit_elearning/Resources/Private/Language/locallang_db.xml:tx_maritelearning_domain_model_lesson.image;basicoverlayPalette,
                                                --palette--;;filePalette, sys_language_uid'
                        ),
                    ),
                ]
            ),

            'viewed' => array (
                'exclude' => 0,
                'label' => 'LLL:EXT:jvadvent/Resources/Private/Language/locallang_db.xlf:tx_jvadvent_domain_Model_Advent.viewed',
                'config' => array (
                    'type' => 'input',
                    'size' => '8',
                )
            ),
            'answer1' => array (
                'exclude' => 0,
                'label' => 'LLL:EXT:jvadvent/Resources/Private/Language/locallang_db.xlf:tx_jvadvent_domain_Model_Advent.answer1',
                'config' => array (
                    'type' => 'text',
                    'cols' => '48',
                    'rows' => '2',
                )
            ),
            'answer2' => array (
                'exclude' => 0,
                'label' => 'LLL:EXT:jvadvent/Resources/Private/Language/locallang_db.xlf:tx_jvadvent_domain_Model_Advent.answer2',
                'config' => array (
                    'type' => 'text',
                    'cols' => '48',
                    'rows' => '2',
                )
            ),
            'answer3' => array (
                'exclude' => 0,
                'label' => 'LLL:EXT:jvadvent/Resources/Private/Language/locallang_db.xlf:tx_jvadvent_domain_Model_Advent.answer3',
                'config' => array (
                    'type' => 'text',
                    'cols' => '48',
                    'rows' => '2',
                )
            ),
            'answer4' => array (
                'exclude' => 0,
                'label' => 'LLL:EXT:jvadvent/Resources/Private/Language/locallang_db.xlf:tx_jvadvent_domain_Model_Advent.answer4',
                'config' => array (
                    'type' => 'text',
                    'cols' => '48',
                    'rows' => '2',
                )
            ),
            'answer5' => array (
                'exclude' => 0,
                'label' => 'LLL:EXT:jvadvent/Resources/Private/Language/locallang_db.xlf:tx_jvadvent_domain_Model_Advent.answer5',
                'config' => array (
                    'type' => 'text',
                    'cols' => '48',
                    'rows' => '2',
                )
            ),
            'correct' => array (
                'exclude' => 0,
                'label' => 'LLL:EXT:jvadvent/Resources/Private/Language/locallang_db.xlf:tx_jvadvent_domain_Model_Advent.correct',
                'config' => array (
                    'type' => 'input',
                    'size' => '10',
                    'default' => '',
                )
            ),
            'rangemin' => array (
                'exclude' => 0,
                'label' => 'LLL:EXT:jvadvent/Resources/Private/Language/locallang_db.xlf:tx_jvadvent_domain_Model_Advent.rangemin',
                'config' => array (
                    'type' => 'number',
                    'size' => '10',
                    'default' => '',
                )
            ),
            'rangemax' => array (
                'exclude' => 0,
                'label' => 'LLL:EXT:jvadvent/Resources/Private/Language/locallang_db.xlf:tx_jvadvent_domain_Model_Advent.rangemax',
                'config' => array (
                    'type' => 'number',
                    'size' => '10',
                    'default' => '',
                )
            ),
            'storeonpid' => array (
                'exclude' => 0,
                'label' => 'LLL:EXT:jvadvent/Resources/Private/Language/locallang_db.xlf:tx_jvadvent_domain_Model_Advent.storeonpid',
                'config' => array (
                    'type' => 'group',
                    'size' => '1',
                    'maxitems' => '1',
                    'allowed' => 'pages',
                    'default' => '0',
                    'suggestOptions' => [

                        'pages' => [
                            'searchCondition' => 'doktype=254' ,
                            'pidList' => '13',
                            'pidDepth' => 10
                        ]
                    ]
                )
            ),



        ),
        'types' => array(
            '0' => array('showitem' => 'sys_language_uid, l18n_parent, hidden, title, date,  desc_long, image,  desc_short, solution,
            --div--;Answers,answer1,answer2,answer3,answer4,answer5,correct,rangemin,rangemax,storeonpid')
        ),
        'palettes' => array(
            '1' => array('showitem' => '')
        )
);
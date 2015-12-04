<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_nemadvent_domain_model_advent'] = array(
	'ctrl' => $TCA['tx_nemadvent_domain_model_advent']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'date,title,correct,pid,storeonpid'
	),
	'columns' => array(
		'sys_language_uid' => Array (
			'exclude' => 0,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => Array(
					Array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
					Array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
				)
			)
		),
		'l18n_parent' => Array (
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 0,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('', 0),
				),
				'foreign_table' => 'tx_nemadvent_domain_model_advent',
				'foreign_table_where' => 'AND tx_nemadvent_domain_model_advent.uid=###REC_FIELD_l18n_parent### AND tx_nemadvent_domain_model_advent.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => Array(
			'config'=>array(
				'type'=>'passthrough'
			)
		),
		'hidden' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array(
				'type' => 'check'
			)
		),
		'title' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_Advent.title',
			'config'  => array(
				'type' => 'input',
				'size' => 40,
				'eval' => 'trim,required',
				'max'  => 256
			)
		),

		'date' => array (
			'exclude' => 0,
			'l10n_mode' => 'mergeIfNotBlank',
			'label'   => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_Advent.date',
			'config' => array (
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'eval'     => 'date,required',
				'checkbox' => '0',
				'default'  => '0'
			)
		),

		'desc_short' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_Advent.desc_short',
			'config' => array (
				'type' => 'text',
				'cols' => '48',
				'rows' => '8',
				'wizards' => Array(
					'_PADDING' => 4,
					'RTE' => Array(
						'notNewRecords' => 1,
						'RTEonly' => 1,
						'type' => 'script',
						'title' => 'LLL:EXT:cms/locallang_ttc.php:bodytext.W.RTE',
						'icon' => 'wizard_rte2.gif',
						'script' => 'wizard_rte.php',
					),
				)
			)
		),

		'desc_long' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_Advent.desc_long',
			'config' => array (
				'type' => 'text',
				'cols' => '48',
				'rows' => '20',
				'wizards' => Array(
					'_PADDING' => 4,
					'RTE' => Array(
						'notNewRecords' => 1,
						'RTEonly' => 1,
						'type' => 'script',
						'title' => 'LLL:EXT:cms/locallang_ttc.php:bodytext.W.RTE',
						'icon' => 'wizard_rte2.gif',
						'script' => 'wizard_rte.php',
					),
				)
			)
		),

		'solution' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_Advent.solution',
			'config' => array (
				'type' => 'text',
				'cols' => '48',
				'rows' => '20',
				'wizards' => Array(
					'_PADDING' => 4,
					'RTE' => Array(
						'notNewRecords' => 1,
						'RTEonly' => 1,
						'type' => 'script',
						'title' => 'LLL:EXT:cms/locallang_ttc.php:bodytext.W.RTE',
						'icon' => 'wizard_rte2.gif',
						'script' => 'wizard_rte.php',
					),
				)
			)
		),

		'image' => array(
			'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_Advent.image',
			'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
				'tx_nemadvent_domain_model_advent_image',
				array('maxitems' => 4),
				$GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
			)
		),

		'viewed' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_Advent.viewed',
			'config' => array (
				'type' => 'input',
				'size' => '8',
			)
		),
		'answer1' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_Advent.answer1',
			'config' => array (
				'type' => 'text',
				'cols' => '48',
				'rows' => '2',
			)
		),
		'answer2' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_Advent.answer2',
			'config' => array (
				'type' => 'text',
				'cols' => '48',
				'rows' => '2',
			)
		),
		'answer3' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_Advent.answer3',
			'config' => array (
				'type' => 'text',
				'cols' => '48',
				'rows' => '2',
			)
		),
		'answer4' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_Advent.answer4',
			'config' => array (
				'type' => 'text',
				'cols' => '48',
				'rows' => '2',
			)
		),		
		'answer5' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_Advent.answer5',
			'config' => array (
				'type' => 'text',
				'cols' => '48',
				'rows' => '2',
			)
		),						
		'correct' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_Advent.correct',
			'config' => array (
				'type' => 'input',
				'size' => '10',
				'default' => '',
			)
		),
		'rangemin' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_Advent.rangemin',
			'config' => array (
				'type' => 'input',
				'size' => '10',
				'default' => '',
				'eval' => 'int',
			)
		),
		'rangemax' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_Advent.rangemax',
			'config' => array (
				'type' => 'input',
				'size' => '10',
				'default' => '',
				'eval' => 'int',
			)
		),
		'storeonpid' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_Advent.storeonpid',
			'config' => array (
				'type' => 'group',
				'size' => '1',
				'maxitems' => '1',
				'internal_type' => 'db',
				'allowed' => 'pages',
				'default' => '0',
			)
		),	
			

		'categories' => array (
			'exclude' => 0,
			'l10n_mode' => 'exclude',
			'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_Advent.categories',
			'config' => array(
				'type' => 'group',
				'eval' => 'required',
				'internal_type' => 'db',
				'allowed' => 'tx_nemadvent_domain_model_adventcat',
				'size' => 1,
				'maxitems' => 1,
				'autoSizeMax' => 1,
				'multiple' => 0,
				'foreign_table' => 'tx_nemadvent_domain_model_adventcat',
				'MM' => 'tx_nemadvent_advent_adventcat_mm',
			)
		),
		

	),
	'types' => array(
		'0' => array('showitem' => 'hidden, categories, title, date,  desc_long;;4;richtext:rte_transform[flag=rte_enabled|mode=ts], image,  desc_short;;4;richtext:rte_transform[flag=rte_enabled|mode=ts], solution;;4;richtext:rte_transform[flag=rte_enabled|mode=ts],
		--div--;Answers,answer1,answer2,answer3,answer4,answer5,correct,rangemin,rangemax,storeonpid')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);

$TCA['tx_nemadvent_domain_model_adventcat'] = array(
	'ctrl' => $TCA['tx_nemadvent_domain_model_adventcat']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'title,startdate,enddate,days'
	),
	'columns' => array(
		'sys_language_uid' => Array (
			'exclude' => 0,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => Array(
					Array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
					Array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
				)
			)
		),
		'l18n_parent' => Array (
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 0,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => Array (
				'type' => 'select',
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
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array(
				'type' => 'check'
			)
		),
		'title' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_Adventcat.title',
			'config'  => array(
				'type' => 'input',
				'size' => 40,
				'eval' => 'trim,required',
				'max'  => 256
			)
		),
		'startdate' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_Adventcat.startdate',
			'config'  => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'datetime,required',
				'max'  => 20
			)
		),		
		'enddate' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_Adventcat.enddate',
			'config'  => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'datetime,required',
				'max'  => 20
			)
		),				
		'days' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_Adventcat.days',
			'config'  => array(
				'type' => 'input',
				'size' => 3,
				'default' => 24,
				'eval' => 'integer,required',
				'max'  => 3
			)
		),			
		
		'advents' => array(
			'l10n_mode' => 'exclude',
			'config' => array(
				'type' => 'passthrough',
			)
		),
	),
	'types' => array(
		'1' => array('showitem' => 'hidden, title, startdate, enddate, days')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);

$TCA['tx_nemadvent_domain_model_winner'] = array(
	'ctrl' => $TCA['tx_nemadvent_domain_model_winner']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'date,feuser_uid,title,desc_short,sys_language_uid,hidden,sorting,points'
	),
	'columns' => array(
		'sys_language_uid' => Array (
			'exclude' => 0,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => Array(
					Array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
					Array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
				)
			)
		),
		'l18n_parent' => Array (
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 0,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => Array (
				'type' => 'select',
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
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array(
				'type' => 'check'
			)
		),
		'title' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_Winner.prize',
			'config'  => array(
				'type' => 'input',
				'size' => 40,
				'eval' => 'trim',
				'max'  => 256
			)
		),
		'desc_short' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_Winner.text',
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
			'label'   => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_Winner.date',
			'config'  => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'datetime',
				'max'  => 20
			)
		),		
		'feuser_uid' => array (
			'exclude' => 0,
			'label'   => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_Winner.winner_uid',
			'config' => array (
				'type' => 'input',
				'size' => 10,
				'eval' => 'required',
				'maxitem' => 1,
			)
		),
		'sorting' => array (
			'exclude' => 0,
			'label'   => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_Winner.sorting',
			'config' => array (
				'type' => 'input',
				'size' => 11,
				'eval' => 'required',
				'maxitem' => 1,
			)
		),	
		'points' => array (
			'exclude' => 0,
			'label'   => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_Winner.points',
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

$TCA['tx_nemadvent_domain_model_user'] = array (
	'ctrl' => $TCA['tx_nemadvent_domain_model_user']['ctrl'],
	'default_sortby' =>  'ORDER BY points DESC, tstamp, sys_language_uid',
	'interface' => array (
		'showRecordFieldList' => 'feuser_uid,customerno,usergroup,sys_language_uid,points,question_uid,question_date,question_datef,advent_uid,answer_uid'
	),
	'feInterface' => $TCA['tx_nemadvent_domain_model_user']['feInterface'],
	
	'columns' => array (
		'feuser_uid' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_User.feuser_uid',
			'config' => array (
				'type' => 'input',
				'size' => 11,
				'maxitem' => 11,
			)
		),	
		'uid' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_User.uid',
			'config' => array (
				'type' => 'input',
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'sys_language_uid' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_User.sys_language_uid',
			'config' => array (
				'type' => 'input',
				'size' => 11,
				'maxitem' => 11,
			)
		),

		'usergroup' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_User.usergroup',
			'config' => array (
				'type' => 'input',
				'size' => 11,
				'maxitem' => 11,
			)
		),
		'customerno' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_User.customerno',
			'config' => array (
				'type' => 'input',
				'size' => 11,
				'maxitem' => 11,
			)
		),						
		'question_uid' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_User.question_uid',
			'config' => array (
				'type' => 'input',
				'size' => 11,
				'maxitem' => 11,
			)
		),			
		'question_date' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_User.question_date',
			'config' => array (
				'type' => 'input',
				'size' => 11,
				'maxitem' => 11,
				'eval' => 'date',
			)
		),		
		'question_datef' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_User.question_datef',
			'config' => array (
				'type' => 'input',
				'size' => 10,
				'maxitem' => 10,
			)
		),
		'advent_uid' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_User.advent_uid',
			'config' => array (
				'type' => 'input',
				'size' => 11,
				'maxitem' => 1,
			)
		),			
		'answer_uid' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_User.answer_uid',
			'config' => array (
				'type' => 'input',
				'size' => 11,
				'maxitem' => 11,
			)
		),		


		'points' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_User.points',
			'config' => array (
				'type' => 'input',
				'size' => 11,
				'maxitem' => 11,
			)
		),	
		'subpoints' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_User.subpoints',
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

?>
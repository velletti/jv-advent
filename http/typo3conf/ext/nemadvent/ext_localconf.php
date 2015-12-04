<?php

if(!defined('TYPO3_MODE')) Die ('Access denied.');

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Pi1',
	array (
		'Advent'		=>	'list,single,listAnswers,showCalendar',
		'User'			=>	'answer',
		'Adventcat'		=>	'list',
		'Winner'		=>	'list,listall',
	),
	array (
		'Advent'		=>	'list,single,listAnswers',
		'User'			=>	'answer',
		'Adventcat'		=>	'list',
		'Winner'		=>	'listall',

	)
);

?>
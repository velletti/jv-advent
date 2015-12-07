<?php

if(!defined('TYPO3_MODE')) Die ('Access denied.');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
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
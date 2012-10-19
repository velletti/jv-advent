<?php

if(!defined('TYPO3_MODE')) Die ('Access denied.');

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Pi1',
	array (
		'Advent'		=>	'list,single',
		'User'			=>	'answer,',
		'Adventcat'		=>	'list',
		'Winner'		=>	'list,listall',
	),
	array (
		'Advent'		=>	'list,single,winners',
		'User'			=>	'answer',
		'Adventcat'		=>	'list',
		'Winner'		=>	'',

	)
);

?>
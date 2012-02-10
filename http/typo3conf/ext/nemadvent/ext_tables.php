<?php

if(!defined('TYPO3_MODE')) Die ('Access denied.');

// include static typoscript
t3lib_extMgm::addStaticFile ($_EXTKEY, 'Configuration/TypoScript', 'Nem Advent');

// plugin registrieren
Tx_Extbase_Utility_Extension::registerPlugin ($_EXTKEY, 'Pi1', 'Display Advent');

$extensionName = t3lib_div::underscoredToUpperCamelCase($_EXTKEY);
$pluginSignature = strtolower($extensionName) . '_pi1';

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_list.xml');

// tca
// Tx_Nemadvent_Domain_Model_Advent
t3lib_extMgm::allowTableOnStandardPages('tx_nemadvent_domain_model_advent');
$TCA['tx_nemadvent_domain_model_advent'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_Advent',
		'label' 			=> 'title',
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'languageField' 	=> 'sys_language_uid',
		'transOrigPointerField' 	=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'delete' 			=> 'deleted',
		'dividers2tabs'     => true,
		'enablecolumns' 	=> array(
			'disabled' => 'hidden'
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tca.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/icon_tx_nemadvent_domain_model_advent.gif'
	)
);

// Tx_Nemadvent_Domain_Model_Adventcat
t3lib_extMgm::allowTableOnStandardPages('tx_nemadvent_domain_model_adventcat');
$TCA['tx_nemadvent_domain_model_adventcat'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_Adventcat',
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
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tca.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/icon_tx_nemadvent_domain_model_adventcat.gif'
	)
);
t3lib_extMgm::allowTableOnStandardPages('tx_nemadvent_domain_model_winner');
$TCA['tx_nemadvent_domain_model_winner'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_Winner.winner',
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
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tca.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/icon_tx_nemadvent_domain_model_winner.gif'
	)
);

// Tx_Nemadvent_Domain_Model_User
t3lib_extMgm::allowTableOnStandardPages('tx_nemadvent_domain_model_user');
$TCA['tx_nemadvent_domain_model_user'] = array (
	'ctrl' => array (
		'title'		=> 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_User',
		'label'     => 'uid',
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tca.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/icon_tx_nemadvent_domain_model_user'
	)
);

?>
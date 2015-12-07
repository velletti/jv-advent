<?php

if(!defined('TYPO3_MODE')) Die ('Access denied.');

// include static typoscript
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile ($_EXTKEY, 'Configuration/TypoScript', 'Nem Advent');

// plugin registrieren
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin ($_EXTKEY, 'Pi1', 'Display Advent');

$extensionName = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($_EXTKEY);
$pluginSignature = strtolower($extensionName) . '_pi1';

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_list.xml');

// tca
// Tx_Nemadvent_Domain_Model_Advent
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nemadvent_domain_model_advent');
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
		'sortby' 			=> 'sorting',
		'default_sortby' 			=> 'ORDER BY date',
		'dividers2tabs'     => true,
		'enablecolumns' 	=> array(
			'disabled' => 'hidden'
		),
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/tca.php',
		'iconfile' 			=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/icon_tx_nemadvent_domain_model_advent.gif'
	)
);

// Tx_Nemadvent_Domain_Model_Adventcat
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nemadvent_domain_model_adventcat');
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
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/tca.php',
		'iconfile' 			=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/icon_tx_nemadvent_domain_model_adventcat.gif'
	)
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nemadvent_domain_model_winner');
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
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/tca.php',
		'iconfile' 			=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/icon_tx_nemadvent_domain_model_winner.gif'
	)
);

// Tx_Nemadvent_Domain_Model_User
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nemadvent_domain_model_user');
$TCA['tx_nemadvent_domain_model_user'] = array (
	'ctrl' => array (
		'title'		=> 'LLL:EXT:nemadvent/Resources/Private/Language/locallang_db.xml:Tx_Nemadvent_Domain_Model_User',
		'label'     => 'uid',
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/tca.php',
		'iconfile' 			=> \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/icon_tx_nemadvent_domain_model_user'
	)
);

?>
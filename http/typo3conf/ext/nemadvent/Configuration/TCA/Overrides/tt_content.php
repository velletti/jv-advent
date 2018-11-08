<?php
defined('TYPO3_MODE') or die();

$_EXTKEY ="nemadvent" ;
$extensionName = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($_EXTKEY);
$pluginSignature = strtolower($extensionName) . '_pi1';

// plugin registrieren
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin ($_EXTKEY, 'Pi1', 'Display Advent');

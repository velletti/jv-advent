<?php
defined('TYPO3_MODE') or die();

$extensionName = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase("nemadvent");
$pluginSignature = strtolower($extensionName) . '_pi1';

// plugin registrieren
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin ("nemadvent", 'Pi1', 'Display Advent');

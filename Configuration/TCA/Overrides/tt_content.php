<?php
defined('TYPO3') or die();

$extensionName = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase("jv-advent");
$pluginSignature = strtolower($extensionName) . '_pi1';

// plugin registrieren
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin ("jv-advent", 'Calendar', 'Advent');


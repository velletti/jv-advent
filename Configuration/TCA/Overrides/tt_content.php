<?php
defined('TYPO3') or die();


// plugin registrieren - Namen müssen mit ext_localconf.php übereinstimmen
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Jvadvent', 'Calendar', 'Advent Calendar' , 'extension-jvadvent',  \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT);
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin('Jvadvent', 'Winner', 'Advent Winners', 'extension-jvadvent',  \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT);
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin('Jvadvent', 'Solution', 'Solutions', 'extension-jvadvent',  \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT);
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin('Jvadvent', 'User', 'User Answer', 'extension-jvadvent',  \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT);

$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['jvadvent_calendar'] = 'extension-jvadvent';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'jvadvent_calendar',
    'FILE:EXT:jvadvent/Configuration/FlexForms/flexform_calendar.xml'
);

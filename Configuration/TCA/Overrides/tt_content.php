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
    '*',
    'FILE:EXT:jvadvent/Configuration/FlexForms/flexform_calendar.xml',
    'jvadvent_calendar',
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.plugin, pi_flexform',
    'jvadvent_calendar',
    'after:palette:headers'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.plugin, pi_flexform',
    'jvadvent_solution',
    'after:palette:headers'
);

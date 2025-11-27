<?php
defined('TYPO3') or die();


// plugin registrieren - Namen müssen mit ext_localconf.php übereinstimmen
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin('Jvadvent', 'Calendar', 'Advent Calendar');
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin('Jvadvent', 'Winner', 'Advent Winners');
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin('Jvadvent', 'Solution', 'Solutions');

$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['jvadvent_calendar'] = 'extension-jvadvent';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'jvadvent_calendar',
    'FILE:EXT:jvadvent/Configuration/FlexForms/flexform_calendar.xml'
);

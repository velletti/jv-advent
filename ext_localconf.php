<?php

if(!defined('TYPO3')) Die ('Access denied.');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'JvAdvent' ,
	'Calendar',
	array (
		\Jvelletti\JvAdvent\Controller\AdventController::class		=>	'single,showCalendar',
        \Jvelletti\JvAdvent\Controller\UserController::class			=>	'answer',
	),
    array (
        \Jvelletti\JvAdvent\Controller\AdventController::class		=>	'single',
        \Jvelletti\JvAdvent\Controller\UserController::class			=>	'answer',
    ),
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'JvAdvent' ,
    'Solution',
    array (
        \Jvelletti\JvAdvent\Controller\AdventController::class		=>	'listAnswers',
    ),
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'JvAdvent' ,
    'Winner',
    array (
        \Jvelletti\JvAdvent\Controller\WinnerController::class		=>	'list,listall',
    ),
    array (
        \Jvelletti\JvAdvent\Controller\WinnerController::class		=>	'',
    ),
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);



$iconRegistry =
    \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);

$iconRegistry->registerIcon(
    'extension-jvadvent',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:jv-advent/Resources/Public/Icons/Extension.svg']
);

// wizards
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
    'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    jvchat {
                        iconIdentifier = extension-jvadvent
                        title = Aventskalender
                        tt_content_defValues {
                            CType = jv-advent_calendar
                        }
                    }
                }
                show = *
            }
       }'
);
// wizards
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
    'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    jvchat {
                        iconIdentifier = extension-jvadvent
                        title = Advent Solutions
                        tt_content_defValues {
                            CType = jv-advent_solution
                        }
                    }
                }
                show = *
            }
       }'
);
<?php

if(!defined('TYPO3')) Die ('Access denied.');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Jvadvent' ,
	'Calendar',
	array (
		\Jvelletti\JvAdvent\Controller\AdventController::class		=>	'showCalendar,single',
        \Jvelletti\JvAdvent\Controller\UserController::class			=>	'answer',
	),
    array (
        \Jvelletti\JvAdvent\Controller\AdventController::class		=>	'single',
        \Jvelletti\JvAdvent\Controller\UserController::class			=>	'answer',
    ),
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Jvadvent' ,
    'Solution',
    array (
        \Jvelletti\JvAdvent\Controller\AdventController::class		=>	'listAnswers',
    ),
    array (
        \Jvelletti\JvAdvent\Controller\AdventController::class		=>	'listAnswers',
    ),
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Jvadvent' ,
    'Winner',
    array (
        \Jvelletti\JvAdvent\Controller\WinnerController::class		=>	'list,listall',
    ),
    array (
        \Jvelletti\JvAdvent\Controller\WinnerController::class		=>	'',
    ),
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);


// wizards
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
    'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    jvadvent_calendar {
                        iconIdentifier = extension-jvadvent
                        title = Aventskalender
                        tt_content_defValues {
                            CType = list
                            list_type = jvadvent_calendar
                        }
                    }
                    jvadvent_solutions {
                        iconIdentifier = extension-jvadvent
                        title = Advent Calendar Solutions
                        tt_content_defValues {
                            CType = list
                            list_type = jvadvent_solution
                        }
                    }
                    jvadvent_winner {
                        iconIdentifier = extension-jvadvent
                        title = Advent Calendar Winner
                        tt_content_defValues {
                            CType = list
                            list_type = jvadvent_winner
                        }
                    }
                }
                show = *
            }
       }'
);
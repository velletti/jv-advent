<?php

if(!defined('TYPO3')) Die ('Access denied.');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Jvadvent' ,
	'Calendar',
	array (
		\Jvelletti\JvAdvent\Controller\AdventController::class		=>	'showCalendar'
	),
    array (
    ),
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Jvadvent' ,
    'Solution',
    array (
        \Jvelletti\JvAdvent\Controller\AdventController::class		    =>	'listAnswers,single',
    ),
    array (
        \Jvelletti\JvAdvent\Controller\AdventController::class		    =>	'listAnswers,single',
    ),
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Jvadvent' ,
    'User',
    array (
        \Jvelletti\JvAdvent\Controller\UserController::class			=>	'answer',
    ),
    array (
        \Jvelletti\JvAdvent\Controller\UserController::class			=>	'answer',
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
            
            wizards.newContentElement.wizardItems.akr {
                header = Adventskalender
                elements {
                    jvadvent_calendar {
                        iconIdentifier = extension-jvadvent
                        title = Aventskalender
                        description = Fügt einen Adventskalender ein.
                        tt_content_defValues {
                            CType = jvadvent_calendar
                        }
                    }
                    jvadvent_solutions {
                        iconIdentifier = extension-jvadvent
                        title = Advent Calendar Solutions
                        description = Zeigt Liste aller Fragen (und nach Ende auch Antworten) des Adventskalenders ein.
                        tt_content_defValues {
                            CType = jvadvent_solution
                        }
                    }
                    jvadvent_user {
                        iconIdentifier = extension-jvadvent
                        title = Advent Calendar User Answer(s)
                        tt_content_defValues {
                            CType = jvadvent_user
                        }
                    }
                    jvadvent_winner {
                        iconIdentifier = extension-jvadvent
                        title = Advent Calendar Winner
                        tt_content_defValues {
                            CType = jvadvent_winner
                        }
                    }
                }
                show = *
            }
            wizards.newContentElement := addToList(Akr)
       }'
);
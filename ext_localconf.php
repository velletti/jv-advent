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

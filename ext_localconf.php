<?php

if(!defined('TYPO3')) Die ('Access denied.');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Nemadvent' ,
	'Calendar',
	array (
		\Allplan\Nemadvent\Controller\AdventController::class		=>	'single,showCalendar',
        \Allplan\Nemadvent\Controller\UserController::class			=>	'answer',
	),
    array (
        \Allplan\Nemadvent\Controller\AdventController::class		=>	'single',
        \Allplan\Nemadvent\Controller\UserController::class			=>	'answer',
    )
);
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Nemadvent' ,
    'Solution',
    array (
        \Allplan\Nemadvent\Controller\AdventController::class		=>	'listAnswers',
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Nemadvent' ,
    'Winner',
    array (
        \Allplan\Nemadvent\Controller\WinnerController::class		=>	'list,listall',
    ),
    array (
        \Allplan\Nemadvent\Controller\WinnerController::class		=>	'',
    )
);
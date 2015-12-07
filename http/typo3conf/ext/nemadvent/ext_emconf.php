<?php

########################################################################
# Extension Manager/Repository config file for ext "nemadvent".
#
# Auto generated 21-09-2010 09:46
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Nemetschek Advent',
	'description' => 'Creates a aventskalender page',
	'category' => 'plugin',
	'shy' => 0,
	'version' => '6.2.1',
	'dependencies' => 'cms,extbase,fluid',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'alpha',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearcacheonload' => 1,
	'lockType' => '',
	'author' => 'Joerg velletti',
	'author_email' => 'jvelletti@allplan.com',
	'author_company' => 'Allplan GmbH',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'cms' => '',
			'php' => '5.3.0-0.0.0',
			'typo3' => '6.2.0-6.9.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:65:{s:16:"ext_autoload.php";s:4:"a9d4";s:21:"ext_conf_template.txt";s:4:"da83";s:12:"ext_icon.gif";s:4:"cb93";s:17:"ext_localconf.php";s:4:"2a37";s:14:"ext_tables.php";s:4:"fe8e";s:14:"ext_tables.sql";s:4:"3b7f";s:37:"Classes/Controller/BaseController.php";s:4:"e9c3";s:42:"Classes/Controller/adventCatController.php";s:4:"124f";s:39:"Classes/Controller/adventController.php";s:4:"82b8";s:31:"Classes/Domain/Model/advent.php";s:4:"b854";s:34:"Classes/Domain/Model/adventCat.php";s:4:"aac4";;s:4:"e064";s:49:"Classes/Domain/Repository/adventCatRepository.php";s:4:"145a";s:46:"Classes/Domain/Repository/adventRepository.php";s:28:"Classes/Utility/FeGroups.php";s:4:"3386";s:45:"Classes/ViewHelpers/PageBrowserViewHelper.php";s:4:"beb4";s:45:"Classes/ViewHelpers/Form/SelectViewHelper.php";s:4:"dd8d";s:48:"Classes/ViewHelpers/Form/TextfieldViewHelper.php";s:4:"fe85";s:42:"Classes/ViewHelpers/Uri/FileViewHelper.php";s:4:"1699";s:41:"Configuration/FlexForms/flexform_list.xml";s:4:"5a98";s:25:"Configuration/TCA/tca.php";s:4:"d774";s:38:"Configuration/TypoScript/constants.txt";s:4:"7be5";s:34:"Configuration/TypoScript/setup.txt";s:4:"1bd3";s:40:"Resources/Private/Language/locallang.xml";s:4:"5d5e";s:43:"Resources/Private/Language/locallang_db.xml";s:4:"8b43";s:42:"Resources/Private/Partials/adventTags.html";s:4:"a828";s:42:"Resources/Private/Partials/listadvent.html";s:4:"2f8a";s:46:"Resources/Private/Partials/listadventSpecdate.html";s:4:"2b25";s:49:"Resources/Private/Partials/listadventSpecsorting.html";s:4:"2f8a";s:48:"Resources/Private/Partials/listadventViewed.html";s:4:"998b";s:46:"Resources/Private/Templates/Download/list.html";s:4:"42b3";s:48:"Resources/Private/Templates/Download/single.html";s:4:"e13f";s:49:"Resources/Private/Templates/DownloadCat/list.html";s:4:"b6de";s:46:"Resources/Private/Templates/advent/filter.html";s:4:"4632";s:44:"Resources/Private/Templates/advent/list.html";s:4:"87f0";s:46:"Resources/Private/Templates/advent/single.html";s:4:"69b5";s:43:"Resources/Private/Templates/advent/xml.html";s:4:"ed31";s:47:"Resources/Private/Templates/adventCat/list.html";s:4:"14af";s:44:"Resources/Public/Css/jquery.autocomplete.css";s:4:"719c";s:71:"Resources/Public/Icons/icon_tx_nemadvent_domain_model_advent.gif";s:4:"cb93";s:74:"Resources/Public/Icons/icon_tx_nemadvent_domain_model_adventcat.gif";s:4:"cb93";s:69:"Resources/Public/Icons/icon_tx_nemadvent_domain_model_winner.gif";s:4:"cb93";s:72:"Resources/Public/Icons/icon_tx_nemadvent_domain_model_user.gif";s:4:"cb93";s:4:"e01e";}',
	'suggests' => array(
	),
);

?>
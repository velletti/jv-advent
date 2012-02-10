<?php

/* * *************************************************************
 *  Copyright notice
 *

 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

/**
 * Controller for the winner object
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_Nemadvent_Controller_WinnerController extends Tx_Nemadvent_Controller_BaseController {

	/**
	 * @var Tx_Nemadvent_Domain_Model_AdventRepository
	 */
	protected $winnerRepository;

	/*
	 * @var Tx_Extbase_Domain_Repository_FrontendUserRepository
	 */
	protected $frontendUserRepository;

	/*
	 * @var Tx_Extbase_Domain_Repository_FrontendUserGroupRepository
	 */
	protected $frontendUserGroupRepository;

	/**
	 * Initializes the current action
	 *
	 * @return void
	 */
	public function initializeAction() {
		parent::initializeAction();
		$this->initCSS($this->settings['cssFiles']);
		$this->initJS($this->settings['jsFiles']);
		$GLOBALS['TSFE']->additionalHeaderData['Tx_Nemadvent_CSS'] = '<link rel="stylesheet" type="text/css" href="typo3conf/ext/nemadvent/Resources/Public/Css/tx_nemadvent.css" media="screen, projection" />'."\n";
		
		$this->winnerRepository = t3lib_div::makeInstance('Tx_Nemadvent_Domain_Repository_WinnerRepository');
		$this->frontendUserRepository = t3lib_div::makeInstance('Tx_Extbase_Domain_Repository_FrontendUserRepository');
		
		$this->adventCatRepository = t3lib_div::makeInstance('Tx_Nemadvent_Domain_Repository_AdventCatRepository');
		$this->frontendUserGroupRepository = t3lib_div::makeInstance('Tx_Extbase_Domain_Repository_FrontendUserGroupRepository');
		
		//overwrite setting Configuration

	}

	/**
	 * lists advents by category
	 *
	 * @return string The rendered view
	 */
	public function listAction( ) {
		//default values
		$doit = $this->settingsHelper( ) ;
		$winnerspid = ($this->settings['list']['pid']['winners'] == '' ) ? $this->pid : $this->settings['list']['pid']['winners'] ;
		
		$winners =  $this->winnerRepository->getWinnerlist($winnerspid);
		
		// count advents
		$count = count($winners);
		$winnerdata = array() ;
		for ( $i=0;$i< $count;$i++) {
			// echo "" . $winners[$i]->getFeuserUid() ;
			if ( $winners[$i]->getFeuserUid() > 0 ) {
				$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', 'fe_users', 'uid = "' . intval($winners[$i]->getFeuserUid()). '"' );
				$winnerdata[$i]['user'] = '' ;
				if ($GLOBALS['TYPO3_DB']->sql_num_rows($res) > 0) {
					$winnerdata[$i]['user'] = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
				} 
				if ( $winnerdata[$i]['user']['image'] == "") {
					if( $winnerdata[$i]['user']['tx_barafereguser_nem_gender'] == "0" ) {
						$winnerdata[$i]['user']['tx_mmforum_avatar'] = "fileadmin/templates_connect/img/Avatar_Man.png" ;
					} else {
						$winnerdata[$i]['user']['tx_mmforum_avatar'] = "fileadmin/templates_connect/img/Avatar_Woman.png" ;
						
					}
				} else {
					if ( preg_match("/tx_barafeprofileuser/", $winnerdata[$i]['user']['image'] )) {
						$winnerdata[$i]['user']['tx_mmforum_avatar'] = $winnerdata[$i]['user']['image'] ;
					} else {
						$winnerdata[$i]['user']['tx_mmforum_avatar'] = 'uploads/tx_barafeprofileuser/' . $winnerdata[$i]['user']['image'] ;
					}
				}
				
				//debug($winners[$i] );
				$winnerdata[$i]['prize'] =  $winners[$i] ;
				$winnerdata[$i]['user']['dateformated'] =  date( "d.m.Y" ,$winners[$i]->getDate()  );
				
			}
		}
	//	debug($winnerdata) ;
		$this->view->assign('winnerdata', $winnerdata);
		
		
		$this->view->assign('count', $count);
		
		$this->view->assign('settings', $this->settings);
	}

		


}

?>
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
 * Controller for the advent object
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_Nemadvent_Controller_AdventController extends Tx_Nemadvent_Controller_BaseController {

	/**
	 * @var Tx_Nemadvent_Domain_Model_AdventRepository
	 */
	protected $adventRepository;
	
		/**
	 * @var Tx_Nemadvent_Domain_Model_UserRepository
	 */
	protected $userRepository;
	
	/**
	 * @var Tx_Nemadvent_Domain_Model_AdventCatRepository
	 */
	protected $adventCatRepository;
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
		$GLOBALS['TSFE']->additionalHeaderData['Tx_Nemadvent_CSS'] = '<link rel="stylesheet" type="text/css" href="typo3conf/ext/nemadvent/Resources/Public/Css/tx_nemadvent.css" media="screen, projection" />'."\n";

		$this->adventRepository = t3lib_div::makeInstance('Tx_Nemadvent_Domain_Repository_AdventRepository');
		$this->adventCatRepository = t3lib_div::makeInstance('Tx_Nemadvent_Domain_Repository_AdventCatRepository');
		$this->userRepository = t3lib_div::makeInstance('Tx_Nemadvent_Domain_Repository_UserRepository');
		
		$this->frontendUserRepository = t3lib_div::makeInstance('Tx_Extbase_Domain_Repository_FrontendUserRepository');
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
		$this->view->assign('settings', $this->settings);
	}

	/**
	 * single action for this controller.
	 *
	 * @return string The rendered view
	 */
	public function singleAction() {
		
		$doit = $this->settingsHelper( ) ;
				$adddate = 0 ;
		
			if ( $this->request->hasArgument('single') ) {
				
				$adddate_arr = $this->request->getArgument('single') ;
				if (is_array($adddate_arr)) {
					$adddate = $adddate_arr['adddate'];
				}
				if ( $adddate >  ( $this->adventCat->getDays() -1 )) {
					$adddate = $this->adventCat->getDays() - 1 ;
				}	
				if ( $this->isnem  ) {
					if ( $adddate < 0 ) {
						$this->settings['today']   =  mktime( 0,0,0, date("m" ) ,(date("d" ) + $adddate  ) ,date("Y" )  ) ;
					} else {
						$this->settings['today']   = mktime( 0,0,0, date("m" , $this->adventCat->getStartdate()) ,$adddate + date("d" ,$this->adventCat->getStartdate() ) ,date("Y" ,$this->adventCat->getStartdate())  ) ;
							
					}
				} else {
					if ( $adddate > -4 AND $adddate < 0 ) {
						$this->settings['today']   =  mktime( 0,0,0, date("m" ) ,(date("d" ) + $adddate  ) ,date("Y" )  ) ;
					}
				}
			} else {
				if ( $this->request->hasArgument('yesterday') ) {
					$this->settings['today']   = mktime( 0,0,0, date("m" ) ,(date("d" ) -1) ,date("Y" )  ) ;
				} else {			
					$this->settings['today']   = mktime( 0,0,0, date("m" ) ,(date("d" ) ) ,date("Y" )  ) ;
				}
			}	
		

		// 11.10.2011 :
		//  $this->settings['today']   =  1318284000 ;
		$this->settings['todayformated']   =  date( "d.m.Y" , $this->settings['today'] ) ;
		if ( $this->adventCat ) {
			$question =  $this->adventRepository->findOneByFilter( $this->adventCat , $this->settings['today'] );
		// count advents
			$count = count($question);
			$this->view->assign('question', $question[0]);
			$this->view->assign('adventCat', $this->adventCat );
			
	//		debug($question[0]) ;
		}
		
		$this->view->assign('settings', $this->settings);
		$this->view->assign('adddate', $adddate);
		
		$this->view->assign('isnem', $this->isnem);
		$this->view->assign('isnemintern', $this->isnemintern);

	}
}

?>
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
		$this->initJS($this->settings['jsFiles']);

		$this->adventRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Tx_Nemadvent_Domain_Repository_AdventRepository');
		$this->adventCatRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Tx_Nemadvent_Domain_Repository_AdventCatRepository');
		$this->userRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Tx_Nemadvent_Domain_Repository_UserRepository');
		
		$this->frontendUserRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Tx_Extbase_Domain_Repository_FrontendUserRepository');
		$this->frontendUserGroupRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Tx_Extbase_Domain_Repository_FrontendUserGroupRepository');
		
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
			// Neu : nur noch positive werte und adddate 3 liefert den 3.12. statt wie früher 4.12
			$adddate = $adddate -1 ;


		} else {
			$adddate = intval( date("d" )) -1  ;
		}
		// Was ist die maximale Anzahl an tagen ? normal 24. Also ab dem 25.
		if ( $adddate >  ( $this->adventCat->getDays()  )) {
			$adddate = $this->adventCat->getDays() -1  ;
		}

		// 7.10.2014 j.v. : rückwirkendes / Beantworten auch für Nicht Nemetschek MA
		$month = date("m" , $this->adventCat->getStartdate()) ;
		$this->settings['showtip']   =  FALSE ;
		if ( $this->isnem  ) {
			$this->settings['today']   = mktime( 0,0,0, $month ,$adddate + date("d" ,$this->adventCat->getStartdate() ) ,date("Y" ,$this->adventCat->getStartdate())  ) ;
			$this->settings['showtip']   =  TRUE  ;
		} else {
			$this->settings['today']   =  mktime( 0,0,0, $month , date("d" ) ,date("Y" )  ) ;
			if ($month == date("m" ) ) {
				$this->settings['today']   = mktime( 0,0,0, $month ,$adddate + date("d" ,$this->adventCat->getStartdate() ) ,date("Y" ,$this->adventCat->getStartdate())  ) ;
				if ( intval( date("d" , $this->settings['today'] ) ) >  intval( date("d")) + $this->settings['maxDaysInFuture'] ) {
					$this->settings['today']   =  mktime( 0,0,0, $month , date("d" ) ,date("Y" )  ) ;
				}
				if ( date("d" , $this->settings['today'] ) ==  date("d") ) {
					$this->settings['showtip']   =  TRUE  ;
				}
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

	/**
	 * single action for this controller.
	 *
	 * @return string The rendered view
	 */
	public function listAnswersAction() {

		$doit = $this->settingsHelper( ) ;
		$this->settings['today']   = mktime( 0,0,0, date("m" ) ,(date("d" ) ) ,date("Y" )  ) ;

		// 11.10.2011 :
		//  $this->settings['today']   =  1318284000 ;
		$this->settings['todayformated']   =  date( "d.m.Y" , $this->settings['today'] ) ;
		if ( $this->adventCat ) {
			$questions =  $this->adventRepository->findOneByFilter( $this->adventCat )->toArray() ;

			if ( $this->settings['feUserUid'] > 0) {

				if ( is_array($questions)) {

					for( $i=0;$i<count($questions);$i++) {
						$answer =  $this->userRepository->findAnswer( $this->adventCat, $this->settings['feUserUid'], $questions[$i]->getDate())->toArray();
						$answersAll =  $this->userRepository->findAnswer( $this->adventCat, 0 , $questions[$i]->getDate())->toArray();
						$answersCount = array ( 0 , 0 , 0 , 0 ,0 ) ;

						$correctArr = explode( "," , trim($questions[$i]->getCorrect()) . "," ) ;
						$questions[$i]->setCorrect1( trim($correctArr[0])) ;
						if ( intval( $correctArr[1]) > 0 ) {
							$questions[$i]->setCorrect2( trim($correctArr[1])) ;
						} else {
							$questions[$i]->setCorrect2( "-" ) ;
						}

						if ( is_array( $answersAll )) {
							for( $ii=0;$ii<count($answersAll);$ii++) {
								if ( is_object($answersAll[$ii])) {
									switch ($answersAll[$ii]->getAnswerUid()) {
										case 1:
											$answersCount[0]++ ;
											break;
										case 2:
											$answersCount[1]++ ;
											break;
										case 3:
											$answersCount[2]++ ;
											break;
										case 4:
											$answersCount[3]++ ;
											break;
										case 5:
											$answersCount[4]++ ;
											break;

										default:
											// j.v.: nix
											break;

									}
								}
							}
						}
						if ( count($answersAll)  > 0 ) {
							$questions[$i]->setAnswer1count( $answersCount[0] * 100 / count($answersAll) ) ;
							$questions[$i]->setAnswer2count( $answersCount[1] * 100 / count($answersAll) ) ;
							$questions[$i]->setAnswer3count( $answersCount[2] * 100 / count($answersAll) ) ;
							$questions[$i]->setAnswer4count( $answersCount[3] * 100 / count($answersAll) ) ;
							$questions[$i]->setAnswer5count( $answersCount[4] * 100 / count($answersAll) ) ;
							$questions[$i]->setTotalAnswers( count($answersAll)  ) ;
						}

						if(is_object($answer[0])) {
							// echo "<br>Line: " . __LINE__ . " : " . " File: " . __FILE__ . '<br>$questions[$i]->getDate() : ' . date("d.m.Y h:i" ,  $questions[$i]->getDate() ) . "<hr>";

							$questions[$i]->setUserAnswer($answer[0]->getAnswerUid() );

						} else {
							$questions[$i]->setUserAnswer( 0 );
						}
						
					}
				}
			}


			// count advents
			$count = count($questions);
			$this->view->assign('questions', $questions);
			$this->view->assign('adventCat', $this->adventCat );

			//		debug($count) ;
		}

		$this->view->assign('settings', $this->settings);

		$this->view->assign('isnemintern', $this->isnemintern);

	}

	/**
	 * Shows A calendar with doors. Actual Day gets special Class. Opened Doors of recent days are made with ajax ...
	 *
	 * @return string The rendered view
	 */
	public function showCalendarAction() {

		$doit = $this->settingsHelper( ) ;
		$adddate = 0 ;

		// just for testing if Opened Door / Today Door works
		if ( $this->request->hasArgument('single') ) {
			$adddate_arr = $this->request->getArgument('single') ;
			if (is_array($adddate_arr)) {
				$adddate = $adddate_arr['adddate'];
			}
			if ( $adddate >  ( $this->adventCat->getDays() -1 )) {
				$adddate = $this->adventCat->getDays() - 1 ;
			}

			if ( $adddate < 0 ) {
				$this->settings['today']   =  mktime( 0,0,0, date("m" ) ,(date("d" ) + $adddate  ) ,date("Y" )  ) ;
			} else {
				$this->settings['today']   = mktime( 0,0,0, date("m" , $this->adventCat->getStartdate()) ,$adddate + date("d" ,$this->adventCat->getStartdate() ) ,date("Y" ,$this->adventCat->getStartdate())  ) ;
			}
		}
		$questions = array() ;
		for($i=0;$i<28;$i++) {
			$questions[] = array( "day" => $i , "date" => mktime( 0,0,0,  date("m" , $this->adventCat->getStartdate()) , $i+1 ,date("Y" )  ) , 'today' => FALSE , 'daybefore' => FALSE) ;
			$question =  $this->adventRepository->findOneByFilter( $this->adventCat ,$questions[$i]['date'] )->toArray()  ;
			if ( count($question >0 )) {
				if(is_object($question[0])) {

					$questions[$i]['title'] = $question[0]->getTitle() ;
					$questions[$i]['dateF'] = date("d.m.Y" , $questions[$i]['date']) ;
					$questions[$i]['title'] = " : " . $questions[$i]['title']  ;
				}
			}
			if ( $this->settings['today'] == $questions[$i]['date'] ) {
				$questions[$i]['today'] = TRUE ;
				$questions[$i]['title'] = '' ;
			}
			if ( $this->settings['today'] > $questions[$i]['date'] ) {
				$questions[$i]['daybefore'] = TRUE ;

			} else {
				$questions[$i]['dateF'] = '' ;
				$questions[$i]['title'] = '' ;
			}



		}

		$this->view->assign('questions', $questions );
		// 11.10.2011 :
		//  $this->settings['today']   =  1318284000 ;
		$this->settings['todayformated']   =  date( "d.m.Y" , $this->settings['today'] ) ;
		$this->settings['today']   =  intval( date( "d" , $this->settings['today'] )) ;

		$this->view->assign('adventCat', $this->adventCat );

		$this->view->assign('settings', $this->settings);
		$this->view->assign('adddate', $adddate);

		$this->view->assign('isnem', $this->isnem);
		$this->view->assign('isnemintern', $this->isnemintern);

	}
}

?>
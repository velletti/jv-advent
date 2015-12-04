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
class Tx_Nemadvent_Controller_UserController extends Tx_Nemadvent_Controller_BaseController {

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

		$this->adventRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Tx_Nemadvent_Domain_Repository_AdventRepository');
		$this->adventCatRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Tx_Nemadvent_Domain_Repository_AdventCatRepository');
		$this->userRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Tx_Nemadvent_Domain_Repository_UserRepository');
		
		$this->frontendUserRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Tx_Extbase_Domain_Repository_FrontendUserRepository');
		$this->frontendUserGroupRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Tx_Extbase_Domain_Repository_FrontendUserGroupRepository');
		
		//overwrite setting Configuration

	}




	/**
	 * answer action for this controller.
	 *
	 * @param Tx_Nemadvent_Domain_Model_Advent advent
	 */
	public function answerAction() {
		$doit = $this->settingsHelper() ;
		$this->currentArguments = $this->request->getArguments();
		if ( $this->request->hasArgument('JSON')) {
			if ( $this->settings['feUserUid'] > 0 ) {
				$this->answers =  $this->userRepository->findMyanswers(
					$this->adventCat ,
					$this->settings['feUserUid'] );
				if ( is_array($this->answers) ) {
					$answerlist = "" ;
					$lastAnswer = "xyz" ;
					for ( $i=0;$i < count($this->answers) ; $i++ ) {
						if ($lastAnswer <> intval( $this->answers[$i]->getQuestionDatef()) ) {
							if ( $answerlist <> "") {
								$answerlist .= "," ;
							}
							// $answerlist  .= date( "j" , $this->answers[$i]->getQuestionDate() + 7201) ;
							// $lastAnswer = date( "j" , $this->answers[$i]->getQuestionDate()+7201) ;
							$answerlist  .= intval( $this->answers[$i]->getQuestionDatef() ) ;
							$lastAnswer = intval( $this->answers[$i]->getQuestionDatef()) ;
						}

					}
					$answerlist =  $answerlist  ;
				}
				$this->showArrayAsJson($answerlist) ;
				die;
			}
			die;
		}
		$answer = 0 ;
		$question = 0 ;




		if ( $this->request->hasArgument('question')) {
			$question = intval($this->request->getArgument('question')) ;
		}

		if ( $this->request->hasArgument('answer')) {
			
			$answer = intval($this->request->getArgument('answer')) ;
		}

		if ( $this->request->hasArgument('rangeanswer')) {
			$rangeanswer = intval($this->request->getArgument('rangeanswer')) ;
			$answer = $rangeanswer ;
		}

		if ( $answer > 0  OR $rangeanswer > 0 OR $question > 0 )  {
            // j.v. 7.10.2014 Nachträgliches Beantworten nicht nur für NEM !
            $question =  $this->adventRepository->findOneByFilter($this->adventCat , 0 , $question )->toArray();
/*
            if ( $this->isnem ) {
				$question =  $this->adventRepository->findOneByFilter($this->adventCat , 0 , $question )->toArray();
			//	debug( $question[0]->GetDate() ) ;
			//	die("is nem " . $this->request->getArgument('question'))  ;
			} else {
				if ( $this->request->hasArgument('adddate')) {
					$adddate = intval($this->request->getArgument('adddate')) ;
				}	
				if ( $adddate > -4 AND $adddate < 0 ){
					$this->settings['today']   = mktime( 0,0,0, date("m" ) ,(date("d" ) + $adddate) ,date("Y" )  ) ;
				}					
				
				$question =  $this->adventRepository->findOneByFilter($this->adventCat , $this->settings['today']  )->toArray();
			//	debug( $question[0]->GetDate() ) ;
			//	die("is NOT nem " . $this->request->getArgument('question'))  ;
			}
*/
		}
	
		

		if ( is_array ($question)) {
			// debug( $this->pid  ) ; 
			if ( $question[0]->GetStoreonpid() > 0 ) {
				$this->pid = intval( $question[0]->GetStoreonpid()) ;
			}
			$point = 0 ;
			$subpoint = 0 ;




			if ( $rangeanswer > 0) {

				// ToDO hierher die berechnung für die suppoints ... das sind die werte

				if ( $rangeanswer > $question[0]->getCorrect()  ) {
					$subpoint = (1 - ( $rangeanswer - $question[0]->getCorrect()) / ( $question[0]->getRangemax() - $question[0]->getCorrect() )) *99999 ;


				} else {
					$subpoint = (1 - (  $question[0]->getCorrect()- $rangeanswer ) / (  $question[0]->getCorrect() - $question[0]->getRangemin() )) *99999 ;
				}
				if ( $subpoint > 99999 ) {
					$subpoint = 99999 ;
				}
				if ( $subpoint < 1 ) {
					$subpoint = 1 ;
				}
				$subpoint = round( $subpoint , 0)  ;
			} else {
				$correctAnswer = $question[0]->getCorrect() ;
				$correctArr = explode("," , $correctAnswer . ",") ;

				for ( $i=0 ; $i< count($correctArr) ; $i++) {
					if ( intval( $correctArr[$i]) == $answer ){
						$point = 1 ;
					}
				}

				$subpoint = round( rand(0,4), 0)  ;
			}

			$userlog =  $this->userRepository->insertAnswer($this->adventCat , 
																$this->pid , $this->settings['feUserUid'] ,
																$question[0] , $point, $subpoint, $answer );


			if ( $userlog['TO-OLD'] > 0) {
				$this->flashMessageContainer->add( "Ihre Antwort wurde NICHT gespeichert da eine Änderung max innerhalb von 24h möglich ist! Gültig bleibt die bereits abgegebene Antwort vom " . date( "d.m.Y h:i" , $userlog["TO-OLD" ]) , '' , t3lib_FlashMessage::ERROR);
			} else {
				if ( $userlog) {

					$this->flashMessageContainer->add($this->translate('addanswer.WasSent'));
				} else {
					$this->flashMessageContainer->add('addanswer.WasNotStored: errorcode: U:' . $this->settings['feUserUid'] . "-A:" .  $answer . "-Q:" . $question[0]->getPid() , '' , t3lib_FlashMessage::ERROR);
				}
			}

		} else {
			if ( $answer > 0 ) {
				$this->flashMessageContainer->add('addanswer.WasNotSent: errorcode: U:' . $this->settings['feUserUid'] . "-A:" .  $answer . "-Q:" . $question[0]->getPid() , '' , t3lib_FlashMessage::ERROR);
			}
			
		}

		if ( $this->settings['feUserUid'] > 0 ) {
			$this->answers =  $this->userRepository->findMyanswers( 
									$this->adventCat ,
									$this->settings['feUserUid'] );
		
			$this->settings['today']   = mktime( 0,0,0, date("m" ) ,date("d" ) ,date("Y" )  ) ;
			$this->settings['total'] = 0 ;
			$this->settings['subtotal'] = 0 ;
			
			if ( is_array($this->answers) ) {
				for ( $i=0;$i < count($this->answers) ; $i++ ) {
					$answerlist[$i]['answer'] = $this->answers[$i] ;		
						
					$answerlist[$i]['answerPID'] = "" ;		
					if ($this->settings['isnem']  OR $this->answers[$i]->getQuestionDate() ==  $this->settings['today'] ) {
						$answerlist[$i]['answerPID'] = $this->settings['list']['pid']['singleView']  ;	
					} 		
					$answerlist[$i]['answerUID'] = $this->answers[$i]->getQuestionUid() ;	
					
					$answerlist[$i]['date'] = date ( "d.m.Y" , $this->answers[$i]->getQuestionDate() ) ;			
					$answerlist[$i]['myanswer'] = $this->answers[$i]->getAnswerUid()  ;
					$answerlist[$i]['adddate'] = date ( "j" , $this->answers[$i]->getQuestionDate() ) ;

					$question =  $this->adventRepository->findOneByFilter( $this->adventCat , 
														$this->answers[$i]->getQuestionDate()  );
					
					$answerlist[$i]['myanswerTEXT'] = "";
					if ( is_array($question)) {
						$answerlist[$i]['myanswerTEXT'] .= $question[0]->getMyanswertext( $answerlist[$i]['myanswer'] ) ;
						$correct= $question[0]->getCorrect( ) ;
					}

					
					if ( in_array($answerlist[$i]['myanswer'],explode("," ,  $correct ."," ))){
						$answerlist[$i]['points'] = 1 ;
					} else {
						$answerlist[$i]['points'] = 0 ;
					}
					
					if ( $this->settings['afterenddate'] ) {
						$answerlist[$i]['showpoint'] = $answerlist[$i]['points'] ;
						$this->settings['subtotal'] = intval( $this->settings['subtotal'] + $answerlist[$i]['points'] )  ;
						$this->settings['total'] = intval( $this->settings['total'] + $answerlist[$i]['points']) ;
						$this->settings['showtotal'] = 1 ;
					}

				}
				
			}	
			//overwrite Settings in view
			$this->settings['count'] = count($this->answers) ;
			$this->view->assign('settings', $this->settings);
			$this->view->assign('answerlist', $answerlist );
		}
	}

}

?>
<?php
namespace Jvelletti\JvAdvent\Controller;

use TYPO3\CMS\Core\Messaging\AbstractMessage;
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
class UserController extends BaseController {

	/**
	 * Initializes the current action
	 *
	 * @return void
	 */
	public function initializeAction(): void {
		parent::initializeAction();

	}




	/**
	 * answer action for this controller.
	 *
	 */
	public function answerAction(): \Psr\Http\Message\ResponseInterface {
		$doit = $this->settingsHelper() ;
		// First part: just return Json Array for Calender View
		$this->currentArguments = $this->request->getArguments();

		if ( $this->request->hasArgument('JSON')) {
            $answerlist = "" ;
            $lastAnswer = "xyz" ;
			if ( $this->settings['feUserUid'] > 0 ) {
				$this->answers =  $this->userRepository->findMyanswers( $this->settings['year'] , $this->settings['feUserUid'] );
				if ( is_array($this->answers) ) {

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

			}
            $this->showArrayAsJson($answerlist) ;
            die;
		}

		// second Part: TEST: did the user came here because he had answered a question ?
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

		if ( $answer > 0  || $rangeanswer > 0 || $question > 0 )  {
            /* @var ?\Jvelletti\JvAdvent\Domain\Model\Advent $question */
            $question =  $this->adventRepository->findOneByFilter( 0 , $question );
		}

		// Second Part : yes he has ansered a question ?
		if ( is_object ($question)) {
			if ( $question->GetStoreonpid() > 0 ) {
				$this->pid = intval( $question->GetStoreonpid()) ;
			}
			$point = 0 ;
			$subpoint = 0 ;
			if ( $rangeanswer > 0) {
				// ToDO hierher die berechnung für die suppoints ... das sind die werte
                // beispiel Range min = 100

                // Field "correct" Normally return a string to allow more than one answer correct. in case of RANGE it mus be converted to a number
                // to have a correct answer to a Question and a range between min and max, correct has f.e. 3,234234
                $correctAnswer = $question->getCorrect() ;
                $correctArr = explode("," , $correctAnswer . ",") ;
                $correctAnswer = intval(array_pop($correctArr)) ;
				if ( $rangeanswer > (int)$question->getCorrect()  ) {
					$subpoint = (1 - ( $rangeanswer - $correctAnswer) / ( $question->getRangemax() - $correctAnswer )) *99999 ;
				} else {
					$subpoint = (1 - (  $correctAnswer- $rangeanswer ) / (  $correctAnswer - $question->getRangemin() )) *99999 ;
				}
				if ( $subpoint > 99999 ) {
					$subpoint = 99999 ;
				}
				if ( $subpoint < 1 ) {
					$subpoint = 1 ;
				}
				$subpoint = round( $subpoint , 0)  ;
			} else {
				$correctAnswer = $question->getCorrect() ;
				$correctArr = explode("," , $correctAnswer . ",") ;
                if ( $answer > 0 && $answer < 6 ) {
                    for ( $i=0 ; $i< count($correctArr) ; $i++) {
                        if ( intval( $correctArr[$i]) == $answer ){
                            $point = 1 ;
                        }
                    }
                }


				$subpoint = round( rand(0,4), 0)  ;
			}

			$userlog =  $this->userRepository->insertAnswer(
																$this->pid , $this->settings['feUserUid'] ,
																$question , $point, $subpoint, $answer , $this->settings['year']  );

			if ( $userlog['TO-OLD'] > 0) {
				$this->addFlashMessage( "Ihre Antwort wurde NICHT gespeichert da eine Änderung max innerhalb von 24h möglich ist! Gültig bleibt die bereits abgegebene Antwort vom " . date( "d.m.Y h:i" , $userlog["TO-OLD" ]) , '' , \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::ERROR);
			} else {
				if ( $userlog) {

					$this->addFlashMessage($this->translate('addanswer.WasSent'));
				} else {
					$this->addFlashMessage('addanswer.WasNotStored: errorcode: U:' . $this->settings['feUserUid'] . "-A:" .  $answer . "-Q:" . $question->getPid() . "-R:" . $rangeanswer , '' , \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::ERROR);
				}
			}

		} else {
			if ( $answer > 0 ) {
				$this->addFlashMessage('addanswer.WasNotSent: errorcode: U:' . $this->settings['feUserUid'] . "-A:" .  $answer . "-Q:" . intval($this->request->getArgument('question'))  , '' , \TYPO3\CMS\Core\Type\ContextualFeedbackSeverity::ERROR);
			}
			
		}
		// third part: if he is logged in, show in any case the list of his answers  ( if Possible )

		if ( $this->settings['feUserUid'] > 0 ) {
			$this->answers =  $this->userRepository->findMyanswers(
                $this->settings['year'] ,
                $this->settings['feUserUid']
            );
		
			$this->settings['today']   = mktime( 0,0,0, date("m" ) ,date("d" ) ,date("Y" )  ) ;
			$this->settings['total'] = 0 ;
			$this->settings['subtotal'] = 0 ;
            $answerlist = [] ;
			if ( is_array($this->answers) ) {
				for ( $i=0;$i < count($this->answers) ; $i++ ) {
					$answerlist[$i]['answer'] = $this->answers[$i] ;		
						
					$answerlist[$i]['answerPID'] = "" ;
					
					if ($this->settings['isTester']  || $this->answers[$i]->getTstamp() >  ( time() - (60*60*24)) ) {
						$answerlist[$i]['answerPID'] = $this->settings['list']['pid']['singleView']  ;	
					} 		
					$answerlist[$i]['answerUID'] = $this->answers[$i]->getQuestionUid() ;	
					
					$answerlist[$i]['date'] = date ( "d.m.Y" , $this->answers[$i]->getQuestionDate() ) ;			
					$answerlist[$i]['crdate'] = $this->answers[$i]->getCrdate()  ;
					$answerlist[$i]['myanswer'] = $this->answers[$i]->getAnswerUid()  ;
					$answerlist[$i]['adddate'] = date ( "j" , $this->answers[$i]->getQuestionDate() ) ;

					$question =  $this->adventRepository->findOneByFilter( $this->answers[$i]->getQuestionDate()  );


					$answerlist[$i]['myanswerTEXT'] = "";

					if ( is_object($question) )  {
						if( $answerlist[$i]['myanswer'] > 0 and $answerlist[$i]['myanswer'] < 6) {
							$answerlist[$i]['myanswerTEXT'] .= $question->getMyanswertext( $answerlist[$i]['myanswer'] ) ;
						}
						$correct= $question->getCorrect( ) ;
					}

					if ( in_array($answerlist[$i]['myanswer'],explode("," ,  $correct ."," ))){
						$answerlist[$i]['points'] = 1 ;
					} else {
						$answerlist[$i]['points'] = 0 ;
					}
					
					if ( $this->settings['afterenddate'] ) {
						$answerlist[$i]['showpoint'] = $answerlist[$i]['points'] ;
						$this->settings['subtotal'] = intval( $this->settings['subtotal'] + $this->answers[$i]->getSubpoints() )  ;

                        $answerlist[$i]['subpoints'] = intval ( $this->answers[$i]->getSubpoints()  / 100 ) ;
                        if ( $answerlist[$i]['subpoints'] > 0 ) {
                            $answerlist[$i]['subpoints'] = "," . substr( "000" . trim( intval( $this->answers[$i]->getSubpoints() /100)) , -3 , 3 )  ;
                        }
						$this->settings['total'] = intval( $this->settings['total'] + $answerlist[$i]['points']) ;
						$this->settings['showtotal'] = 1 ;
					}

				}
				
			}
            $this->settings['subtotal'] = intval( $this->settings['subtotal'] / 100 ) ;
			if ( $this->settings['subtotal'] > 1000 ) {
                $this->settings['subtotal'] = $this->settings['subtotal'] - 1000 ;
                $this->settings['total'] = $this->settings['total'] + 1 ;
            }
            $this->settings['subtotal'] = "," . trim( substr( "000" . $this->settings['subtotal']  , -3 , 3 )) ;
			$this->settings['nowMinus24h'] = mktime( (date("h") -24) , date("i") , 0 , date("m"), date("d") , date("Y")) ;

			$this->settings['count'] = count($this->answers) ;
			$this->view->assign('settings', $this->settings);
			$this->view->assign('answerlist', $answerlist );
		}
        return $this->htmlResponse();
	}

}
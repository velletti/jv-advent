<?php
namespace Jvelletti\JvAdvent\Controller ;

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
class AdventController extends BaseController {


	/**
	 * Initializes the current action
	 *
	 * @return void
	 */
	public function initializeAction(): void {

		parent::initializeAction();

	}

	/**
	 * lists advents by category
	 *
	 * @return string The rendered view
	 */
	public function listAction( ): \Psr\Http\Message\ResponseInterface {
		//default values
		$doit = $this->settingsHelper( ) ;
		$this->view->assign('settings', $this->settings);
        return $this->htmlResponse();
	}

	/**
	 * single action for this controller.
	 *
	 * @return string The rendered view
	 */
	public function singleAction(): \Psr\Http\Message\ResponseInterface
    {
		
		$doit = $this->settingsHelper( ) ;
		$adddate = 0 ;
        if ( $this->request->hasArgument('addDate') ) {
            $adddate = intval( $this->request->getArgument('addDate') ) ;
            // Neu : nur noch positive werte und adddate 3 liefert den 3.12. statt wie früher 4.12
            $adddate = min( max(0 ,  $adddate -1 ) , 24 );
        } else {

            if ( $this->request->hasArgument('single') ) {
                $adddate_arr = $this->request->getArgument('single') ;
                if (is_array($adddate_arr)) {
                    $adddate = intval($adddate_arr['addDate'] ??  $adddate_arr['adddate'] );
                }
                // Neu : nur noch positive werte und adddate 3 liefert den 3.12. statt wie früher 4.12
                $adddate = min( max(0 ,  $adddate -1 ) , 24 );

            } else {
                $adddate = intval( date("d" )) -1  ;
            }
        }

		// Was ist die maximale Anzahl an tagen ? normal 24. Also ab dem 25.
		if ( $adddate >  (  $this->settings['maxDays'] ?? 24 )  -1 ) {
			$adddate = (  $this->settings['maxDays'] ?? 24 )  -1   ;
		}

		// 7.10.2014 j.v. : rückwirkendes / Beantworten auch für Nicht Nemetschek MA
		$month = date("m" ,  $this->settings['startDateTimeStamp'] ?? 12  ) ;


		$this->settings['showtip']   =  FALSE ;
		if ( $this->isTester || $this->isOrganisator ) {
            $day = $adddate + date("d" ,$this->settings['startDateTimeStamp'] ) ;
            $year = date("Y" ,$this->settings['startDateTimeStamp']);
            $this->settings['debug'] = "Tester/Organisator Mode: Setting today to $day.$month.$year" ;
			$this->settings['today']   = mktime( 0,0,0, $month , $day , $year  ) ;
			$this->settings['showtip']   =  TRUE  ;
		} else {
			$this->settings['today']   =  mktime( 0,0,0, $month , date("d" ) ,date("Y" )  ) ;
			if ($month == date("m" ) ) {
				$this->settings['today']   = mktime( 0,0,0, $month ,$adddate + date("d" ,$this->settings['startDateTimeStamp'] ) ,date("Y" ,$this->settings['startDateTimeStamp'])  ) ;
				// is today Bigger than allowed days in Front? then reset to Today !
				if ( intval( date("d" , $this->settings['today'] ) ) >=  intval( date("d")) + ( $this->settings['maxDaysInFuture'] ) ) {
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
        $question =  $this->adventRepository->findOneByFilter( $this->settings['today'] );
        $answers =  $this->userRepository->findMyanswers( $this->settings['year'] , $this->settings['feUserUid'] );
        $this->view->assign('answers', $answers);
        $this->settings['hideAgb'] = " " ;
        $this->settings['hideQuestion'] = " hide" ;
        if ( is_array( $answers ) && count($answers) > 0 ) {
            $this->settings['hideQuestion'] = " " ;
            $this->settings['hideAgb'] = " hide" ;
        }

        $this->view->assign('question', $question);


		$this->view->assign('settings', $this->settings);
		$this->view->assign('adddate', $adddate);
		$this->view->assign('mypid', $this->settings['list']['pid']['myanswersView']) ;
        $this->view->assign('isTester', $this->isTester);
		$this->view->assign('isOrganisator', $this->isOrganisator);
        return $this->htmlResponse();

	}

	/**
	 * single action for this controller.
	 *
	 * @return string The rendered view
	 */
	public function listAnswersAction(): \Psr\Http\Message\ResponseInterface {

		$doit = $this->settingsHelper( ) ;
		$this->settings['today']   = mktime( 0,0,0, date("m" ) ,(date("d" ) ) ,date("Y" )  ) ;

		// 11.10.2011 :
		//  $this->settings['today']   =  1318284000 ;
		$this->settings['todayformated']   =  date( "d.m.Y" , $this->settings['today'] ) ;
        $questions =  $this->adventRepository->findAll() ;
        if ( $this->settings['feUserUid'] > 0) {

            if ( is_array($questions) && count($questions) > 0 ) {

                for( $i=0;$i<count($questions);$i++) {
                    $answer =  $this->userRepository->findAnswer(  $this->settings['feUserUid'], $questions[$i]->getDate())->toArray();
                    $answersAll =  $this->userRepository->findAnswer(  0 , $questions[$i]->getDate())->toArray();
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

		$this->view->assign('settings', $this->settings);

		$this->view->assign('isOrganisator', $this->isOrganisator);
        return $this->htmlResponse();

	}

	/**
	 * Shows A calendar with doors. Actual Day gets special Class. Opened Doors of recent days are made with ajax ...
	 *
	 * @return string The rendered view
	 */
	public function showCalendarAction(): \Psr\Http\Message\ResponseInterface {

		$doit = $this->settingsHelper( ) ;
		$adddate = 0 ;
        $debug[] = "settings today:" . $this->settings['today'] . " (" . date("d.M.Y" , $this->settings['today'] ) . ")";

		// just for testing if Opened Door / Today Door works
		if ( $this->request->hasArgument('single') ) {
			$adddate_arr = $this->request->getArgument('single') ;
            $debug[] = "Add date Array = " . var_export($adddate_arr, true) ;
			if (is_array($adddate_arr)) {
				$adddate = intval($adddate_arr['addDate'] ?? $adddate_arr['adddate'] ) ;
                $debug[] = "Add date = " . $adddate ;
			}
			if ( $adddate >  ( $this->adventCat->getDays() -1 )) {
				$adddate = $this->adventCat->getDays() - 1 ;
                $debug[] = "Ad ddate was > Max =  Now:" . $adddate ;
			}

			if ( $adddate < 0 ) {
				$this->settings['today']   =  mktime( 0,0,0, date("m" ) ,(date("d" ) + $adddate  ) ,date("Y" )  ) ;
			} else {
				$this->settings['today']   = mktime( 0,0,0, date("m" , $this->settings['startDateTimeStamp']) ,$adddate + date("d" ,$this->settings['startDateTimeStamp'] ) ,date("Y" ,$this->settings['startDateTimeStamp'])  ) ;
			}
            $debug[] = "settings today after Add Date:" . $this->settings['today'] . " (" . date("d.M.Y" , $this->settings['today'] ) . ")";
        }

		$questions = array() ;

        $questionsFound = 0 ;
        $questionsNotFound = 0 ;
		for($i=0;$i<24;$i++) {
			$questions[] = array( "day" => $i , "date" => mktime( 0,0,0,  date("m" , $this->settings['startDateTimeStamp']) , $i+1 ,date("Y" )  ) , 'today' => FALSE , 'daybefore' => FALSE) ;
			$question =  $this->adventRepository->findOneByFilter( $questions[$i]['date'] )  ;
            if(is_array($question)) {
                $questions[$i]['title'] = $question["title"] ;
                $questions[$i]['dateF'] = date("d.m.Y" , $questions[$i]['date']) ;
                $questionsFound ++;
                $questions[$i]['today'] = TRUE ;
            } else {
                if( $questionsNotFound == 0) {
                    $debug[] = "No Question found for date: " . date("d.m.Y" , $questions[$i]['date']) ;
                    $debug[] = "condtions : > " .  ( $questions[$i]['date'] - (60 *60 * 4) ) . "  and < " . ( $questions[$i]['date'] + (60 * 60 * 4 )) ;
                    $debug[] = "condtions : > " .  date( "d.m. H:i" , $questions[$i]['date'] - (60 *60 * 4) ) . "  and < " . date( "d.m. H:i" , $questions[$i]['date'] + (60 * 60 * 4 )) ;
                }
                $questionsNotFound ++;
            }
			if ( $this->settings['today'] == $questions[$i]['date'] ) {
				$questions[$i]['today'] = TRUE ;
				$questions[$i]['title'] = '' ;
			}
			// allow to answer also days in Front
            if ( intval( date("d" , $this->settings['today'] ) ) >=  ( intval( date("d" , $questions[$i]['date'])  ) - $this->settings['maxDaysInFuture'] )) {
                $questions[$i]['daybefore'] = TRUE ;
			} else {
				$questions[$i]['dateF'] = '' ;
				$questions[$i]['title'] = '' ;
			}
        }
        $debug[] = "Final settings today:" . $this->settings['today'] . " (" . date("d.M.Y" , $this->settings['today'] ) . ")";

		$this->settings['todayformated']   =  date( "d.m.Y" , $this->settings['today'] ) ;
		$this->settings['today']   =  intval( date( "d" , $this->settings['today'] )) ;
        $this->view->assign('settings', $this->settings);
        $this->view->assign('adddate', $adddate);

        $debug[] = "isTester:" .  $this->isTester ? "JA" : "NEIN" ;
        $debug[] = "isOrganisator:" .  $this->isOrganisator ? "JA" : "NEIN" ;
        $debug[] = "StartDate" .  $this->settings['startDate'];
        $debug[] = "StartDateTstamp" .  date( "d.m.Y H:i" , $this->settings['startDateTimeStamp'] );

        $debug[] = "Number of Questions found: " . (string)($questionsFound) ;

        $this->view->assign('questions', $questions);

        $this->view->assign('isTester', $this->isTester);
        $this->view->assign('isOrganisator', $this->isOrganisator);

        $this->view->assign('debug', $debug );

        return $this->htmlResponse();

	}
}
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
		if ( $this->settings['afterenddate'] ) {
			$this->settings['showtotal'] = 1 ;
		}
		$this->view->assign('settings', $this->settings);
	}


	/**
	 * listall action for this controller.
	 * @param integer $offset 
	 */
	public function listallAction($offset=0) {

		// https://connect.allplan.com/de/home/advent-2013/rangliste.html?tx_nemadvent_pi1[offset]=0&tx_nemadvent_pi1[userGroup]=7
		$doit = $this->settingsHelper() ;
		if ( $this->request->hasArgument('offset')) {
			$offset = intval($this->request->getArgument('offset')) ;
		}
		$userGroup = "-7" ;
		$onlyUserGroup = '' ;
		$notUserGroup = 'AND a.usergroup <> 7 ' ;

		if ( $this->request->hasArgument('userGroup')) {
			$userGroup = intval($this->request->getArgument('userGroup')) ;
			if ( $userGroup <> "" ) {
				$onlyUserGroup = " AND FIND_IN_SET('" . $userGroup . "', a.usergroup) "  ;
				$notUserGroup = '' ;

			}
		}

		$offset = intval( $offset) ;

		$identifier  =  'listallWinner-offset-' . $offset . "-UG-" . $userGroup . "-L-" . $GLOBALS['TSFE']->sys_language_uid  . "-". $this->adventCat->getUid() . ""  ;

		$tempcontent = $this->get_content_from_Cache( $identifier ) ;
		$winnerdata = unserialize($tempcontent);
		$mindate= mktime( 23 , 59 , 59 , date("m") , date("d")-4 , date("Y"))  ;
        if ( $this->isnemintern ) {
            if ( $this->request->hasArgument('export')) {
                unset($winnerdata) ;
            }
        }

		if ( ! is_array( $winnerdata ) ) {
			
			
			$what = "a.feuser_uid,u.usergroup, "
			 . "u.username, u.email, u.tx_mmforum_avatar, u.tx_barafereguser_nem_gender, u.image, u.tx_barafereguser_nem_navision_contactid,  "
			. "count( a.points ) AS countttotal, sum( a.points ) AS pointtotal";
			
			$table = '(tx_nemadvent_domain_model_user a LEFT JOIN fe_users u ON a.feuser_uid = u.uid )' ;
//			$table = 'tx_nemadvent_domain_model_user a' ;
			
			$where = "a.advent_uid = " . $this->adventCat->getUid() 
			. "  AND a.deleted = 0 " . $notUserGroup . " AND a.sys_language_uid = " . $GLOBALS['TSFE']->sys_language_uid
		    . " AND a.question_date <" . $mindate
			. $onlyUserGroup
			 ;


			$groupBy = 'a.feuser_uid';
			$orderBy = 'pointtotal DESC, countttotal ASC';
	
			 $limit = $offset . ',60' ;

			// echo " SELECT $what FROM $table WHERE $where GROUP BY $groupBy ORDER BY $orderBy LIMIT $limit " ;

			$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($what,$table,$where,$groupBy,$orderBy,$limit);	
		
			$winnerdata = array() ;
            $export = "'username','email','points','answers','usergroup'\n" ;
			for ( $i=0;$i<60;$i++) {
				$winnerdata_res = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res) ;
				if ( $winnerdata_res ) {
					$winnerdata[$i] = $winnerdata_res ;
					$winnerdata[$i]['isPowerUser'] = FALSE ;

						// is in Group 5 Poweruser ??
						if ( in_array( "5" , explode( "," , $winnerdata[$i]['usergroup']))) {
							$winnerdata[$i]['isPowerUser'] = TRUE ;
						}



				
					if ( $winnerdata[$i]['image'] == "") {
						if( $winnerdata[$i]['tx_barafereguser_nem_gender'] == "0" ) {
							$winnerdata[$i]['tx_mmforum_avatar'] = "fileadmin/templates_connect/img/Avatar_Man.png" ;
						} else {
							$winnerdata[$i]['tx_mmforum_avatar'] = "fileadmin/templates_connect/img/Avatar_Woman.png" ;
						}
					} else {
						if ( preg_match("/tx_barafeprofileuser/", $winnerdata[$i]['image'] )) {
							$winnerdata[$i]['tx_mmforum_avatar'] = $winnerdata[$i]['image'] ;
						} else {
							$winnerdata[$i]['tx_mmforum_avatar'] = 'uploads/tx_barafeprofileuser/' . $winnerdata[$i]['image'] ;
						}
					}
                    if( $winnerdata[$i]['tx_barafereguser_nem_gender'] == "0" ) {
                        $winnerdata[$i]['avatar'] = "fileadmin/templates_connect/img/Avatar_Man.png" ;
                    } else {
                        $winnerdata[$i]['avatar'] = "fileadmin/templates_connect/img/Avatar_Woman.png" ;
                    }
					if ( !file_exists($winnerdata[$i]['tx_mmforum_avatar']) ) {
						$winnerdata[$i]['tx_mmforum_avatar'] = $winnerdata[$i]['avatar'] ;
					}
                    //$export = "'username','email','points','answers','usergroup'\n" ;
                    $export .= "'" . $winnerdata[$i]['username'] . "','" . $winnerdata[$i]['email'] . "',"
                                   . $winnerdata[$i]['pointtotal']."," . $winnerdata[$i]['countttotal'] . ",'"
                                   . $winnerdata[$i]['usergroup'] . "' \n"  ;

				}

			}

			$toBeSaved = serialize($winnerdata);
			$tempcontent = $this->put_content_to_Cache($identifier , $toBeSaved ) ;
		}		
		if ( $this->isnem ) {
	//		$this->view->assign('debug', "select  " . $what . " FROM " . $table .  " WHERE " . $where . " GROUP BY " . $groupBy . " ORDER BY " . $orderBy . " - "  . mysql_error() );
			
		}
        if ( $this->isnemintern ) {
            if ( $this->request->hasArgument('export')) {


                header("Content-Length: ".strlen($export) );
                header("Content-Disposition: attachment; filename=\"DL_AKR_Rangliste_"  . date("d.m.Y") . ".csv\"");
                header("Content-Transfer-Encoding: binary");

                header("Content-Type: application/force-download");
                header('Pragma: private');
                header('Expires: 0'); // set expiration time
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

                echo $export ;
                die() ;

            }
        }
		if ( $this->settings['afterenddate'] ) {
			$this->settings['showtotal'] = 1 ;
		}
		$this->view->assign('settings', $this->settings);
		$this->view->assign('winnerdata', $winnerdata);
        $this->view->assign('isnemintern',$this->isnemintern ) ;

		$this->view->assign('mindate', date("d.M H:i:s" , $mindate));

		$this->view->assign('offset', $offset );


		//	var_dump($winnerdata) ;
	//	die;
	}	

		


}

?>
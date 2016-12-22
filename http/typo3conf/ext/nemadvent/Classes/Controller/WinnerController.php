<?php
namespace Allplan\Nemadvent\Controller ;
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
class WinnerController extends BaseController {

	/**
	 * @var \Allplan\Nemadvent\Domain\Model\AdventCat
	 * @inject
	 */
	protected $adventCat;

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

		//overwrite setting Configuration

	}

	/**
	 * lists advents by category   ... 2014 actually UNNEEDED (only if winners made manually in backend ! )
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
					// j.v. 2015 Todo anpassen AN MMfORUM 2.0
					$resPosts = $GLOBALS['TYPO3_DB']->exec_SELECTquery('count(uid) as count',
						'tx_mmforum_posts',
						'poster_id = "' . intval($winners[$i]->getFeuserUid()). '"'
					     . " AND crdate > " . ( time() - (60*60*24*365) )  );

					if ($GLOBALS['TYPO3_DB']->sql_num_rows($resPosts) > 0) {
						$count = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
						$winnerdata[$i]['user']['forumcount'] = $count['count'];
					}
				} 

				if( $winnerdata[$i]['user']['tx_barafereguser_nem_gender'] == "0" ) {
					$winnerdata[$i]['user']['tx_mmforum_avatar'] = "fileadmin/templates_connect/img/Avatar_Man.png" ;
				} else {
					$winnerdata[$i]['user']['tx_mmforum_avatar'] = "fileadmin/templates_connect/img/Avatar_Woman.png" ;

				}
				if ( $this->settings['afterenddate'] ||  $this->isnemintern ) {
					if ( $winnerdata[$i]['user']['image'] <> "") {
						if ( preg_match("/tx_barafeprofileuser/", $winnerdata[$i]['user']['image'] )) {
							$winnerdata[$i]['user']['tx_mmforum_avatar'] = $winnerdata[$i]['user']['image'] ;
						} else {
							$winnerdata[$i]['user']['tx_mmforum_avatar'] = 'uploads/tx_barafeprofileuser/' . $winnerdata[$i]['user']['image'] ;
						}
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
		$count = 96 ;

		$userGroup = "-7" ;
		$onlyUserGroup = '' ;
		$notUserGroup = 'AND a.usergroup <> 7 ' ;

		$isNem = '' ;
		if ( $this->isnem ) {
			$isNem = "-nem-" ;
	    	if ( $this->request->hasArgument('offset')) {
	    		$offset = intval($this->request->getArgument('offset')) ;
	    	}
			if ( $this->request->hasArgument('export')) {
				$count = 1000 ;
				if ( $this->request->hasArgument('count')) {
					$count = $this->request->getArgument('count') ;
				}

			}
			if ( $this->request->hasArgument('count')) {
				$count = $this->request->getArgument('count') ;
			}
			$notUserGroup = '' ;
		}


		if ( $this->request->hasArgument('userGroup')) {
			$userGroup = intval($this->request->getArgument('userGroup')) ;
			if ( $userGroup <> "" ) {
				$onlyUserGroup = " AND FIND_IN_SET('" . $userGroup . "', a.usergroup) "  ;
				$notUserGroup = '' ;

			}
		}

		$offset = intval( $offset) ;
		$identifier  =  'listallWinner-offset-' . $offset . "-UG-" . $userGroup  . $isNem . "-L-" . $GLOBALS['TSFE']->sys_language_uid  . "-". $this->adventCat->getUid() . "-c" . $count ;

		$tempcontent = $this->get_content_from_Cache( $identifier ) ;
		$winnerdata = unserialize($tempcontent);
        if (  $this->settings['afterenddate']  ) {
            $mindate= mktime( 23 , 59 , 59 , date("m") , date("d")  , date("Y"))  ;
        } else {
            $mindate= mktime( 4 , 59 , 59 , date("m") , date("d")-1 , date("Y"))  ;
        }
// during deployment ...
		// unset($winnerdata);

		// load Typoscript from other extension
		$nemSettings= \Allplan\AllplanTools\Utility\TyposcriptUtility::loadTypoScriptFromScratch(12 , "tx_nemconnections") ;

		$this->settings['privateicons'] = $nemSettings["settings"]["setup"]['privateicons'] ;

		$this->settings['Year'] = date( "Y" , $this->adventCat->getStartdate() )  ;
		$this->settings['NewsletterDate'] = $this->adventCat->getStartdate() - ( 60 * 60 * 24 * 3 )  ;


		if ( $this->isnemintern ) {
            if ( $this->request->hasArgument('export')) {
                unset($winnerdata) ;
            }
        }

		$what = "a.feuser_uid ";
		$table = 'tx_nemadvent_domain_model_user a ' ;
		$where = "a.advent_uid = " . $this->adventCat->getUid() . "  AND a.deleted = 0 ";
		$groupBy = 'a.feuser_uid';
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($what,$table,$where,$groupBy);
		$this->settings['totalUser'] = $GLOBALS['TYPO3_DB']->sql_num_rows($res ) ;


		if ( ! is_array( $winnerdata ) ) {
			
			
			$what = "a.feuser_uid,u.usergroup as usergroup, "
			 . "u.username, u.email, u.crdate as crdate, u.tx_barafereguser_nem_gender, u.image, u.tx_mmforum_helpful_count  , u.tx_barafereguser_nem_navision_contactid, u.country as country, u.tx_barafereguser_nem_country , "
			. "count( a.points ) AS countttotal, sum( a.points ) AS pointtotal, sum( a.subpoints ) AS subpointtotal";
			
			$table = '(tx_nemadvent_domain_model_user a LEFT JOIN fe_users u ON a.feuser_uid = u.uid )' ;
//			$table = 'tx_nemadvent_domain_model_user a' ;
			
			$where = "a.advent_uid = " . $this->adventCat->getUid() 
			. "  AND a.deleted = 0 " . $notUserGroup . " AND a.sys_language_uid = " . $GLOBALS['TSFE']->sys_language_uid
		    . " AND a.tstamp < " . $mindate . " AND a.question_date < " . $mindate
			. $onlyUserGroup
			 ;


			$groupBy = 'a.feuser_uid';
			$orderBy = 'pointtotal DESC, subpointtotal DESC, countttotal ASC';

			 $limit = $offset . ',' . $count ;

			// echo " SELECT $what FROM $table WHERE $where GROUP BY $groupBy ORDER BY $orderBy LIMIT $limit " ;

			$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($what,$table,$where,$groupBy,$orderBy,$limit);	
		
			$winnerdata = array() ;
			$ForumCount = 0 ;
			$helpfullCount = 0 ;
			$akrCount = array() ;
			$newUser = 0 ;
			$newUserDez = 0 ;
            $export = "'username','email','points','subpoints','answers','usergroup','country','nemCountry,regDate,forumCount'\n" ;

			for ( $i=0;$i< $count ;$i++) {
				$winnerdata_res = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res) ;
				if ( $winnerdata_res ) {
					$winnerdata[$i] = $winnerdata_res ;
					$winnerdata[$i]['subpointtotal'] = substr( "0000" . round( $winnerdata[$i]['subpointtotal'] / 1000, 0 ) , -4 , 4 )  ;
					$winnerdata[$i]['isPowerUser'] = FALSE ;
					$winnerdata[$i]['btnClass'] = "" ;

					// is in Group 5 Poweruser ??
					if ( in_array( "5" , explode( "," , $winnerdata[$i]['usergroup']))) {
						$winnerdata[$i]['isPowerUser'] = TRUE ;
						$winnerdata[$i]['btnClass'] = "alert-success" ;
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

					$winnerdata[$i]['forumcount'] = 0 ;

					if ( date("Y" , $winnerdata[$i]['crdate']) ==  $this->settings['Year']   ) {
						$newUser++ ;
						$winnerdata[$i]['btnClass'] = "alert-warning" ;
					}
					if (  $winnerdata[$i]['crdate'] > $this->settings['NewsletterDate'] ) {
						$newUserDez++ ;
						$winnerdata[$i]['btnClass'] = "alert-error" ;
					}

					$winnerdata[$i]['cryear'] = date("Y" , $winnerdata[$i]['crdate']) ;
					$winnerdata[$i]['crdate'] = date("m.d.Y" , $winnerdata[$i]['crdate']) ;

					if( $winnerdata[$i]['country'] == "NULL" ) {
						$winnerdata[$i]['country'] = FALSE ;
						$winnerdata[$i]['flag'] = FALSE ;
					}  else {
						switch ($winnerdata[$i]['country']) {
							case 'DE':
								$winnerdata[$i]['flag'] = "<span class=\"icon-country icon-country-1\"></span>" ;
								// j.v.:
								break;
							case 'AT':
								$winnerdata[$i]['flag'] = "<span class=\"icon-country icon-country-7\"></span>" ;
								// j.v.:
								break;
							case 'CH':
								$winnerdata[$i]['flag'] = "<span class=\"icon-country icon-country-6\"></span>" ;
								// j.v.:
								break;
							case 'CZ':
								$winnerdata[$i]['flag'] = "<span class=\"icon-country icon-country-3\"></span>" ;
								// j.v.:
								break;
							case 'IT':
								$winnerdata[$i]['flag'] = "<span class=\"icon-country icon-country-2\"></span>" ;
								// j.v.:
								break;
							case 'FR':
								$winnerdata[$i]['flag'] = "<span class=\"icon-country icon-country-4\"></span>" ;
								// j.v.:
								break;

						}
					}

					// Addtional Data for Export and New Ranking
					// if( $this->request->hasArgument('export') ) {
						$where = 'author = "' . intval($winnerdata[$i]['feuser_uid']). '"'
							. " AND crdate > " . ( time() - (60*60*24*365) ) . " AND crdate < " . mktime( 0,0,0, date("m"),date("d")-1,date("Y"));

						$resPosts = $GLOBALS['TYPO3_DB']->exec_SELECTquery('count(uid) as count',
							'tx_mmforum_domain_model_forum_post',
							$where  );

						if ($GLOBALS['TYPO3_DB']->sql_num_rows($resPosts) > 0) {
							$ForumCountSingle = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($resPosts);

							$winnerdata[$i]['forumcount'] = $ForumCountSingle['count'];
							$ForumCount = $ForumCount + intval( $ForumCountSingle['count'] ) ;
						}
						$helpfullCount = $helpfullCount + intval( $winnerdata[$i]['tx_mmforum_helpful_count'] ) ;
					// }

					// wie Oft hat der user am AKR teilgenommen??
					// SELECT  count( `advent_uid` ) as Count,  `feuser_uid` FROM `connect`.`tx_nemadvent_domain_model_user`
					// where `feuser_uid` = 353
					// GROUP BY  `advent_uid`
					$select = "count( `advent_uid` ) as Count,  `feuser_uid` , advent_uid" ;
					$where = 'feuser_uid = "' . intval($winnerdata[$i]['feuser_uid']). '"' ;
					$resAKRs = $GLOBALS['TYPO3_DB']->exec_SELECTquery( $select ,
						'tx_nemadvent_domain_model_user',
						$where  , 'advent_uid' );


					$CountSingle = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($resAKRs);

					$winnerdata[$i]['AKRcount'] = $GLOBALS['TYPO3_DB']->sql_num_rows($resAKRs) - 1 ;
					if( $winnerdata[$i]['AKRcount'] > 4 ) {
						$winnerdata[$i]['AKRcount'] = "≥ 5" ;
					}
					if( $winnerdata[$i]['AKRcount'] == 0 && $winnerdata[$i]['btnClass'] == '' ) {
						// Neue AKR teilnehmer in Blau wenn nciht vorher anders gesetzt (neuregistriert, Poweruser )
						$winnerdata[$i]['btnClass'] = "alert-info";
					}
					$tempKey = $winnerdata[$i]['AKRcount'] ;
					$akrCount[ $tempKey] = $akrCount[ $tempKey] + 1 ;



					// wann hat der user an DIESEM AKR Zuerst / zuletzt teilgenommen??
					$select = "crdate , uid" ;
					$where = 'feuser_uid = "' . intval($winnerdata[$i]['feuser_uid']). '" AND advent_uid = ' . $this->adventCat->getUid()  ;
			//				$GLOBALS['TYPO3_DB']->debugOutput = 2;
			//				$GLOBALS['TYPO3_DB']->explainOutput = true;
			//				$GLOBALS['TYPO3_DB']->store_lastBuiltQuery = true;

					$resAKR = $GLOBALS['TYPO3_DB']->exec_SELECTquery( $select ,
						'tx_nemadvent_domain_model_user',
						$where  , "" , "crdate ASC" , "0,1" );
					// echo "<br>Select " . $select . " FROM tx_nemadvent_domain_model_user WHERE " . $where . " ORDER BY crdate ASC LIMIT 0,1  ; # Error " . $GLOBALS['TYPO3_DB']->sql_error() ;
					$getSingle = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($resAKR);
						$winnerdata[$i]['AKRfirst'] = date("d.m H:i" , $getSingle['crdate']) ; // . " - " . $getSingle['uid'];
						$winnerdata[$i]['AKRfirstUser'] = date("d." , $getSingle['crdate']) ;


					$resAKR = $GLOBALS['TYPO3_DB']->exec_SELECTquery( $select ,
						'tx_nemadvent_domain_model_user',
						$where  , "" , "crdate DESC" , "0,1");

					$getSingle = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($resAKR);
					$winnerdata[$i]['AKRlast'] = date("d.m H:i" , $getSingle['crdate']) ; // . " - " . $getSingle['uid'] ;
					$winnerdata[$i]['AKRlastUser'] = date("d." , $getSingle['crdate']) ;

						/*
						if ( !$this->isnem ) {
							if (  !$this->settings['afterenddate']  ) {
								$winnerdata[$i]['tx_mmforum_avatar'] = $winnerdata[$i]['avatar'] ;
							}
						}
						*/
                    //$export = "'username','email','points','answers','usergroup'\n" ;
                    $export .= "'"  . $winnerdata[$i]['username'] . "','" . $winnerdata[$i]['email'] . "',"
                                    . $winnerdata[$i]['pointtotal']."," . $winnerdata[$i]['subpointtotal']."," .$winnerdata[$i]['countttotal']
									. ",'" . $winnerdata[$i]['tx_barafereguser_nem_country']."','" . $winnerdata[$i]['country']."','"
                                    . $winnerdata[$i]['usergroup'] . "', "
                                    . " '" . date("d.M.Y" , $winnerdata[$i]['crdate'] ) . "', "
									. $winnerdata[$i]['forumcount']
						            .   ", " .  $winnerdata[$i]['tx_mmforum_helpful_count']
						            .   ", " .  $winnerdata[$i]['AKRcount']
						            .   ", '" .  $winnerdata[$i]['AKRfirst'] . "'"
						            .   ", '" .  $winnerdata[$i]['AKRlast'] . "'"

									. "\n"  ;
				}

			}
			$winnerdata[1]['settings']['ForumCount'] = $ForumCount ;
			$winnerdata[1]['settings']['helpfullCount'] = $helpfullCount ;
			$winnerdata[1]['settings']['newUser'] = $newUser ;
			$winnerdata[1]['settings']['newUserDez'] = $newUserDez ;
			$winnerdata[1]['settings']['akrCount'] = $akrCount ;

			$toBeSaved = serialize($winnerdata);
			$tempcontent = $this->put_content_to_Cache($identifier , $toBeSaved ) ;
		}		
		if ( $this->isnem ) {
	//		$this->view->assign('debug', "select  " . $what . " FROM " . $table .  " WHERE " . $where . " GROUP BY " . $groupBy . " ORDER BY " . $orderBy . " - "  . $GLOBALS['TYPO3_DB']->sql_error() );
			
		}
        if ( $this->isnemintern ) {
            if ( $this->request->hasArgument('export')) {

				$export = $export  . "\n\nForumposts Total Count: " . $ForumCount ;
				$export = $export  . "\n\nHelpfull Forumposts Total Count: " . $helpfullCount ;
				$export = $export  . "\n\nNew usersCount: " . $newUser ;
				$export = $export  . "\n\nNew usersCount Dez: " . $newUserDez ;
				$export = $export  . "\n\nAKR Teilnahmen: " . var_export( $akrCount , true ) ;

				$export = pack("CCC", 0xef, 0xbb, 0xbf) .  $export   ;


                header("Content-Length: ".strlen($export) );
                header("Content-Disposition: attachment; filename=\"DL_AKR_Rangliste_"  . date("d.m.Y") . ".csv\"");
                header("Content-Transfer-Encoding: binary");

				header("content-type: application/csv-comma-delimited-table; Charset=utf-8");

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
		$this->settings['day'] = min( date( "d") , 24 ) ;
		if ( $this->isnemintern ) {
			$this->settings['day'] = 24 ;
		}
		// $this->settings['day'] = 21 ;
		if( is_array( $winnerdata[1]['settings'] )) {
			$this->settings['helpfullCount'] 	= $winnerdata[1]['settings']['helpfullCount'] ;
			$this->settings['forumCount'] 		= $winnerdata[1]['settings']['forumCount'] ;
			$this->settings['akrCount'] 		= $winnerdata[1]['settings']['akrCount'] ;
			$this->settings['newUser'] 			= $winnerdata[1]['settings']['newUser'] ;
			$this->settings['newUserDez'] 		= $winnerdata[1]['settings']['newUserDez'];
		} else {
			$this->settings['helpfullCount'] = $helpfullCount ;
			$this->settings['forumCount'] 	= $ForumCount ;
			$this->settings['akrCount'] 	= $akrCount ;
			$this->settings['newUser'] 		= $newUser ;
			$this->settings['newUserDez'] 	= $newUserDez ;
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
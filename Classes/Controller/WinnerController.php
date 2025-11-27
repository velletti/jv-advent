<?php
namespace Jvelletti\JvAdvent\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Context\Context;
use Allplan\AllplanTools\Utility\TyposcriptUtility;
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
 public function __construct(private \TYPO3\CMS\Core\Context\Context $context)
 {
 }

	/**
	 * Initializes the current action
	 *
	 * @return void
	 */
	public function initializeAction(): void {
		parent::initializeAction();
	}

	/**
	 * lists advents by category   ... 2014 actually UNNEEDED (only if winners made manually in backend ! )
	 *
	 * @return string The rendered view
	 */
	public function listAction( ): \Psr\Http\Message\ResponseInterface {
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

				if( $winnerdata[$i]['user']['tx_nem_gender'] == "0" ) {
					$winnerdata[$i]['user']['tx_mmforum_avatar'] = "typo3conf/ext/connect_template/Resources/Public/Images/avatars/avatar-man.png" ;
				} else {
					$winnerdata[$i]['user']['tx_mmforum_avatar'] = "typo3conf/ext/connect_template/Resources/Public/Images/avatars/avatar-woman.png" ;

				}
				if ( $this->settings['afterenddate'] ||  $this->isOrganisator ) {

                    $imageDirectoryName = 'uploads/tx_feusers_img/'  ;
                    $subPath = substr( "0000" . intval( round(  $winnerdata[$i]['uid'] / 1000 , 0 )) , -4 , 4 )  ;
                    $imageFilename = rtrim($imageDirectoryName, '/') . '/' . $subPath . '/'. $winnerdata[$i]['tx_nem_image'] ;
                    if( file_exists($imageFilename) ) {
                        $winnerdata[$i]['user']['tx_mmforum_avatar'] = $imageFilename ;

                    } else {
                        $gender = 'neutral' ;
                        $winnerdata[$i]['user']['tx_mmforum_avatar'] = 'typo3conf/ext/connect_template/Resources/Public/Images/avatars/avatar-' . $gender . '.png' ;
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
  return $this->htmlResponse();
	}


	/**
	 * listall action for this controller.
	 * @param integer $offset 
	 */
	public function listallAction($offset=0): \Psr\Http\Message\ResponseInterface {

		// https://connect.allplan.com/de/home/advent-2013/rangliste.html?tx_jvadvent_pi1[offset]=0&tx_jvadvent_pi1[userGroup]=7
		$doit = $this->settingsHelper() ;
        $count = 72 ;
        if (  $this->settings['winnerPerPageCount']  ) {
            $count = intval( $this->settings['winnerPerPageCount'] ) ;

        } else {
            $this->settings['winnerPerPageCount'] = 72 ;
        }
        $this->settings['winnerPerPageCount1'] = $this->settings['winnerPerPageCount'] +1  ;
        $this->settings['winnerPerPageCount2'] = $this->settings['winnerPerPageCount'] * 2   ;

		$userGroup = "-7" ;
		$onlyUserGroup = '' ;
		$notUserGroup = 'AND a.usergroup <> 7 ' ;
        $offset = 0 ;
        if ( $this->request->hasArgument('offset')) {
            if(  intval($this->request->getArgument('offset'))  == 72 ||  intval($this->request->getArgument('offset'))  == 144  ) {
                $offset = intval($this->request->getArgument('offset'))  ;
            }
        }
		$isTester = '' ;
        $withWishes = true ;
		if ( $this->isTester ) {
			$isTester = "-nem-" ;
	    	if ( $this->request->hasArgument('offset')) {
	    		$offset = intval($this->request->getArgument('offset')) ;
	    	}

			if ( $this->request->hasArgument('export')) {
				$count = 1000 ;
				if ( $this->request->hasArgument('count')) {
					$count = $this->request->getArgument('count') ;
				}
                $withWishes = false  ;
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
        if (  $this->settings['afterenddate']  ) {
            $mindate= mktime( 23 , 59 , 59 , date("m") , date("d")  , date("Y"))  ;
        } else {
            $mindate= mktime( 12 , 0 , 0 , date("m") , date("d")-1 , date("Y"))  ;
        }
        $minCreated = time() - ( 60*60 * 24 ) ;

		$this->settings['Year'] = date( "Y" , $this->settings['startDateTimeStamp'] )  ;


		if ( $this->isOrganisator ) {
            if ( $this->request->hasArgument('export') || $this->request->hasArgument('count')) {
                unset($winnerdata) ;
            }
        }

		$what = "a.feuser_uid ";
		$table = 'tx_jvadvent_domain_model_user a ' ;
		$where = "a.advent_uid = " . $this->adventCat->getUid() . "  AND a.deleted = 0 ";
		$groupBy = 'a.feuser_uid';
		$this->settings['totalUser'] =0 ;


		if ( ! is_array( $winnerdata ) ) {


			$what = "a.feuser_uid,u.usergroup as usergroup, u.tx_nem_firstname as firstname, "
			 . "u.username, u.email, u.crdate as crdate, u.tx_nem_gender, u.tx_nem_image, u.tx_mmforum_helpful_count  , u.tx_nem_navision_contactid, u.country as country, u.tx_nem_country , "
			. "count( a.points ) AS counttotal, sum( a.points ) AS pointtotal, sum( a.subpoints ) AS subpointtotal , (sum( a.points )*100000 + sum( a.subpoints )) as pointsForOrder ";

			$table = '(tx_jvadvent_domain_model_user a LEFT JOIN fe_users u ON a.feuser_uid = u.uid )' ;
//			$table = 'tx_jvadvent_domain_model_user a' ;

			$where = "a.advent_uid = " . $this->adventCat->getUid() 
			. "  AND a.deleted = 0 " . $notUserGroup . " AND a.sys_language_uid = " . $this->context->getPropertyFromAspect('language', 'id')
		    . " AND a.crdate < " . $minCreated . " AND a.question_date < " . $mindate

			. $onlyUserGroup
			 ;


			$groupBy = 'a.feuser_uid';
			$orderBy = 'pointsForOrder DESC, counttotal ASC';

			 $limit = $offset . ',' . $count ;

			// echo " SELECT $what FROM $table WHERE $where GROUP BY $groupBy ORDER BY $orderBy LIMIT $limit " ;



			$winnerdata = array() ;
			$ForumCount = 0 ;
			$userWith24Answers = 0 ;
			$helpfullCount = 0 ;
			$akrCount = array() ;
			$newUser = 0 ;
			$newUserDez = 0 ;
            $export = "'username','firstname','email','points','subpoints','answers','country','nemCountry','usergroup','regDate','forumCount','helpful','AKR Count','first Answer', 'last Answer'\n" ;
            $this->settings['wishlist'] = 0 ;

			for ( $i=0;$i< $count ;$i++) {
				$winnerdata_res = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res) ;
				// var_dump( $winnerdata_res) ;
				// die;
				if ( $winnerdata_res ) {
					$winnerdata[$i] = $winnerdata_res ;
					if(  $winnerdata[$i]['subpointtotal']  > 99999 ) {
                        $winnerdata[$i]['subpointtotal'] = $winnerdata[$i]['subpointtotal']  - 99999 ;
                        $winnerdata[$i]['pointtotal'] = $winnerdata[$i]['pointtotal'] + 1 ;
                        $winnerdata[$i]['subpointtotal'] = substr( "000" . round( $winnerdata[$i]['subpointtotal'] / 100, 0 ) , -3 , 3 )  ;
                    } else {
                        $winnerdata[$i]['subpointtotal'] = substr( "000" . round( $winnerdata[$i]['subpointtotal'] / 100, 0 ) , -3 , 3 )  ;
                    }


					if( $winnerdata[$i]['counttotal'] == 24 ) {
                        $userWith24Answers++ ;
                    }

					$winnerdata[$i]['isPowerUser'] = FALSE ;
					$winnerdata[$i]['btnClass'] = "" ;

					// is in Group 5 Poweruser ??
					if ( in_array( "5" , explode( "," , $winnerdata[$i]['usergroup']))) {
						$winnerdata[$i]['isPowerUser'] = TRUE ;
						$winnerdata[$i]['btnClass'] = "alert-success" ;
					}

					if ( $winnerdata[$i]['tx_nem_image'] == "") {
						if( $winnerdata[$i]['tx_nem_gender'] == "0" ) {
							$winnerdata[$i]['tx_mmforum_avatar'] = "typo3conf/ext/connect_template/Resources/Public/Images/avatars/avatar-man.png" ;
						} else {
							$winnerdata[$i]['tx_mmforum_avatar'] = "typo3conf/ext/connect_template/Resources/Public/Images/avatars/avatar-woman.png" ;
						}
					} else {

                        $imageDirectoryName = 'uploads/tx_feusers_img/'  ;
                        $subPath = substr( "0000" . intval( round(  $winnerdata[$i]['feuser_uid'] / 1000 , 0 )) , -4 , 4 )  ;
                        $imageFilename = rtrim($imageDirectoryName, '/') . '/' . $subPath . '/'. $winnerdata[$i]['tx_nem_image'] ;
                        $winnerdata[$i]['tx_mmforum_avatar'] = $imageFilename ;

                    }
                    if( $winnerdata[$i]['tx_nem_gender'] == "0" ) {
                        $winnerdata[$i]['avatar'] = "typo3conf/ext/connect_template/Resources/Public/Images/avatars/avatar-man.png" ;
                    } else {
                        $winnerdata[$i]['avatar'] = "typo3conf/ext/connect_template/Resources/Public/Images/avatars/avatar-woman.png" ;
                    }
                    if ( !file_exists( $winnerdata[$i]['tx_mmforum_avatar']) ) {
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

                    $export .= "'"  . $winnerdata[$i]['username'] . "','" . $winnerdata[$i]['firstname'] . "','" . $winnerdata[$i]['email'] . "',"
                                    . $winnerdata[$i]['pointtotal']."," . $winnerdata[$i]['subpointtotal']."," .$winnerdata[$i]['counttotal']
									. ",'" . $winnerdata[$i]['tx_nem_country']."','" . $winnerdata[$i]['country']."','"
                                    . $winnerdata[$i]['usergroup'] . "', "
                                    . " '" . $winnerdata[$i]['crdate']  . "', "
									. "\n"  ;

                    // end of User
				}

			}
			$winnerdata[1]['settings']['userWith24Answers'] = $userWith24Answers ;
			$winnerdata[1]['settings']['helpfullCount'] = $helpfullCount ;
			$winnerdata[1]['settings']['count'] = $count ;
		}
        if ( $this->isOrganisator ) {
            if ( $this->request->hasArgument('export')) {

				$export = $export  . "\n\nUser with 24 Answers: " . $userWith24Answers ;
				$export = $export  . "\n\nNew usersCount: " . $newUser ;

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

		$this->settings['day'] = min( date( "d") , 24 ) ;

		if ( $this->settings['afterenddate'] ) {
			$this->settings['day'] =  24  ;
			$this->settings['showtotal'] = 1 ;
		}
		if ( $this->isOrganisator ) {
			$this->settings['day'] = 24 ;
		}

		$this->view->assign('settings', $this->settings);
		$this->view->assign('winnerdata', $winnerdata);
        $this->view->assign('isOrganisator',$this->isOrganisator ) ;

		$this->view->assign('mindate', date("d.M H:i:s" , $mindate));

		$this->view->assign('offset', $offset );
        return $this->htmlResponse();
	}
}
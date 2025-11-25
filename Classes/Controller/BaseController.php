<?php
namespace Jvelletti\JvAdvent\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Jvelletti\JvAdvent\Domain\Repository\WinnerRepository;
use Jvelletti\JvAdvent\Domain\Repository\AdventRepository;
use Jvelletti\JvAdvent\Domain\Repository\UserRepository;
use Jvelletti\JvAdvent\Domain\Model\User;
use TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository;
use TYPO3\CMS\Extbase\Domain\Repository\FrontendUserGroupRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
/***************************************************************
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
***************************************************************
 * Controller for varius objects
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class BaseController extends ActionController {

	/**
  * @var WinnerRepository
  */
 public WinnerRepository $winnerRepository;

	/**
     * @var AdventRepository
     */
    public AdventRepository $adventRepository;


	/**
	 * @var boolean $isnem
	 */
	public bool $isnem ;

	/**
	 * @var boolean $isnem
	 */
	public bool $isnemintern ;

	/**
  * @var UserRepository
  */
 public UserRepository $userRepository;

	/**
     * @var User
     */
    public User $user;

    public function __construct(private \TYPO3\CMS\Core\Context\Context $context)
    {
    }



	/**
	 * Initializes the current action
	 *
	 * @return void
	 */
	public function initializeAction(): void {
		/** @var AdventRepository $this ->adventRepository*/
  		$this->adventRepository	 	= GeneralUtility::makeInstance(AdventRepository::class) ;

		/** @var UserRepository $this ->userRepository*/
  		$this->userRepository	 	= GeneralUtility::makeInstance(UserRepository::class) ;

		/** @var WinnerRepository $this ->winnerRepository*/
  		$this->winnerRepository	 	= GeneralUtility::makeInstance(WinnerRepository::class) ;
	}


	public function settingsHelper( ) {
		$this->isnem = false;
		$this->isnemintern = false;

		$this->settings['feUserUid'] = 0;

		if (!empty($GLOBALS['TSFE']->fe_user->user['uid'])){
			$this->settings['feUserUid'] = $GLOBALS['TSFE']->fe_user->user['uid'];
			if( in_array( "7" , explode( "," , $GLOBALS['TSFE']->fe_user->user['usergroup'] .","))) {
				$this->isnem = true;	
			} 
			if( in_array( "16" , explode( "," , $GLOBALS['TSFE']->fe_user->user['usergroup'] .","))) {
				$this->isnemintern = true;	
			} 
		}

		$this->CacheTime = 60*60*4 ;
		$this->pid = intval( $GLOBALS['TSFE']->id ) ;

		$this->settings['now']   = date( "d.m.Y H:i" ,time() ) ;

		$this->settings['afterenddate'] = FALSE ;
		$this->settings['beforestartdate'] = FALSE ;
		$this->settings['today']   = mktime( 0,0,0, date("m" ) ,(date("d" ) ) ,date("Y" )  ) ;

		if ( is_object($this->adventCat)) {

			$this->settings['startdate'] = date( "d.m.Y 09:00" , $this->adventCat->getStartdate() ) ;
			$this->settings['enddate']   = date( "d.m.Y 23:59" ,$this->adventCat->getEnddate() ) ;

			if ( $this->adventCat->getEnddate()  < time() ) {
				$this->settings['afterenddate'] = TRUE ;
				$this->view->assign('mypid', $this->settings['list']['pid']['myanswersView']) ;
			} else {			
				if ( $this->adventCat->getStartdate()  < time() ) {
					if ( $this->adventCat->getStartdate()  < (time()	- (60*60*24))) {
						$this->view->assign('yesterdayspid', $this->settings['list']['pid']['singleView']) ;
					}
					if ( date("G") > date("G" , $this->adventCat->getStartdate()) ) {
						if ( $this->adventCat->getStartdate()  > (time()	- (60*60*24* $this->adventCat->getDays()))) {
							$this->view->assign('todayspid', $this->settings['list']['pid']['singleView']) ;
						}	
					}
					$this->view->assign('mypid', $this->settings['list']['pid']['myanswersView']) ; 
				} else {
					$this->settings['beforestartdate'] = TRUE ;
				}
			}	
		}
		if ( $this->isnemintern == true	) {
			$this->view->assign('mypid', $this->settings['list']['pid']['myanswersView']) ; 
		}
		$this->settings['sys_language_uid'] = $this->context->getPropertyFromAspect('language', 'id')  ; 

		 $count = date("d" , mktime( 0,0,0, date("m" , $this->adventCat->getStartdate() ) , date("d" )  ,date("Y" , $this->adventCat->getStartdate() )  ) ) ;
         $count = min ( $count , 24 ) ;
		 $this->view->assign('adventCounter', $count);

		return true;
	}		

	/*
	 * try to get a Content Peace from Cache by Identifier
	 *
	 * @param	string		$identifier 
	 * @return	string		output to website from Cache or empty
	 */
	function get_content_from_Cache($identifier) {

		if ( $this->CacheTime == 0 ) {
			return '' ;
		}
		// for development ... do not cache at all if activating the next line .. ... !
		// $this->delete_from_Cache($identifier ) ;
		$identifier =  $identifier . "-". $this->context->getPropertyFromAspect('language', 'id') ;
		$where = 'identifier = "' . $identifier . '" and lifetime > ' . time() . " AND pid = " . $GLOBALS['TSFE']->id;
 		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('content','tx_jvadvent_cache', $where, '' , '');
		$row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res) ;
		$this->CacheDebug .=  "<br>get: " . $where . (($row) ? ' -> found':' -> not cached') ;
		return $row['content'] ;
	}
	/*
	 * put a Content Peace to Cache by Identifier
	 *
	 * @param	string		$identifier 
	 * @param	string		$content
	 * @return	''
	 */	
	function put_content_to_Cache($identifier , $content ): void {
		$this->CacheDebug .=  '<br>put: -> ' . $identifier . " -> CacheTime" . $this->CacheTime ;	
		if ( $this->CacheTime > 0 ) {

			$this->delete_from_Cache($identifier ) ;
			$identifier =  $identifier . "-". $this->context->getPropertyFromAspect('language', 'id') ;
			$data = array ( 'pid' => $GLOBALS['TSFE']->id  ,
							'identifier' => $identifier ,
							'lifetime' => time() + $this->CacheTime ,
							'content' => $content ,
						);
			$res = $GLOBALS["TYPO3_DB"]->exec_INSERTquery("tx_jvadvent_cache", $data);	

			$this->CacheDebug .=  ' -> til: ' . ( time() + $this->CacheTime )  ;	
		}	
	}
	/*
	 * delete from Cache by Identifier
	 *
	 * @param	string		$identifier 
	 * @return	''
	 */	
	function delete_from_Cache($identifier ): void {
		$identifier =  $identifier . "-". $this->context->getPropertyFromAspect('language', 'id') ;
		$this->CacheDebug .=  '<br>delete: -> ' . $identifier . " -> CacheTime" . $this->CacheTime ;	
		$where = 'identifier LIKE "' . $identifier . '" AND pid = "' . $GLOBALS['TSFE']->id  . '"' ;
		$res = $GLOBALS["TYPO3_DB"]->exec_DELETEquery("tx_jvadvent_cache", $where );	

	}

	/*
	 * translate function
	 * @param string $label the locallang label to translate
	 * @return string the localized String 
	 * @author Martin Heigermoser <martin.heigermoser@typovision.de>
	 */
	public function translate($label , $arguments=NULL) {
		return LocalizationUtility::translate($label, 'JvAdvent' , $arguments );
	}

	public function showArrayAsJson($output): void {
		$jsonOutput = json_encode($output);
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Cache-Control: no-cache, must-revalidate');
		header('Pragma: no-cache');
		header('Content-Length: ' . strlen($jsonOutput));
		header('Content-Type: application/json; charset=utf-8');
		header('Content-Transfer-Encoding: 8bit');

		$callbackId = $this->request->getParsedBody()["callback"] ?? $this->request->getQueryParams()["callback"] ?? null;
		if ( $callbackId == '' ) {
			echo $jsonOutput;
		} else {
			echo $callbackId . "(" . $jsonOutput . ")";
		}

		die;
		exit();
	}

 public function injectWinnerRepository(WinnerRepository $winnerRepository): void
 {
     $this->winnerRepository = $winnerRepository;
 }

 public function injectAdventRepository(AdventRepository $adventRepository): void
 {
     $this->adventRepository = $adventRepository;
 }

 public function injectAdventCatRepository(AdventCatRepository $adventCatRepository): void
 {
     $this->adventCatRepository = $adventCatRepository;
 }

 public function injectAdventCat(AdventCat $adventCat): void
 {
     $this->adventCat = $adventCat;
 }

 public function injectUserRepository(UserRepository $userRepository): void
 {
     $this->userRepository = $userRepository;
 }

 public function injectUser(User $user): void
 {
     $this->user = $user;
 }

 public function injectFrontendUserRepository($frontendUserRepository): void
 {
     $this->frontendUserRepository = $frontendUserRepository;
 }

 public function injectFrontendUserGroupRepository($frontendUserGroupRepository): void
 {
     $this->frontendUserGroupRepository = $frontendUserGroupRepository;
 }
}
?>

<?php
namespace Jvelletti\JvAdvent\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Jvelletti\JvAdvent\Domain\Repository\WinnerRepository;
use Jvelletti\JvAdvent\Domain\Repository\AdventRepository;
use Jvelletti\JvAdvent\Domain\Repository\UserRepository;
use Jvelletti\JvAdvent\Domain\Model\User;
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
	 * @var boolean $isTester
	 */
	public bool $isTester ;

	/**
	 * @var boolean $isTester
	 */
	public bool $isOrganisator ;

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
		$this->isTester = false;
		$this->isOrganisator = false;

		$this->settings['feUserUid'] = 0;
		$this->settings['testerGroup']    = intval($this->settings['testerGroup'] ) ?? 7 ;
		$this->settings['organizerGroup'] = intval($this->settings['organizerGroup'] ) ?? 6 ;

		if (!empty($GLOBALS['TSFE']->fe_user->user['uid'])){
			$this->settings['feUserUid'] = $GLOBALS['TSFE']->fe_user->user['uid'];
			$groups = GeneralUtility::trimExplode(',', $GLOBALS['TSFE']->fe_user->user['usergroup'] , true);

			if( in_array( $this->settings['testerGroup']  , $groups )) {
				$this->isTester = true;	
			}
			if( in_array( $this->settings['organizerGroup']  , $groups )) {
				$this->isOrganisator = true;
			}
		}

		$this->pid = intval( $GLOBALS['TSFE']->id ) ;

		$this->settings['now']   = date( "d.m.Y H:i" ,time() ) ;

		$this->settings['afterenddate'] = FALSE ;
		$this->settings['beforestartdate'] = FALSE ;
		$this->settings['today']   = mktime( 0,0,0, date("m" ) ,(date("d" ) ) ,date("Y" )  ) ;

            $start = $this->settings['startDate'] ?? '2025-12-01 09:00:00' ;
            $startDate = new \DateTime($start) ;
            $end = $this->settings['endDate'] ?? '2025-12-31 23:59:59' ;
            $endDate = new \DateTime($end) ;
			$this->settings['startDateTimeStamp'] = $startDate->getTimestamp()  ;
			$this->settings['year'] = ($this->settings['year'] ??  date( "Y" , $startDate->getTimestamp() )) ;
			$this->settings['endDateTimeStamp']   = $endDate->getTimestamp()  ;

			if ( $this->settings['endDateTimeStamp']  < time() ) {
				$this->settings['afterenddate'] = TRUE ;
				$this->view->assign('mypid', $this->settings['list']['pid']['myanswersView']) ;
			} else {			
				if ( $this->settings['startDateTimeStamp']  < time() ) {
					if ( $this->settings['startDateTimeStamp']  < (time()	- (60*60*24))) {
						$this->view->assign('yesterdayspid', $this->settings['list']['pid']['singleView']) ;
					}
					if ( date("G") > date("G" , $this->settings['startDateTimeStamp']) ) {
						if ( $this->settings['startDateTimeStamp']  > (time()	- (60*60*24* (int)$this->settings['days']))) {
							$this->view->assign('todayspid', $this->settings['list']['pid']['singleView']) ;
						}	
					}
					$this->view->assign('mypid', $this->settings['list']['pid']['myanswersView']) ; 
				} else {
					$this->settings['beforestartdate'] = TRUE ;
				}
			}	
		if ( $this->isOrganisator == true	) {
			$this->view->assign('mypid', $this->settings['list']['pid']['myanswersView']) ; 
		}
		$this->settings['sys_language_uid'] = $this->context->getPropertyFromAspect('language', 'id')  ; 

		 $count = date("d" , mktime( 0,0,0, date("m" , $this->settings['startDateTimeStamp'] ) , date("d" )  ,date("Y" , $this->settings['startDateTimeStamp'] )  ) ) ;
         $count = min ( $count , 24 ) ;
		 $this->view->assign('adventCounter', $count);

		return true;
	}		


public function translate($label, $arguments = null) {
         if (!str_starts_with($label , 'LLL:')) {
             $label = 'LLL:EXT:jvadvent/Resources/Private/Language/locallang.xlf:' . $label ;
         }
	     return (LocalizationUtility::translate( $label, 'jvadvent', $arguments) ?? $label);
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


 public function injectUserRepository(UserRepository $userRepository): void
 {
     $this->userRepository = $userRepository;
 }

 public function injectUser(User $user): void
 {
     $this->user = $user;
 }
}

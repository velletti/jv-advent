<?php

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
***************************************************************/



/**
 * Controller for varius objects
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

class Tx_Nemadvent_Controller_BaseController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * @var Tx_Nemadvent_Domain_Repository_WinnerRepository
	 * @inject
	 */
	protected $winnerRepository;

	/**
	 * @var Tx_Nemadvent_Domain_Repository_AdventRepository
	 * @inject
	 */
	protected $adventRepository;

	/**
	 * @var Tx_Nemadvent_Domain_Repository_AdventCatRepository
	 * @inject
	 */
	protected $adventCatRepository;

	/*
	 * @var Tx_Nemadvent_Domain_Repository_UserRepository
	 * @inject
	 */
	protected $userRepository;

	/*
	 * @var Tx_Nemadvent_Domain_Model_User
	 * @inject
	 */
	protected $user;

	/*
	 * @var Tx_Extbase_Domain_Repository_FrontendUserRepository
	 * @inject
	 */

	protected $frontendUserRepository;


	/*
	 * @var Tx_Extbase_Domain_Repository_FrontendUserGroupRepository
	 * @inject
	 */
	protected $frontendUserGroupRepository;



	/**
	 * Initializes the current action
	 *
	 * @return void
	 */
	public function initializeAction() {
		$this->adventRepository	 	= $this->objectManager->get('Tx_Nemadvent_Domain_Repository_AdventRepository') ;
		$this->adventCatRepository	= $this->objectManager->get('Tx_Nemadvent_Domain_Repository_AdventCatRepository') ;
		$this->userRepository	 	= $this->objectManager->get('Tx_Nemadvent_Domain_Repository_UserRepository') ;
		$this->winnerRepository	 	= $this->objectManager->get('Tx_Nemadvent_Domain_Repository_winnerRepository') ;


		$this->frontendUserRepository 	= $this->objectManager->get('Tx_Extbase_Domain_Repository_FrontendUserRepository');
		$this->frontendUserGroupRepository = $this->objectManager->get('Tx_Extbase_Domain_Repository_FrontendUserGroupRepository');

		$GLOBALS['TSFE']->additionalHeaderData['Tx_Nemadvent_CSS'] = '<link rel="stylesheet" type="text/css" href="typo3conf/ext/nemadvent/Resources/Public/Css/tx_nemadvent.css" media="screen, projection" />'."\n";
		$this->initJS($this->settings['jsFiles']);
	}
	/**
	 * add css-files to header
	 *
	 * @array $files array with pathes to css-files, typically from typoscript
	 * @return void
	 *
	 */
	public function initCSS($files) {
		if ( is_array($files)) {
			foreach($files as $cssFile) {
				$GLOBALS['TSFE']->additionalHeaderData['Tx_Nemadvent_'.str_replace(array('/', '.'), '_', $cssFile)] = '<link rel="stylesheet" type="text/css" href="'.$cssFile.'" media="screen, projection" />'."\n";
			}	
		}
		
	}

	/**
	 * add js-files to header
	 *
	 * @array $files array with pathes to js-files, typically from typoscript
	 * @return void
	 *
	 */
	public function initJS($files) {
		if ( is_array($files)) {
			foreach($files as $jsFile) {
				$GLOBALS['TSFE']->additionalHeaderData['Tx_Nemadvent_'.str_replace(array('/', '.'), '_', $jsFile)] = '<script type="text/javascript" src="'.$jsFile.'"></script>'."\n";
			}
		}
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
		$this->adventCat =  $this->adventCatRepository->findByUid( $this->settings['advent']['list']['filter']['adventCat'] );
		// debug($this->settings['advent']['list']['filter']['adventCat']) ;	
		// debug($this->adventCat) ;
		
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
		$this->settings['sys_language_uid'] = $GLOBALS['TSFE']->sys_language_uid  ; 
		
		$this->view->assign('adventscat', $this->adventCat);
		
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
		$identifier =  $identifier . "-". $GLOBALS['TSFE']->sys_language_uid ;
		$where = 'identifier = "' . $identifier . '" and lifetime > ' . time() . " AND pid = " . $GLOBALS['TSFE']->id;
 		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('content','tx_nemadvent_cache', $where, '' , '');
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
	function put_content_to_Cache($identifier , $content ) {
		$this->CacheDebug .=  '<br>put: -> ' . $identifier . " -> CacheTime" . $this->CacheTime ;	
		if ( $this->CacheTime > 0 ) {
				
			$this->delete_from_Cache($identifier ) ;
			$identifier =  $identifier . "-". $GLOBALS['TSFE']->sys_language_uid ;
			$data = array ( 'pid' => $GLOBALS['TSFE']->id  ,
							'identifier' => $identifier ,
							'lifetime' => time() + $this->CacheTime ,
							'content' => $content ,
						);
			$res = $GLOBALS["TYPO3_DB"]->exec_INSERTquery("tx_nemadvent_cache", $data);	
			
			$this->CacheDebug .=  ' -> til: ' . ( time() + $this->CacheTime )  ;	
		}	
	}
	/*
	 * delete from Cache by Identifier
	 *
	 * @param	string		$identifier 
	 * @return	''
	 */	
	function delete_from_Cache($identifier ) {
		$identifier =  $identifier . "-". $GLOBALS['TSFE']->sys_language_uid ;
		$this->CacheDebug .=  '<br>delete: -> ' . $identifier . " -> CacheTime" . $this->CacheTime ;	
		$where = 'identifier LIKE "' . $identifier . '" AND pid = "' . $GLOBALS['TSFE']->id  . '"' ;
		$res = $GLOBALS["TYPO3_DB"]->exec_DELETEquery("tx_nemadvent_cache", $where );	
		
	}

	/*
	 * translate function
	 * @param string $label the locallang label to translate
	 * @return string the localized String 
	 * @author Martin Heigermoser <martin.heigermoser@typovision.de>
	 */
	public function translate($label , $arguments=NULL) {
		return \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate($label, 'Nemadvent' , $arguments );
	}

	public function showArrayAsJson($output) {
		$jsonOutput = json_encode($output);
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Cache-Control: no-cache, must-revalidate');
		header('Pragma: no-cache');
		header('Content-Length: ' . strlen($jsonOutput));
		header('Content-Type: application/json; charset=utf-8');
		header('Content-Transfer-Encoding: 8bit');

		$callbackId = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP("callback");
		if ( $callbackId == '' ) {
			echo $jsonOutput;
		} else {
			echo $callbackId . "(" . $jsonOutput . ")";
		}

		die;
		exit();
	}
}
?>

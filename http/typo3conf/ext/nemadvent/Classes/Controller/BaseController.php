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

class Tx_Nemadvent_Controller_BaseController extends Tx_Extbase_MVC_Controller_ActionController {

	

	/**
	 * add css-files to header
	 *
	 * @array $files array with pathes to css-files, typically from typoscript
	 * @return void
	 *
	 */
	public function initCSS($files) {
		foreach($files as $cssFile) {
			$GLOBALS['TSFE']->additionalHeaderData['Tx_Nemadvent_'.str_replace(array('/', '.'), '_', $cssFile)] = '<link rel="stylesheet" type="text/css" href="'.$cssFile.'" media="screen, projection" />'."\n";
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
		foreach($files as $jsFile) {
			$GLOBALS['TSFE']->additionalHeaderData['Tx_Nemadvent_'.str_replace(array('/', '.'), '_', $jsFile)] = '<script type="text/javascript" src="'.$jsFile.'"></script>'."\n";
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
	 * translate function
	 * @param string $label the locallang label to translate
	 * @return string the localized String 
	 * @author Martin Heigermoser <martin.heigermoser@typovision.de>
	 */
	public function translate($label , $arguments=NULL) {
		return Tx_Extbase_Utility_Localization::translate($label, 'Nemadvent' , $arguments );	
	}
}
?>

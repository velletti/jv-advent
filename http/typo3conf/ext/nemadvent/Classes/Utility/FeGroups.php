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

class Tx_Nemadvent_Utility_FeGroups {

	//put your code here

	static function generateGroupList(Tx_Extbase_Persistence_ObjectStorage  $groups) {
		$groupList = array();
		foreach ($groups as $group) {
			array_push($groupList, $group->getUid());
		}
		return $groupList;
	}

	static function getFeUserGroupList() {
		$groupList = array();
		if (!empty($GLOBALS['TSFE']->fe_user->user) && is_array($GLOBALS['TSFE']->fe_user->groupData['uid'])) {
			foreach ($GLOBALS['TSFE']->fe_user->groupData['uid'] as $feGroup) {
				array_push($groupList, $feGroup);
			}
		}
		return $groupList;
	}

	static function hasAccess(Tx_Extbase_Persistence_ObjectStorage $groups=null) {
		$groupList = array();

		if ($groups != null && count($groups)) {

			$groupList = self::generateGroupList($groups);
			$feUserGroupList = self::getFeUserGroupList();
			foreach ($feUserGroupList as $feGroup) {
				if (in_array($feGroup, $groupList)) {
					return true;
				}
			}
			return false;
		}
		return true;
	}
	
	static function needSPAccess(Tx_Extbase_Persistence_ObjectStorage $groups=null) {
		$groupList = array();
	//	echo "ich bin hier : ... " ;

		if ($groups != null && count($groups)) {
			// j.v. kann man das Objekt auch laden mit userGroup 11= Customer?
			$groupList = self::generateGroupList($groups);
		//	var_dump($groupList) ;
		//	die() ;
			if (in_array("11", $groupList)) {
				return false;
			}
			return true;
		}
		return false;
	}
	
	static function needNemAccess(Tx_Extbase_Persistence_ObjectStorage $groups=null) {
		
		$groupList = array();
	//	echo "ich bin hier : ... " ;

		if ($groups != null && count($groups)) {
			// j.v. kann man das Objekt auch laden mit userGroup 11= Customer bzw. Customer etc ?
			$groupList = self::generateGroupList($groups);
		//	var_dump($groupList) ;
		//	die() ;
			if (in_array("11", $groupList) or in_array("3", $groupList) or in_array("10", $groupList)) {
				return false;
			}
			// if not check if user is in Nem Group 7 ... if he is, fake the Value need NemAccess to false
			$feUserGroupList = self::getFeUserGroupList();
			if (in_array("7", $feUserGroupList )) {
				return false;
			} else {
				return true ;
			}
		}
		return false;
	}	
}

?>

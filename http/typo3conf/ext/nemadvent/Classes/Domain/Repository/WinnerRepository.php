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

class Tx_Nemadvent_Domain_Repository_WinnerRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {
	
	/**
	 * find advent by given tag object
	 *
	 * @param Tx_Nemadvent_Domain_Model_AdventCat $adventCat
	 * @param integer $questiondate
	 * @param integer $uid
	 * @return array advents
	 *
	 */
	public function getWinnerlist( $pid =0) {
		$query = $this->createQuery();
		$querystring = 'SELECT * from tx_nemadvent_domain_model_winner p ' .
	//					'LEFT JOIN fe_users AS u ON u.uid = p.feuser_uid ' .
						'where p.pid="' .$pid .'" '.
						'  and p.deleted="0" and p.hidden="0" and p.sys_language_uid = ' . $GLOBALS['TSFE']->sys_language_uid .
						' order by p.points DESC, p.date DESC, p.sorting ASC'
						;
	//	echo $querystring ;
				$return = $query->statement( $querystring )->execute()->toArray() ;
		// $return = $query->matching($query->equals('pid', $pid))->execute();

		return $return;
	}


	
}
?>
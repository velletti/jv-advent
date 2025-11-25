<?php
namespace Jvelletti\JvAdvent\Domain\Repository ;
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

class AdventRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {
	
	/**
	 * find advent by given tag object
	 *
	 * @param \Allplan\Nemadvent\Domain\Model\AdventCat $adventCat
	 * @param integer $questiondate
	 * @param integer $uid
	 * @return array advents
	 *
	 */
	public function findOneByFilter( \Allplan\Nemadvent\Domain\Model\AdventCat $adventCat=NULL , $questiondate=0, $uid =0) {
			
		$query = $this->createQuery();
		
		$query->getQuerySettings()->setIgnoreEnableFields(true);
		$query->getQuerySettings()->setRespectStoragePage(false);
		$query->getQuerySettings()->setRespectSysLanguage(false);
		$query->setOrderings(array( 'date' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING )) ;


		if ($adventCat!= NULL){
			$queryParams[] = $query->contains('categories', $adventCat);
            $queryParams[] = $query->equals('sys_language_uid', $adventCat->getSysLanguageUid() );
		}		
					
		if 	( $questiondate > 0 ) {
			$queryParams[] = $query->greaterThan('date', ($questiondate - (60 *60 * 4)));
			$queryParams[] = $query->lessThan('date', ($questiondate + (60 * 60 * 4 )));
		}
		if 	( $uid > 0 ) {
			$queryParams[] = $query->equals('uid', $uid);
		}		

		$query = $query->matching($query->logicalAnd(...$queryParams));
		$return =  $query->execute() ;

		return $return;
	}


}
?>
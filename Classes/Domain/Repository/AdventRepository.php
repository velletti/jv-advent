<?php
namespace Jvelletti\JvAdvent\Domain\Repository ;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Storage\Typo3DbQueryParser;

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
	 * @param integer|null $questiondate
	 * @param integer|null $uid
	 *
	 */
	public function findOneByFilter(  $questiondate=0, $uid =0)
    {
			
		$query = $this->createQuery();
		
		$query->getQuerySettings()->setIgnoreEnableFields(true);

		if 	( $questiondate > 0 ) {
			$queryParams[] = $query->greaterThan('date', ($questiondate - (60 *60 * 4)));
			$queryParams[] = $query->lessThan('date', ($questiondate + (60 * 60 * 4 )));

		}
		if 	( $uid > 0 ) {
			$queryParams[] = $query->equals('uid', $uid);
		}
        $query = $query->matching($query->logicalAnd(...$queryParams));
		$return =  $query->execute()->toArray() ;
        // $this->debug($query) ;
        if ( is_array( $return ) && count($return) > 0 ) {
            return $return[0] ;
        }
		return false;
	}

    /**
     * find advent by given tag object
     *
     * @param integer|null $questiondate
     * @param integer|null $uid
     *
     */
    public function findAll(  )
    {

        $query = $this->createQuery();

        $query->getQuerySettings()->setIgnoreEnableFields(true);
        $query->setOrderings(array( 'date' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING )) ;

        return  $query->execute()->toArray() ;
    }
    private function debug($query): void  {

        $queryParser = GeneralUtility::makeinstance(Typo3DbQueryParser::class);

        $select = $queryParser->convertQueryToDoctrineQueryBuilder($query)->getSQL() ;
        $params = ($queryParser->convertQueryToDoctrineQueryBuilder($query)->getParameters());
        $params = array_reverse($params) ;
        foreach ($params  as $index => $param) {
            if( is_string( $param)) {
                $param = "'" . $param . "'" ;
            }
            $select = str_replace( ":" . $index , $param ,  $select)  ;
        }
        echo $select;
        die;
    }

}
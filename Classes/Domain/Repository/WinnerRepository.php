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

class WinnerRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {
	
	/**
	 * find all Winners on a specific page
	 *
	 * @param integer $pid
	 * @return array $winners
	 *
	 */
	public function getWinnerlist( $year = 0 , $limit = 20) {
		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectSysLanguage(false);
        $query->matching(
            $query->equals('advent_uid', $year)
        );
        $query->setLimit($limit);
        $query->setOrderings(['points' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING ,
                             'subpoints' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
                            ]);
		return $query->execute();
	}

    public function getWinnerByUserAndYear( $userUid, $year) {
        $query = $this->createQuery();

        $query->matching(
            $query->logicalAnd(
                $query->equals('feuser_uid', $userUid),
                $query->equals('advent_uid', $year)
            )
        );
        // $this->debug($query) ;

        return $query->execute()->getFirst();
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

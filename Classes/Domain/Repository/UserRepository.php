<?php
namespace Jvelletti\JvAdvent\Domain\Repository ;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
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

class UserRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {


    /**
	 * Updates the counter for a advent
	 * @param integer $pid
	 *  @param integer $feUserUid
	 * @param \Jvelletti\JvAdvent\Domain\Model\Advent $question
	 *  @param integer $points
	 * @param integer $subpoints
	 * @param integer $answer
	 * @return int $result
	 */
	
	public function insertAnswer( $pid ,$feUserUid,\Jvelletti\JvAdvent\Domain\Model\Advent $question,$points,$subpoints,$answer){
        $return = false;

        if ($feUserUid > 0 && ($answer > 0 || $subpoints > 0) && is_object($question) ) {
            $connection = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getConnectionForTable('tx_jvadvent_domain_model_user');

            // SELECT
            $queryBuilder = $connection->createQueryBuilder();
            $row = $queryBuilder
                ->select('*')
                ->from('tx_jvadvent_domain_model_user')
                ->where(
                    $queryBuilder->expr()->eq('feuser_uid', $queryBuilder->createNamedParameter((int)$feUserUid, \PDO::PARAM_INT)),
                    $queryBuilder->expr()->eq('advent_uid', $queryBuilder->createNamedParameter((int)$question->getYear(), \PDO::PARAM_INT)),
                    $queryBuilder->expr()->eq('question_uid', $queryBuilder->createNamedParameter((int)$question->getUid(), \PDO::PARAM_INT))
                )
                ->setMaxResults(1)
                ->executeQuery()
                ->fetchAssociative();
            if ( is_array($row) ) {
                if ($row['crdate'] > time() - (60 * 60 * 24) || $row['crdate'] < 1) {
                    if ($row['crdate'] < 1) {
                        $row['crdate'] = time();
                    }
                } else {
                    return ['TO-OLD' => $row['crdate']];
                }

                // DELETE
                $connection->delete(
                    'tx_jvadvent_domain_model_user',
                    [
                        'feuser_uid' => (int)$feUserUid,
                        'advent_uid' => (int)$question->getYear(),
                        'question_uid' => (int)$question->getUid()
                    ]
                );
            }


            // INSERT
            $updateData = [
                'pid' => $pid,
                'crdate' => ($row['crdate'] ?? time()),
                'tstamp' => time(),
                'feuser_uid' => (int)$feUserUid,
                'sys_language_uid' => -1,
                'usergroup' => ($GLOBALS['TSFE']->fe_user->user['usergroup'] ?? ''),
                'customerno' => ($GLOBALS['TSFE']->fe_user->user['tx_nem_cnum'] ?? ''),
                'question_uid' => (int)$question->getUid(),
                'question_date' => (int)$question->getDate(),
                'question_datef' => date('d.m.Y', $question->getDate()),
                'answer_uid' => (int)$answer,
                'points' => (int)$points,
                'subpoints' => (int)$subpoints,
                'advent_uid' => (int)$question->getYear(),
            ];
            $connection->insert('tx_jvadvent_domain_model_user', $updateData);
            $return = true;
        }
        return $return;
	}
	
	/**
	 * get answerlist for user
	 * @param integer $year
	 * @param integer $feUserUid
	 * @param integer $limit
	 * @param integer $offset
	 *  @return array answers
	 */
	public function findMyanswers( $year=0 , $feUserUid= 0 ){
		$query = $this->createQuery();

		$query->getQuerySettings()->setIgnoreEnableFields(true);
		$query->getQuerySettings()->setRespectStoragePage(false);
		$query->getQuerySettings()->setRespectSysLanguage(false);

		$queryParams[] = $query->equals('feuser_uid', $feUserUid);
		$queryParams[] = $query->equals('advent_uid', $year );

		$query->setOrderings(array( 'question_datef' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING )) ;


		$query = $query->matching($query->logicalAnd(...$queryParams));
		$return = $query->execute()->toArray() ;
        // $this->debug($query);
		return $return;
	}
	/**
	 * get ONE answer for user
	 * @param integer $feUserUid
	 * @param integer $question
	 * @param integer|null $question
	 *  @return array answer
	 */
	public function findAnswer( $feUserUid, $question, $year=0){
		$query = $this->createQuery();

		$query->getQuerySettings()->setIgnoreEnableFields(true);
		$query->getQuerySettings()->setRespectStoragePage(false);

		if ( $feUserUid > 0) {
			$queryParams[] = $query->equals('feuser_uid', $feUserUid);
		}
		if 	( $question > 0 ) {
			$queryParams[] = $query->equals('question_date', $question);
		}
        if 	( $year > 0 ) {
            $queryParams[] = $query->equals('advent_uid', $year);
        }

		$query = $query->matching($query->logicalAnd(...$queryParams));

		$return =  $query->execute() ;

		return $return;
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

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

class UserRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {
	
	 
 	/**
	 * Updates the counter for a advent
	 * @param \Allplan\Nemadvent\Domain\Model\AdventCat $adventCat
	 * @param integer $pid
	 *  @param integer $feUserUid
	 * @param \Allplan\Nemadvent\Domain\Model\Advent $question
	 *  @param integer $points
	 * @param integer $subpoints
	 * @param integer $answer
	 * @return int $result
	 */
	
	public function insertAnswer(\Allplan\Nemadvent\Domain\Model\AdventCat $adventCat, $pid ,$feUserUid,\Allplan\Nemadvent\Domain\Model\Advent $question,$points,$subpoints,$answer){
		$return = FALSE ;

		if ($feUserUid > 0 and  ( $answer > 0 OR $subpoints > 0 ) and is_object($question) ) {

			$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*' , 'tx_jvadvent_domain_model_user',
				"feuser_uid ='" .   intval($feUserUid) ."' AND "
				."advent_uid ='" .   intval($adventCat->getUid())    ."' AND "
				."question_uid ='" . intval($question->getUid()) ."'"
				, '' , '' , 1
			);
			$row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res ) ;

			if( $row['crdate'] > time() - ( 60*60*24) || $row['crdate'] < 1 )  {
				if ( $row['crdate'] < 1 ) {
					$row['crdate'] = time() ;
				}
			} else {
				return array( "TO-OLD" => $row['crdate'] ) ;
			}


			$res = $GLOBALS['TYPO3_DB']->exec_DELETEquery('tx_jvadvent_domain_model_user', 
															"feuser_uid ='" .   intval($feUserUid) ."' AND "
															."advent_uid ='" .   intval($adventCat->getUid())    ."' AND "
															."question_uid ='" . intval($question->getUid()) ."'"
															);
			
			
				
			$updateData = array ( 	"pid" 				=> $pid , 
									"crdate" 			=> $row['crdate'] ,
									"tstamp" 			=> time() ,
									"feuser_uid" 		=> intval($feUserUid) , 
									"sys_language_uid" 	=> $GLOBALS['TSFE']->sys_language_uid  , 
									"usergroup" 		=> $GLOBALS['TSFE']->fe_user->user['usergroup'] , 
									"customerno" 		=> $GLOBALS['TSFE']->fe_user->user['tx_nem_cnum'] ,
									"question_uid" 		=> intval($question->getUid() ) , 
									"question_date" 	=> intval($question->getDate() ) , 
									"question_datef" 	=> date( "d.m.Y" , $question->getDate() ) , 
									"answer_uid" 		=> intval($answer) , 
									"points" 			=> intval($points) , 
									"subpoints" 		=> intval($subpoints) , 
									"advent_uid" 		=> intval($adventCat->getUid()) , 
								) ;

			$return = $GLOBALS['TYPO3_DB']->exec_INSERTquery('tx_jvadvent_domain_model_user'
								, $updateData);	
		}
		return $return;
	}
	
	/**
	 * get answerlist for user
	 * @param \Allplan\Nemadvent\Domain\Model\AdventCat $adventCat
	 * @param integer $feUserUid
	 * @param integer $limit
	 * @param integer $offset
	 *  @return array answers
	 */
	public function findMyanswers(\Allplan\Nemadvent\Domain\Model\AdventCat $adventCat,$feUserUid= 0, $limit=24,$offset= 0){
		$query = $this->createQuery();

		$query->getQuerySettings()->setIgnoreEnableFields(true);
		$query->getQuerySettings()->setRespectStoragePage(false);

		if ($adventCat!= NULL){
			$queryParams[] = $query->equals('advent_uid', $adventCat->getUid());
		}

		$queryParams[] = $query->equals('feuser_uid', $feUserUid);
		$queryParams[] = $query->equals('sys_language_uid', $GLOBALS['TSFE']->sys_language_uid );

		$query->setOrderings(array( 'question_datef' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING )) ;


		$query = $query->matching($query->logicalAnd(...$queryParams));
		$return = $query->execute()->toArray() ;
		// SELECT * FROM tx_jvadvent_domain_model_user where ( advent_uid="72" and feuser_uid="353" and sys_language_uid="1" ) ORDER BY question_datef ASC
		return $return;
	}
	/**
	 * get ONE answer for user
	 * @param \Allplan\Nemadvent\Domain\Model\AdventCat $adventCat
	 * @param integer $feUserUid
	 * @param integer $question
	 *  @return array answer
	 */
	public function findAnswer(\Allplan\Nemadvent\Domain\Model\AdventCat $adventCat,$feUserUid, $question){
		$query = $this->createQuery();

		$query->getQuerySettings()->setIgnoreEnableFields(true);
		$query->getQuerySettings()->setRespectStoragePage(false);

		if ($adventCat!= NULL){
			$queryParams[] = $query->equals('advent_uid', $adventCat->getUid());
		}

		if ( $feUserUid > 0) {
			$queryParams[] = $query->equals('feuser_uid', $feUserUid);
		}
		if 	( $question > 0 ) {
			$queryParams[] = $query->equals('question_date', $question);
		}

		$query = $query->matching($query->logicalAnd(...$queryParams));

		$return =  $query->execute() ;

		return $return;
	}

}
?>
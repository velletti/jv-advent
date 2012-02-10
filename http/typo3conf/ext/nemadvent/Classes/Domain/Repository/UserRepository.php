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

class Tx_Nemadvent_Domain_Repository_UserRepository extends Tx_Extbase_Persistence_Repository {
	
	 
 	/**
	 * Updates the counter for a advent
	 * @param Tx_Nemadvent_Domain_Model_AdventCat $adventCat
	 * @param integer $pid
	 *  @param integer $feUserUid
	 * @param Tx_Nemadvent_Domain_Model_Advent $question
	 *  @param integer $points
	 * @param integer $subpoints
	 * @param integer $answer
	 * @return int $result
	 */
	
	public function insertAnswer(Tx_Nemadvent_Domain_Model_AdventCat $adventCat, $pid ,$feUserUid,Tx_Nemadvent_Domain_Model_Advent $question,$points,$subpoints,$answer){
		$return = FALSE ;
		if ($feUserUid > 0 and  $answer > 0 and is_object($question) ) {
			$delquery = $this->createQuery();
			$delquerystatement ="DELETE from tx_nemadvent_domain_model_user WHERE "
										."feuser_uid ='" .   intval($feUserUid) ."' AND "
										."advent_uid ='" .   intval($adventCat->getUid())    ."' AND "
										."question_uid ='" . intval($question->getUid())
										."'" ; 
			$delete = $delquery->statement($delquerystatement)->execute() ; 
			// echo $delquerystatement ;							
			// debug( $delete) ;
			// die() ;	
				
			$query = $this->createQuery();
			$return = $query->statement('INSERT INTO tx_nemadvent_domain_model_user 
							(pid,crdate, tstamp, feuser_uid, sys_language_uid, usergroup, customerno, question_uid,question_date,question_datef,answer_uid,points,subpoints,advent_uid)
							
							VALUES( ' . $pid .','. 
									time().','. 
									time().','.
									intval($feUserUid).','.
									$GLOBALS['TSFE']->sys_language_uid .',"'.
									$GLOBALS['TSFE']->fe_user->user['usergroup'] .'","'.
									$GLOBALS['TSFE']->fe_user->user['tx_barafereguser_nem_cnum'] .'",'.
									
									intval($question->getUid() ).','.
									intval($question->getDate() ).','.
									'"' . date( "d.m.Y" , $question->getDate() ).'",'.
									
									intval($answer).','.
									intval($points).','.
									intval($subpoints).','.
									
									intval($adventCat->getUid()).
									')')->execute();
			
		}
		return $return;
	}
	
	/**
	 * get answerlist for user
	 * @param Tx_Nemadvent_Domain_Model_AdventCat $adventCat
	 * @param integer $feUserUid
	 * @param integer $limit
	 * @param integer $offset
	 *  @return array answers
	 */
	public function findMyanswers(Tx_Nemadvent_Domain_Model_AdventCat $adventCat,$feUserUid= 0, $limit=24,$offset= 0){
		$query = $this->createQuery();
		
		$querystring = 'SELECT * FROM tx_nemadvent_domain_model_user ' .
						 			'where (  advent_uid="' .$adventCat->getUid() .'" ' ;
		if ( $feUserUid > 0) {
			$querystring .= ' and feuser_uid="' .$feUserUid .'" ' ;
		}							
		$querystring .= 			') ORDER BY question_date ASC ' .
						  			'LIMIT ' . $offset . ',' . $limit  ;

		$return = $query->statement( $querystring )->execute();
		return $return;
	}
	 
}
?>
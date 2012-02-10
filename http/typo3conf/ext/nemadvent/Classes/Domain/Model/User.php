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

class Tx_Nemadvent_Domain_Model_User extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * @var DateTime
	 */
	protected $crdate;
	/**
	 * @var integer
	 */
	protected $questionDate;
	
		/**
	 * @var integer
	 */
	protected $questionUid;
	
		/**
	 * @var integer
	 */
	protected $answerUid;
	
			/**
	 * @var integer
	 */
	protected $adventUid;
	/**
	 * @var integer
	 */
	protected $hidden;

	/**
	 * @var integer
	 */
	protected $points;
	
	/**
	 * @var integer
	 */
	protected $subpoints;

	/**
	 * FeUser
	 *
	 * @var integer
	 */
	protected $feuserUid;

	/**
	 * The advents of this category
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Nemadvent_Domain_Model_Advent>
	 * @lazy
	 */
	protected $advents;

	/**
	 * Constructor. Initializes all Tx_Extbase_Persistence_ObjectStorage instances.
	 */
	public function __construct() {

	}

	/**
	 * Getter for uid
	 *
	 * @return integer uid
	 */
	public function getAnswerUid(){
		return $this->answerUid;
	}
		/**
	 * Getter for uid
	 *
	 * @return integer uid
	 */
	public function getAdventUid(){
		return $this->adventUid;
	}

	/**
	 * Getter for uid
	 *
	 * @return integer uid
	 */
	public function getQuestionUid(){
		return $this->questionUid;
	}
	
	/**
	 * Getter for date
	 *
	 * @return integer date
	 */
	public function getQuestionDate(){
		return $this->questionDate;
	}
	
	/**
	 * Getter for hidden
	 *
	 * @return integer hidden
	 */
	
	public function getHidden(){
		return $this->hidden;
	}
		
	/**
	 * Getter for points
	 *
	 * @return integer feuserUid
	 */
	public function getPoints() {
		return $this->points;
	}	
	
	/**
	 * Getter for subpoints
	 *
	 * @return integer feuserUid
	 */
	public function getSubpoints() {
		return $this->subpoints;
	}	
	
	public function getLocalizedUid() {
	  $uid = ($this->_localizedUid?$this->_localizedUid:$this->uid);
		return $uid;
	}
	
	/**
	 * Getter for feuser
	 *
	 * @return integer feuserUid
	 */
	public function getFeuserUid() {
		return $this->feuserUid;
	}	
}

?>

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

class Tx_Nemadvent_Domain_Model_Advent extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * @var string
	 */
	protected $title;
	/**
	 * @var integer
	 */
	protected $answer_uid;
	/**
	 * @var string
	 */
	protected $myanswertext;
		/**
	 * @var string
	 */
	protected $answer1;
		/**
	 * @var string
	 */
	protected $answer2;
		/**
	 * @var string
	 */
	protected $answer3;
		/**
	 * @var string
	 */
	protected $answer4;
		/**
	 * @var string
	 */
	protected $answer5;
		/**
	 * @var string
	 */
	protected $correct;
	
	/**
	 * @var integer
	 */
	protected $storeonpid;
	
	/**
	 * @var DateTime
	 */
	protected $crdate;
	/**
	 * @var integer
	 */
	protected $date;
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
	 * @var string
	 */
	protected $descShort;
	/**
	 * @var string
	 */
	protected $descLong;

	/**
	 * @var string
	 */
	protected $solution;

	/**
	 * @var integer
	 */
	protected $userAnswer;

	/**
	 * image
	 * @var Tx_ExtbaseDam_Domain_Model_Dam
	 * @lazy
	 */
	protected $image;
	/**
	 * @var string
	 */
	protected $video;
	/**
	 * The categories of this advent
	 *
	 * @var Tx_Nemadvent_Domain_Model_AdventCat
	 */
	protected $categories;


	/**
	 * FeGroup
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Extbase_Domain_Model_FrontendUserGroup>
	 */
	protected $feGroup;

	/**
	 * Constructor. Initializes all Tx_Extbase_Persistence_ObjectStorage instances.
	 */
	public function __construct() {
	}

	/**
	 * Getter for categories
	 *
	 * @return Tx_Nemadvent_Domain_Model_AdventCat categories
	 */
	public function getCategories() {
		return $this->categories;
	}

	/**
	 * Getter for title
	 *
	 * @return string title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Getter for descShort
	 *
	 * @return string descShort
	 */
	public function getDescShort() {
		return $this->descShort;
	}

	/**
	 * Getter for descLong
	 *
	 * @return string descLong
	 */
	public function getDescLong() {
		return $this->descLong;
	}
	/**
	 * Getter for crdate
	 *
	 * @return string descLong
	 */
	public function getCrdate(){
		return $this->crdate;
	}
	/**
	 * Getter for date
	 *
	 * @return integer date
	 */
	public function getDate(){
		return $this->date;
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
	 * Getter for viewed
	 *
	 * @return integer viewed
	 */
	public function getViewed(){
		return $this->viewed;
	}
	/**
	 * Getter for image
	 *
	 * @return Tx_ExtbaseDam_Domain_Model_Dam Location image
	 */
	public function getImage() {
	  $uid = ($this->_localizedUid?$this->_localizedUid:$this->uid);
		return Tx_ExtbaseDam_Utility_Dam::getOne('tx_nemadvent_domain_model_advent', $uid, 'tx_nemadvent_domain_model_advent_image');
	}
	/**
	 * Getter for uid
	 *
	 * @return string uid
	 */
	public function getLocalizedUid() {
	  $uid = ($this->_localizedUid?$this->_localizedUid:$this->uid);
		return $uid;
	}
	
	/**
	 * Getter for feGroup
	 *
	 * @return Tx_Extbase_Domain_Model_FrontendUserGroup
	 */
	public function getFeGroup() {
		return $this->feGroup;
	}

	/**
	 * Setter for feGroup 
	 *
	 * @param Tx_Extbase_Domain_Model_FrontendUserGroup $feGroup
	 */
	public function setFeGroup($feGroup) {
		$this->feGroup = $feGroup;
	}

	public function getHasAccess() {
		return Tx_Nemadvent_Utility_FeGroups::hasAccess($this->getFeGroup());
	}

	public function getneedSPAccess() {
		return Tx_Nemadvent_Utility_FeGroups::needSPAccess($this->getFeGroup());
	}
		/**
	 * Getter for answer
	 *
	 * @return integer answer
	 */
	public function getAnswer_uid() {
		return $this->answer_uid ;
	}		
	/**
	 * Getter for myanswertext
	 *
	 * @return string myanswerteyt
	 */
	public function getMyanswertext($num) {
		switch ($num) {
			case '1':
				return $this->answer1;
				break;
			case '2':
				return $this->answer2;
				break;
			case '3':
				return $this->answer3;
				break;
			case '4':
				return $this->answer4;
				break;
			case '5':
				return $this->answer5;
				break;												
		}
		return "No answer found with number: " . $num;
	}
	/**
	 * Getter for answer1
	 *
	 * @return string answer1
	 */
	public function getAnswer1() {
		return $this->answer1;
	}
	
	/**
	 * Getter for answer2
	 *
	 * @return string answer2
	 */
	public function getAnswer2() {
		return $this->answer2;
	}
	/**
	 * Getter for answer3
	 *
	 * @return string answer3
	 */
	public function getAnswer3() {
		return $this->answer3;
	}
	/**
	 * Getter for answer4
	 *
	 * @return string answer4
	 */
	public function getAnswer4() {
		return $this->answer4;
	}
	/**
	 * Getter for answer5
	 *
	 * @return string answer5
	 */
	public function getAnswer5() {
		return $this->answer5;
	}
	/**
	 * Getter for correct
	 *
	 * @return string correct
	 */
	public function getCorrect() {
		return $this->correct;
	}
	/**
	 * Getter for storeonpid
	 *
	 * @return string storeonpid
	 */
	public function getStoreonpid() {
		return $this->storeonpid;
	}	
	/**
	 * Getter for points
	 *
	 * @return string points
	 */
	public function getPoints() {
		return $this->points;
	}	
	/**
	 * Getter for subpoints
	 *
	 * @return string subpoints
	 */
	public function getSubpoints() {
		return $this->subpoints;
	}

	/**
	 * @param string $solution
	 */
	public function setSolution($solution) {
		$this->solution = $solution;
	}

	/**
	 * @return string
	 */
	public function getSolution() {
		return $this->solution;
	}

	/**
	 * @param int $answer_uid
	 */
	public function setAnswerUid($answer_uid) {
		$this->answer_uid = $answer_uid;
	}

	/**
	 * @return int
	 */
	public function getAnswerUid() {
		return $this->answer_uid;
	}

	/**
	 * @param int $userAnswer
	 */
	public function setUserAnswer($userAnswer) {
		$this->userAnswer = $userAnswer;
	}

	/**
	 * @return int
	 */
	public function getUserAnswer() {
		return $this->userAnswer;
	}

	/**
	 * @param string $video
	 */
	public function setVideo($video) {
		$this->video = $video;
	}

	/**
	 * @return string
	 */
	public function getVideo() {
		return $this->video;
	}
	
}

?>

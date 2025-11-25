<?php
namespace Jvelletti\JvAdvent\Domain\Model ;
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

class Advent extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

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
	 * @var integer
	 */
	protected $answer1count;

	/**
	 * @var integer
	 */
	protected $answer2count;

	/**
	 * @var integer
	 */
	protected $answer3count;

	/**
	 * @var integer
	 */
	protected $answer4count;

	/**
	 * @var integer
	 */
	protected $answer5count;

	/**
	 * @var integer
	 */
	protected $totalAnswers;

	/**
	 * @var string
	 */
	protected $correct;

	/**
	 * @var string
	 */
	protected $correct1;

	/**
	 * @var string
	 */
	protected $correct2 ;


	/**
	 * @var integer
	 */
	protected $storeonpid;

	/**
	 * @var integer
	 */
	protected $rangemin;

	/**
	 * @var integer
	 */
	protected $rangemax;

	/**
	 * @var \DateTime
	 */
	protected $crdate;
	/**
	 * @var integer
	 */
	protected $date;
	/**
	 * @var integer
	 */
	protected $viewed;
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
  * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
  */
 #[\TYPO3\CMS\Extbase\Annotation\ORM\Lazy]
 protected $image;
	/**
	 * @var string
	 */
	protected $video;



	/**
	 * FeGroup
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<Tx_Extbase_Domain_Model_FrontendUserGroup>
	 */
	protected $feGroup;

	/**
	 * Constructor. Initializes all \TYPO3\CMS\Extbase\Persistence\ObjectStorage instances.
	 */
	public function __construct() {
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
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	public function getImage() {
	  //$uid = ($this->_localizedUid?$this->_localizedUid:$this->uid);
		return $this->image ;
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
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup>
	 */
	public function getFeGroup() {
		return $this->feGroup;
	}

	/**
	 * Setter for feGroup 
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup> $feGroup
	 */
	public function setFeGroup($feGroup): void {
		$this->feGroup = $feGroup;
	}

	public function getHasAccess() {
		return \Allplan\Nemadvent\Utility\FeGroupsUtility::hasAccess($this->getFeGroup());
	}

	public function getneedSPAccess() {
		return \Allplan\Nemadvent\Utility\FeGroupsUtility::needSPAccess($this->getFeGroup());
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
	 * @param string $correct
	 */
	public function setCorrect($correct): void {
		$this->correct = $correct;
	}

	/**
	 * @param string $correct1
	 */
	public function setCorrect1($correct1): void {
		$this->correct1 = $correct1;
	}

	/**
	 * @return string
	 */
	public function getCorrect1() {
		return $this->correct1;
	}

	/**
	 * @param string $correct2
	 */
	public function setCorrect2($correct2): void {
		$this->correct2 = $correct2;
	}

	/**
	 * @return string
	 */
	public function getCorrect2() {
		return $this->correct2;
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
	public function setSolution($solution): void {
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
	public function setAnswerUid($answer_uid): void {
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
	public function setUserAnswer($userAnswer): void {
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
	public function setVideo($video): void {
		$this->video = $video;
	}

	/**
	 * @return string
	 */
	public function getVideo() {
		return $this->video;
	}

	/**
	 * @param int $answer1count
	 */
	public function setAnswer1count($answer1count): void {
		$this->answer1count = $answer1count;
	}

	/**
	 * @return int
	 */
	public function getAnswer1count() {
		return $this->answer1count;
	}

	/**
	 * @param int $answer2count
	 */
	public function setAnswer2count($answer2count): void {
		$this->answer2count = $answer2count;
	}

	/**
	 * @return int
	 */
	public function getAnswer2count() {
		return $this->answer2count;
	}

	/**
	 * @param int $answer3count
	 */
	public function setAnswer3count($answer3count): void {
		$this->answer3count = $answer3count;
	}

	/**
	 * @return int
	 */
	public function getAnswer3count() {
		return $this->answer3count;
	}

	/**
	 * @param int $answer4count
	 */
	public function setAnswer4count($answer4count): void {
		$this->answer4count = $answer4count;
	}

	/**
	 * @return int
	 */
	public function getAnswer4count() {
		return $this->answer4count;
	}

	/**
	 * @param int $answer5count
	 */
	public function setAnswer5count($answer5count): void {
		$this->answer5count = $answer5count;
	}

	/**
	 * @return int
	 */
	public function getAnswer5count() {
		return $this->answer5count;
	}

	/**
	 * @param int $totalAnswers
	 */
	public function setTotalAnswers($totalAnswers): void {
		$this->totalAnswers = $totalAnswers;
	}

	/**
	 * @return int
	 */
	public function getTotalAnswers() {
		return $this->totalAnswers;
	}

	/**
	 * @param int $rangemax
	 */
	public function setRangemax($rangemax): void {
		$this->rangemax = $rangemax;
	}

	/**
	 * @return int
	 */
	public function getRangemax() {
		return $this->rangemax;
	}

	/**
	 * @param int $rangemin
	 */
	public function setRangemin($rangemin): void {
		$this->rangemin = $rangemin;
	}

	/**
	 * @return int
	 */
	public function getRangemin() {
		return $this->rangemin;
	}
	
}

?>

<?php
namespace Allplan\Nemadvent\Domain\Model ;
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

class Winner extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * @var string
	 */
	protected $title;
	
		/**
	 * @var string
	 */

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
	 * @var string
	 */
	protected $descShort;
	/**
	 * @var string
	 */
	protected $descLong;

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
	 * pointtotal
	 *
	 * @var integer
	 */
	protected $pointtotal ;
	

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
	/**
	 * Getter for pointtotal
	 *
	 * @return integer $pointtotal
	 */
	public function getPointtotal() {
		return $this->pointtotal;
	}		
	
	
	
}

?>
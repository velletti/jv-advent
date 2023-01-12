<?php
namespace Allplan\Nemadvent\Domain\Model ;
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

class AdventCat extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var integer
	 */
	protected $startdate;

	/**
	 * @var integer
	 */
	protected $enddate;

	/**
	 * @var integer
	 */
	protected $days;

	/**
	 * @var string
	 */
	protected $mustacceptagb ;

	/**
	 * The advents of this category
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Allplan\Nemadvent\Domain\Model\Advent>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
	 */
	protected $advents;

	/**
	 * Constructor. Initializes all \TYPO3\CMS\Extbase\Persistence\ObjectStorage instances.
	 */
	public function __construct() {
	}

	/**
	 * Returns all advents in this category
	 *
	 * @return \Allplan\Nemadvent\Domain\Model\Advent
	 */
	public function getadvents() {
		return $this->advents;
	}
	
	/**
	 * Setter for title
	 *
	 * @param string title
	 * @return void
	 */
	public function setTitle($title) {
		return $this->title;
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
	 * Setter for mustacceptagb
	 *
	 * @param string mustacceptagb
	 * @return void
	 */
	public function setMustacceptagb($mustacceptagb) {
		return $this->mustacceptagb;
	}

	/**
	 * Getter for mustacceptagb
	 *
	 * @return string mustacceptagb
	 */
	public function getMustacceptagb() {
		return $this->mustacceptagb;
	}
	
	/**
	 * Getter for startdate
	 *
	 * @return integer startdate
	 */
	public function getStartdate() {
		return $this->startdate;
	}	
	/**
	 * Getter for startdate
	 *
	 * @return integer startdate
	 */
	
	public function getEnddate() {
		return $this->enddate;
	}	
	
	/**
	 * Getter for days
	 *
	 * @return integer days
	 */
	public function getDays() {
		return $this->days;
	}

    /**
     * @return int
     */
    public function getSysLanguageUid()
    {
        return $this->_languageUid;
    }




}

?>
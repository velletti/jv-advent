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

class Winner extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * @var string
	 */
	protected $title;
	
		/**
	 * @var string
	 */

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
    protected $count;


    /**
	 * @var integer
	 */
	protected $points;
	
	/**
	 * @var integer
	 */
	protected $subpoints;

    /**
     * @var integer
     */
    protected $adventUid;
	/**
	 * FeUser
	 *
	 * @var integer
	 */
	protected $feuserUid;

    /**
     * @var string
     */
    protected $customerno;


    /**
     * @var string
     */
    protected $usergroup;


    /**
     * @var string
     */
    protected $email;

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

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }


    public function setHidden(int $hidden): void
    {
        $this->hidden = $hidden;
    }

    public function setDescShort(string $descShort): void
    {
        $this->descShort = $descShort;
    }

    public function setPoints(int $points): void
    {
        $this->points = $points;
    }

    public function setSubpoints(int $subpoints): void
    {
        $this->subpoints = $subpoints;
    }

    public function setFeuserUid(int $feuserUid): void
    {
        $this->feuserUid = $feuserUid;
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

    public function getCount(): int
    {
        return $this->count;
    }

    public function setCount(int $count): void
    {
        $this->count = $count;
    }



    public function getDescLong(): string
    {
        return $this->descLong;
    }

    public function setDescLong(string $descLong): void
    {
        $this->descLong = $descLong;
    }

    public function getAdventUid(): int
    {
        return $this->adventUid;
    }

    public function setAdventUid(int $adventUid): void
    {
        $this->adventUid = $adventUid;
    }

    public function getCustomerno(): string
    {
        return ($this->customerno ?? '' );
    }

    public function setCustomerno(?string $customerno): void
    {
        $this->customerno = ($customerno ?? '' );
    }

    public function getUsergroup(): string
    {
        return $this->usergroup;
    }

    public function setUsergroup(string $usergroup): void
    {
        $this->usergroup = $usergroup;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setLanguage(?int $language): void
    {
        $this->_languageUid = (int)$language;
    }


}

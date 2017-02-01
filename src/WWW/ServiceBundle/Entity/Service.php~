<?php

namespace WWW\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Service
 */
class Service
{
    /**
     * @var int
     */
    private $id;
    
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \WWW\GlobalBundle\Entity\Photo
     */
    private $photo;

    /**
     * @var \WWW\ServiceBundle\Entity\ServiceCategory
     */
    private $category;
    
    /**
     * @var string
     */
    private $table;
    
    private $offers;

    public function __construct($id = null) {
        $this->id = null;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Service
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Service
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set photo
     *
     * @param \WWW\GlobalBundle\Entity\Photo $photo
     * @return Service
     */
    public function setPhoto(\WWW\GlobalBundle\Entity\Photo $photo = null)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return \WWW\GlobalBundle\Entity\Photo 
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set category
     *
     * @param \WWW\ServiceBundle\Entity\ServiceCategory $category
     * @return Service
     */
    public function setCategory(\WWW\ServiceBundle\Entity\ServiceCategory $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \WWW\ServiceBundle\Entity\ServiceCategory 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set table
     *
     * @param string $table
     * @return Service
     */
    public function setTable($table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Get table
     *
     * @return string 
     */
    public function getTable()
    {
        return $this->table;
    }
    /**
     * @var integer
     */
    private $defaultStatus;


    /**
     * Set defaultStatus
     *
     * @param integer $defaultStatus
     * @return Service
     */
    public function setDefaultStatus($defaultStatus)
    {
        $this->defaultStatus = $defaultStatus;

        return $this;
    }

    /**
     * Get defaultStatus
     *
     * @return integer 
     */
    public function getDefaultStatus()
    {
        return $this->defaultStatus;
    }

    /**
     * Add offer
     *
     * @param \WWW\ServiceBundle\Entity\Offer $offer
     *
     * @return Service
     */
    public function addOffer(\WWW\ServiceBundle\Entity\Offer $offer)
    {
        $this->offers[] = $offer;

        return $this;
    }

    /**
     * Remove offer
     *
     * @param \WWW\ServiceBundle\Entity\Offer $offer
     */
    public function removeOffer(\WWW\ServiceBundle\Entity\Offer $offer)
    {
        $this->offers->removeElement($offer);
    }

    /**
     * Get offers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOffers()
    {
        return $this->offers;
    }
}

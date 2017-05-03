<?php

namespace WWW\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use WWW\UserBundle\Entity\User;
use WWW\ServiceBundle\Entity\Offer;
use WWW\GlobalBundle\Entity\Photo;
use WWW\ServiceBundle\Entity\Valoration;

/**
 * Inscription
 */
class Inscription
{
    /**
     * @var int
     */
    private $id;
    
    /**
     * @var integer
     */
    private $status;

    /**
     * @var \DateTime
     */
    private $createdDate;

    /**
     * @var \DateTime
     */
    private $modifiedDate;

    /**
     * @var \DateTime
     */
    private $deletedDate;

    /**
     * @var boolean
     */
    private $isDeleted;

    /**
     * @var \WWW\UserBundle\Entity\User
     */
    private $user;

    /**
     * @var \WWW\ServiceBundle\Entity\Offer
     */
    private $offer;

    /**
     * @var \WWW\ServiceBundle\Entity\MessengerPrice
     */
    private $messengerPrice;

    /**
     * @var string
     */
    private $dataExtra;

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
     * Set status
     *
     * @param integer $status
     * @return Inscription
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return Inscription
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime 
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set modifiedDate
     *
     * @param \DateTime $modifiedDate
     * @return Inscription
     */
    public function setModifiedDate($modifiedDate)
    {
        $this->modifiedDate = $modifiedDate;

        return $this;
    }

    /**
     * Get modifiedDate
     *
     * @return \DateTime 
     */
    public function getModifiedDate()
    {
        return $this->modifiedDate;
    }

    /**
     * Set deletedDate
     *
     * @param \DateTime $deletedDate
     * @return Inscription
     */
    public function setDeletedDate($deletedDate)
    {
        $this->deletedDate = $deletedDate;

        return $this;
    }

    /**
     * Get deletedDate
     *
     * @return \DateTime 
     */
    public function getDeletedDate()
    {
        return $this->deletedDate;
    }

    /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     * @return Inscription
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * Get isDeleted
     *
     * @return boolean 
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * Set user
     *
     * @param \WWW\UserBundle\Entity\User $user
     * @return Inscription
     */
    public function setUser(\WWW\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \WWW\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set offer
     *
     * @param \WWW\ServiceBundle\Entity\Offer $offer
     * @return Inscription
     */
    public function setOffer(\WWW\ServiceBundle\Entity\Offer $offer = null)
    {
        $this->offer = $offer;

        return $this;
    }

    /**
     * Get offer
     *
     * @return \WWW\ServiceBundle\Entity\Offer 
     */
    public function getOffer()
    {
        return $this->offer;
    }

    /**
     * Set messengerPrice
     *
     * @param \WWW\ServiceBundle\Entity\MessengerPrice $messengerPrice
     * @return Inscription
     */
    public function setMessengerPrice(\WWW\ServiceBundle\Entity\MessengerPrice $messengerPrice = null)
    {
        $this->messengerPrice = $messengerPrice;

        return $this;
    }

    /**
     * Get messengerPrice
     *
     * @return \WWW\ServiceBundle\Entity\MessengerPrice
     */
    public function getMessengerPrice()
    {
        return $this->messengerPrice;
    }

    /**
     * Set dataExtra
     *
     * @param string $dataExtra
     * @return Inscription
     */
    public function setDataExtra($dataExtra)
    {
        $this->dataExtra = $dataExtra;

        return $this;
    }

    /**
     * Get dataExtra
     *
     * @return string 
     */
    public function getDataExtra()
    {
        return $this->dataExtra;
    }
}

<?php

namespace WWW\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wallet
 */
class Wallet
{
    /**
     * @var int
     */
    private $id;


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
     * @var float
     */
    private $quantity;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $concept;

    /**
     * @var boolean
     */
    private $cash;

    /**
     * @var boolean
     */
    private $payment;

    /**
     * @var boolean
     */
    private $consumed;

    /**
     * @var float
     */
    private $quantityConsumed;

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
     * @var \WWW\ServiceBundle\Entity\Service
     */
    private $service;


    /**
     * Set quantity
     *
     * @param float $quantity
     * @return Wallet
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return float 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Wallet
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set concept
     *
     * @param string $concept
     * @return Wallet
     */
    public function setConcept($concept)
    {
        $this->concept = $concept;

        return $this;
    }

    /**
     * Get concept
     *
     * @return string 
     */
    public function getConcept()
    {
        return $this->concept;
    }

    /**
     * Set cash
     *
     * @param boolean $cash
     * @return Wallet
     */
    public function setCash($cash)
    {
        $this->cash = $cash;

        return $this;
    }

    /**
     * Get cash
     *
     * @return boolean 
     */
    public function getCash()
    {
        return $this->cash;
    }

    /**
     * Set payment
     *
     * @param boolean $payment
     * @return Wallet
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     * Get payment
     *
     * @return boolean 
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Set consumed
     *
     * @param boolean $consumed
     * @return Wallet
     */
    public function setConsumed($consumed)
    {
        $this->consumed = $consumed;

        return $this;
    }

    /**
     * Get consumed
     *
     * @return boolean 
     */
    public function getConsumed()
    {
        return $this->consumed;
    }

    /**
     * Set quantityConsumed
     *
     * @param float $quantityConsumed
     * @return Wallet
     */
    public function setQuantityConsumed($quantityConsumed)
    {
        $this->quantityConsumed = $quantityConsumed;

        return $this;
    }

    /**
     * Get quantityConsumed
     *
     * @return float 
     */
    public function getQuantityConsumed()
    {
        return $this->quantityConsumed;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return Wallet
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
     * @return Wallet
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
     * @return Wallet
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
     * @return Wallet
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
     * @return Wallet
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
     * Set service
     *
     * @param \WWW\ServiceBundle\Entity\Service $service
     * @return Wallet
     */
    public function setService(\WWW\ServiceBundle\Entity\Service $service = null)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return \WWW\ServiceBundle\Entity\Service 
     */
    public function getService()
    {
        return $this->service;
    }
    /**
     * Get service
     *
     * @return \WWW\ServiceBundle\Entity\Service 
     */
    public function getServiceName()
    {
        return $this->service->getTitle();
    }
}

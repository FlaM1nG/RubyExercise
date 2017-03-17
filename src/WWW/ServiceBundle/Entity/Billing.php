<?php

namespace WWW\ServiceBundle\Entity;

/**
 * Billing
 */
class Billing
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $reference;

    /**
     * @var \DateTime
     */
    private $date;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set reference
     *
     * @param integer $reference
     *
     * @return Billing
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return int
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Billing
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
     * @var \WWW\UserBundle\Entity\User
     */
    private $user;

    /**
     * @var \WWW\GlobalBundle\Entity\Address
     */
    private $address;


    /**
     * Set user
     *
     * @param \WWW\UserBundle\Entity\User $user
     *
     * @return Billing
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
     * Set address
     *
     * @param \WWW\GlobalBundle\Entity\Address $address
     *
     * @return Billing
     */
    public function setAddress(\WWW\GlobalBundle\Entity\Address $address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return \WWW\GlobalBundle\Entity\Address
     */
    public function getAddress()
    {
        return $this->address;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $concepts;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->concepts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add concept
     *
     * @param \WWW\ServiceBundle\Entity\Concept $concept
     *
     * @return Billing
     */
    public function addConcept(\WWW\ServiceBundle\Entity\Concept $concept)
    {
        $this->concepts[] = $concept;

        return $this;
    }

    /**
     * Remove concept
     *
     * @param \WWW\ServiceBundle\Entity\Concept $concept
     */
    public function removeConcept(\WWW\ServiceBundle\Entity\Concept $concept)
    {
        $this->concepts->removeElement($concept);
    }

    /**
     * Get concepts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getConcepts()
    {
        return $this->concepts;
    }
    /**
     * @var boolean
     */
    private $paid;


    /**
     * Set paid
     *
     * @param boolean $paid
     * @return Billing
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;

        return $this;
    }

    /**
     * Get paid
     *
     * @return boolean 
     */
    public function getPaid()
    {
        return $this->paid;
    }
}

<?php

namespace WWW\ServiceBundle\Entity;

/**
 * Concept
 */
class Concept
{
    /**
     * @var int
     */
    private $id;


    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $iva;

    /**
     * @var int
     */
    private $price;


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
     * Set name
     *
     * @param string $name
     *
     * @return Concept
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set iva
     *
     * @param integer $iva
     *
     * @return Concept
     */
    public function setIva($iva)
    {
        $this->iva = $iva;

        return $this;
    }

    /**
     * Get iva
     *
     * @return int
     */
    public function getIva()
    {
        return $this->iva;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Concept
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }
    /**
     * @var \WWW\ServiceBundle\Entity\Billing
     */
    private $billing;

    /**
     * @var \WWW\ServiceBundle\Entity\Inscription
     */
    private $inscription;


    /**
     * Set billing
     *
     * @param \WWW\ServiceBundle\Entity\Billing $billing
     *
     * @return Concept
     */
    public function setBilling(\WWW\ServiceBundle\Entity\Billing $billing = null)
    {
        $this->billing = $billing;

        return $this;
    }

    /**
     * Get billing
     *
     * @return \WWW\ServiceBundle\Entity\Billing
     */
    public function getBilling()
    {
        return $this->billing;
    }

    /**
     * Set inscription
     *
     * @param \WWW\ServiceBundle\Entity\Inscription $inscription
     *
     * @return Concept
     */
    public function setInscription(\WWW\ServiceBundle\Entity\Inscription $inscription = null)
    {
        $this->inscription = $inscription;

        return $this;
    }

    /**
     * Get inscription
     *
     * @return \WWW\ServiceBundle\Entity\Inscription
     */
    public function getInscription()
    {
        return $this->inscription;
    }
    /**
     * @var boolean
     */
    private $paid;


    /**
     * Set paid
     *
     * @param boolean $paid
     * @return Concept
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
    /**
     * @var string
     */
    private $description;


    /**
     * Set description
     *
     * @param string $description
     * @return Concept
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
     * @var string
     */
    private $reference;


    /**
     * Set reference
     *
     * @param string $reference
     * @return Concept
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string 
     */
    public function getReference()
    {
        return $this->reference;
    }
    /**
     * @var boolean
     */
    private $payment;


    /**
     * Set payment
     *
     * @param boolean $payment
     * @return Concept
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
}

<?php

namespace WWW\CarsBundle\Entity;

use WWW\ServiceBundle\Entity\Offer;

/**
 * ShareCar
 */
class ShareCar
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $fromPlace;

    /**
     * @var string
     */
    private $toPlace;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var int
     */
    private $price;

    /**
     * @var \WWW\CarsBundle\Entity\Car
     */
    private $car;

    /**
     * @var boolean
     */
    private $backTwo;

    /**
     * @var boolean
     */
    private $autobooking;

    /**
     * @var \WWW\ServiceBundle\Entity\Offer
     */
    private $offer;

    public function __construct() {
        $this->offer = new Offer();
    }

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
     * Set fromPlace
     *
     * @param string $fromPlace
     *
     * @return ShareCar
     */
    public function setFromPlace($fromPlace)
    {
        $this->fromPlace = $fromPlace;

        return $this;
    }

    /**
     * Get fromPlace
     *
     * @return string
     */
    public function getFromPlace()
    {
        return $this->fromPlace;
    }

    /**
     * Set toPlace
     *
     * @param string $toPlace
     *
     * @return ShareCar
     */
    public function setToPlace($toPlace)
    {
        $this->toPlace = $toPlace;

        return $this;
    }

    /**
     * Get toPlace
     *
     * @return string
     */
    public function getToPlace()
    {
        return $this->toPlace;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return ShareCar
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
     * Set price
     *
     * @param integer $price
     *
     * @return ShareCar
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
     * Set car
     *
     * @param \WWW\CarsBundle\Entity\Car $car
     *
     * @return ShareCar
     */
    public function setCar(\WWW\CarsBundle\Entity\Car $car = null)
    {
        $this->car = $car;

        return $this;
    }

    /**
     * Get car
     *
     * @return \WWW\CarsBundle\Entity\Car
     */
    public function getCar()
    {
        return $this->car;
    }

    /**
     * Set backTwo
     *
     * @param boolean $backTwo
     *
     * @return ShareCar
     */
    public function setBackTwo($backTwo)
    {
        $this->backTwo = $backTwo;

        return $this;
    }

    /**
     * Get backTwo
     *
     * @return boolean
     */
    public function getBackTwo()
    {
        return $this->backTwo;
    }

    /**
     * Set autobooking
     *
     * @param boolean $autobooking
     *
     * @return ShareCar
     */
    public function setAutobooking($autobooking)
    {
        $this->autobooking = $autobooking;

        return $this;
    }

    /**
     * Get autobooking
     *
     * @return boolean
     */
    public function getAutobooking()
    {
        return $this->autobooking;
    }

    /**
     * Set offer
     *
     * @param \WWW\ServiceBundle\Entity\Offer $offer
     *
     * @return ShareCar
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
}

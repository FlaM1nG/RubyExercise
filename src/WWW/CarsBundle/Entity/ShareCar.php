<?php

namespace WWW\CarsBundle\Entity;

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
}


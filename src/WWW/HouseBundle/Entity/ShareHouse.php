<?php

namespace WWW\HouseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use WWW\ServiceBundle\Entity\Offer;

/**
 * ShareHouse
 */
class ShareHouse
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var bool
     */
    private $autobooking;

    /**
     * @var \WWW\ServiceBundle\Entity\Offer
     */
    private $offer;

    /**
     * @var \WWW\HouseBundle\Entity\House
     */
    private $house;

    /**
     * @var float
     */
    private $price;

    public function __construct($arrayData = null) {
//        $this->house = new House();

        if(gettype($arrayData)== 'array' AND !empty($arrayData)):
            if(array_key_exists('house', $arrayData)):
                $this->house = new House($arrayData['house']);
            else:
                $this->house = new House();
                $this->house->setId($arrayData['house_id']);
            endif;
            $this->price = $arrayData['price'];
            $this->offer = new Offer($arrayData);
        endif;

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
     * Set autobooking
     *
     * @param boolean $autobooking
     * @return ShareHouse
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
     * @return ShareHouse
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
     * Set house
     *
     * @param \WWW\HouseBundle\Entity\House $house
     * @return ShareHouse
     */
    public function setHouse(\WWW\HouseBundle\Entity\House $house = null)
    {
        $this->house = $house;

        return $this;
    }

    /**
     * Get house
     *
     * @return \WWW\HouseBundle\Entity\House 
     */
    public function getHouse()
    {
        return $this->house;
    }
    

    /**
     * Set price
     *
     * @param float $price
     * @return ShareHouse
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }
}

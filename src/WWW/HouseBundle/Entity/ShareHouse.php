<?php

namespace WWW\HouseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var \WWW\ServiceBundle\Entity\Offer
     */
    private $offer;

    /**
     * @var \WWW\HouseBundle\Entity\House
     */
    private $house;


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
}

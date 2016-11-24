<?php

namespace WWW\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trade
 */
class Trade
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
    private $priceUser;

    /**
     * @var float
     */
    private $priceTotal;

    /**
     * @var string
     */
    private $dimensions;

    /**
     * @var float
     */
    private $weight;

    /**
     * @var \WWW\ServiceBundle\Entity\Offer
     */
    private $offer;

    /**
     * @var \WWW\ServiceBundle\Entity\TradeCategory
     */
    private $category;


    /**
     * Set priceUser
     *
     * @param float $priceUser
     * @return Trade
     */
    public function setPriceUser($priceUser)
    {
        $this->priceUser = $priceUser;

        return $this;
    }

    /**
     * Get priceUser
     *
     * @return float 
     */
    public function getPriceUser()
    {
        return $this->priceUser;
    }

    /**
     * Set priceTotal
     *
     * @param float $priceTotal
     * @return Trade
     */
    public function setPriceTotal($priceTotal)
    {
        $this->priceTotal = $priceTotal;

        return $this;
    }

    /**
     * Get priceTotal
     *
     * @return float 
     */
    public function getPriceTotal()
    {
        return $this->priceTotal;
    }

    /**
     * Set dimensions
     *
     * @param string $dimensions
     * @return Trade
     */
    public function setDimensions($dimensions)
    {
        $this->dimensions = $dimensions;

        return $this;
    }

    /**
     * Get dimensions
     *
     * @return string 
     */
    public function getDimensions()
    {
        return $this->dimensions;
    }

    /**
     * Set weight
     *
     * @param float $weight
     * @return Trade
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return float 
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set offer
     *
     * @param \WWW\ServiceBundle\Entity\Offer $offer
     * @return Trade
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
     * Set category
     *
     * @param \WWW\ServiceBundle\Entity\TradeCategory $category
     * @return Trade
     */
    public function setCategory(\WWW\ServiceBundle\Entity\TradeCategory $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \WWW\ServiceBundle\Entity\TradeCategory 
     */
    public function getCategory()
    {
        return $this->category;
    }
}

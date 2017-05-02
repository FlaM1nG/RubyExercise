<?php

namespace WWW\OthersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use WWW\GlobalBundle\Entity\Address;
use \WWW\ServiceBundle\Entity\Offer;
use Doctrine\Common\Util\Inflector as Inflector;

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
     * @var float
     * @Assert\NotBlank()
     */
    private $price;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $dimensions;

    /**
     * @var float
     * @Assert\NotBlank()
     */
    private $weight;

    /**
     * @var float
     */
    private $longitude;

    /**
     * @var float
     */
    private $latitude;

    /**
     * @var \WWW\ServiceBundle\Entity\Offer
     * 
     */
    private $offer;

    /**
     * @var \WWW\OthersBundle\Entity\TradeCategory
     */
    private $category;       
        
    /**
     * @var string
     */
    private $region;

    /**
     * @var \WWW\GlobalBundle\Entity\Address
     */
    private $address;
    
    public function __construct($arrayData = null) {

        if(!empty($arrayData)):
            foreach($arrayData as $key => $value):
                if($key != 'address'):
                    $key = Inflector::camelize($key);

                    if(property_exists('WWW\OthersBundle\Entity\Trade',$key) && !empty($value) ):
                        $this->$key = $value;

                    endif;
                endif;
            endforeach;

            $this->offer = new Offer($arrayData);

            if(key_exists('category_id', $arrayData)):
                $this->category = new TradeCategory(null,$arrayData['category_id']);
                if( key_exists('category', $arrayData)):
                    $this->category->setName($arrayData['category']);
                endif;
            endif;

            if(key_exists('address', $arrayData)):
                $address = new Address($arrayData['address']);
                $this->address = $address;
            endif;
        else:
            $this->category = new TradeCategory();
            $this->offer = new Offer();
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
     * Set price
     *
     * @param float $price
     * @return Trade
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
     * Set longitude
     *
     * @param float $longitude
     * @return Trade
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     * @return Trade
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set offer
     *
     * @param \WWW\ServiceBundle\Entity\Offer $offer
     * @return Trade
     */
    public function setOffer( $offer = null){
        if(gettype($offer) == 'array'):
            
            $newOffer = new Offer($offer);
            $this->offer = $newOffer;
            
        else:
            $this->offer = $offer;
        endif;

        return $this;
    }


    /**
     * Get offer
     *
     * @return \WWW\ServiceBundle\Entity\Offer 
     */
    public function getOffer(){ 
        return $this->offer;
    }

    /**
     * Set category
     *
     * @param \WWW\OthersBundle\Entity\TradeCategory $category
     * @return Trade
     */
    public function setCategory(\WWW\OthersBundle\Entity\TradeCategory $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \WWW\OthersBundle\Entity\TradeCategory 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set region
     *
     * @param string $region
     * @return Trade
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string 
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set address
     *
     * @param \WWW\GlobalBundle\Entity\Address $address
     * @return Trade
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
}

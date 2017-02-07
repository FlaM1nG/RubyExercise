<?php

namespace WWW\OthersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Util\Inflector as Inflector;

/**
 * TradeCategory
 */
class TradeCategory
{
    /**
     * @var int
     */
    private $id;

   

    
    public function __construct($arrayData = null,$id = null) {
        
        if(!empty($arrayData)):
            $this->id = (int)$arrayData['id'];
            $this->name = $arrayData['name'];
            $this->description = $arrayData['description'];
            $this->deleted = (bool)$arrayData['deleted'];
        elseif(!empty($id)):
            $this->id = $id;
        endif;    
    }
    
    
    
    public function cast(TradeCategory $object){
        return $object;
    }
    
    
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var boolean
     */
    private $deleted;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $trades;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function setId($id){

        $this->id = $id;
        
    }
    /**
     * Set name
     *
     * @param string $name
     *
     * @return TradeCategory
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
     * Set description
     *
     * @param string $description
     *
     * @return TradeCategory
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
     * Set deleted
     *
     * @param boolean $deleted
     *
     * @return TradeCategory
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Add trade
     *
     * @param \WWW\OthersBundle\Entity\Trade $trade
     *
     * @return TradeCategory
     */
    public function addTrade(\WWW\OthersBundle\Entity\Trade $trade)
    {
        $this->trades[] = $trade;

        return $this;
    }

    /**
     * Remove trade
     *
     * @param \WWW\OthersBundle\Entity\Trade $trade
     */
    public function removeTrade(\WWW\OthersBundle\Entity\Trade $trade)
    {
        $this->trades->removeElement($trade);
    }

    /**
     * Get trades
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTrades()
    {
        return $this->trades;
    }

    /**
     * @var \WWW\ServiceBundle\Entity\Service
     */
    private $service;


    /**
     * Set service
     *
     * @param \WWW\ServiceBundle\Entity\Service $service
     *
     * @return TradeCategory
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
}

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
    
    private $trades;

    
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
     * Set name
     *
     * @param string $name
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
    
    public function cast(TradeCategory $object){
        return $object;
    }
    
    
}

<?php

namespace WWW\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MessengerPrice
 */
class MessengerPrice
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var float
     */
    private $weightMin;

    /**
     * @var float
     */
    private $weightMax;

    /**
     * @var float
     */
    private $width;

    /**
     * @var float
     */
    private $height;

    /**
     * @var float
     */
    private $depth;

    /**
     * @var float
     */
    private $priceES;

    /**
     * @var float
     */
    private $priceBA;

    /**
     * @var float
     */
    private $priceCA;

    /**
     * @var boolean
     */
    private $isDeleted;

    /**
     * @var \DateTime
     */
    private $createdDate;

    /**
     * @var \DateTime
     */
    private $modifiedDate;

    /**
     * @var \DateTime
     */
    private $deletedDate;

    /**
     * @var \WWW\ServiceBundle\Entity\MessengerService
     */
    private $messengerService;

    /**
     * @var string
     *
     */
    private $intervalWeightPrice;
    
    public function __construct($data = null) {
        $this->messengerService = new MessengerService();

        if(!empty($data)):
            $this->id = $data['id'];
            $this->weightMin = $data['weight_min'];
            $this->weightMax = $data['weight_max'];
            $this->depth = $data['depth'];
            $this->height = $data['height'];
            $this->width = $data['width'];
            $this->messengerService->setId($data['id_MessengerService']);

            if(array_key_exists('price_ba',$data))
                $this->priceBA = $data['price_ba'];

            if(array_key_exists('price_ca',$data))
                $this->priceCA = $data['price_ca'];

            if(array_key_exists('price_es',$data))
                $this->priceES = $data['price_es'];

            if($this->weightMin == 0):
                $this->intervalWeightPrice = "Hasta ".$this->weightMax."kg"."       ".$this->priceES." €";
            else:
                $this->intervalWeightPrice = "Más de ".$this->weightMin."kg hasta   ".$this->weightMax."kg"." ".$this->priceES."€";
            endif;

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
     * Set weightMin
     *
     * @param float $weightMin
     * @return MessengerPrice
     */
    public function setWeightMin($weightMin)
    {
        $this->weightMin = $weightMin;

        return $this;
    }

    /**
     * Get weightMin
     *
     * @return float 
     */
    public function getWeightMin()
    {
        return $this->weightMin;
    }

    /**
     * Set weightMax
     *
     * @param float $weightMax
     * @return MessengerPrice
     */
    public function setWeightMax($weightMax)
    {
        $this->weightMax = $weightMax;

        return $this;
    }

    /**
     * Get weightMax
     *
     * @return float 
     */
    public function getWeightMax()
    {
        return $this->weightMax;
    }

    /**
     * Set width
     *
     * @param float $width
     * @return MessengerPrice
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return float 
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param float $height
     * @return MessengerPrice
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return float 
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set depth
     *
     * @param float $depth
     * @return MessengerPrice
     */
    public function setDepth($depth)
    {
        $this->depth = $depth;

        return $this;
    }

    /**
     * Get depth
     *
     * @return float 
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * Set priceES
     *
     * @param float $priceES
     * @return MessengerPrice
     */
    public function setPriceES($priceES)
    {
        $this->priceES = $priceES;

        return $this;
    }

    /**
     * Get priceES
     *
     * @return float 
     */
    public function getPriceES()
    {
        return $this->priceES;
    }

    /**
     * Set priceBA
     *
     * @param float $priceBA
     * @return MessengerPrice
     */
    public function setPriceBA($priceBA)
    {
        $this->priceBA = $priceBA;

        return $this;
    }

    /**
     * Get priceBA
     *
     * @return float 
     */
    public function getPriceBA()
    {
        return $this->priceBA;
    }

    /**
     * Set priceCA
     *
     * @param float $priceCA
     * @return MessengerPrice
     */
    public function setPriceCA($priceCA)
    {
        $this->priceCA = $priceCA;

        return $this;
    }

    /**
     * Get priceCA
     *
     * @return float 
     */
    public function getPriceCA()
    {
        return $this->priceCA;
    }

    /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     * @return MessengerPrice
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * Get isDeleted
     *
     * @return boolean 
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return MessengerPrice
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime 
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set modifiedDate
     *
     * @param \DateTime $modifiedDate
     * @return MessengerPrice
     */
    public function setModifiedDate($modifiedDate)
    {
        $this->modifiedDate = $modifiedDate;

        return $this;
    }

    /**
     * Get modifiedDate
     *
     * @return \DateTime 
     */
    public function getModifiedDate()
    {
        return $this->modifiedDate;
    }

    /**
     * Set deletedDate
     *
     * @param \DateTime $deletedDate
     * @return MessengerPrice
     */
    public function setDeletedDate($deletedDate)
    {
        $this->deletedDate = $deletedDate;

        return $this;
    }

    /**
     * Get deletedDate
     *
     * @return \DateTime 
     */
    public function getDeletedDate()
    {
        return $this->deletedDate;
    }

    /**
     * Set messengerService
     *
     * @param \WWW\ServiceBundle\Entity\MessengerService $messengerService
     * @return MessengerPrice
     */
    public function setMessengerService(\WWW\ServiceBundle\Entity\MessengerService $messengerService = null)
    {
        $this->messengerService = $messengerService;

        return $this;
    }

    /**
     * Get messengerService
     *
     * @return \WWW\ServiceBundle\Entity\MessengerService 
     */
    public function getMessengerService()
    {
        return $this->messengerService;
    }

    public function getIntervalWeightPrice(){
        return $this->intervalWeightPrice;
    }
}

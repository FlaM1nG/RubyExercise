<?php

namespace WWW\GlobalBundle\Entity;


use Doctrine\Common\Util\Inflector as Inflector;

/**
 * Photo
 */
class Photo
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $url;
        
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
     * @var boolean
     */
    private $isDeleted;

    public function __construct($data=null) {
        
        if(!empty($data)):
        
            foreach ($data as $key => $value):
                $key = Inflector::camelize($key);
        
                if( property_exists('WWW\GlobalBundle\Entity\Photo',$key) ){
                        $this->$key = $value;
                }
            endforeach;
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

    public function setId($id){
        $this->id = $id;
    }
    /**
     * Set url
     *
     * @param string $url
     * @return Photo
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }
    
    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return Photo
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
     * @return Photo
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
     * @return Photo
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
     * Set isDeleted
     *
     * @param boolean $isDeleted
     * @return Photo
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
}

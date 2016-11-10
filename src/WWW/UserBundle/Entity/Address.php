<?php

namespace WWW\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Address
 */
class Address 
{
    /**
     * @var int
     */
    private $id;    
    /**
     * @var string
     */
    private $street;

    /**
     * @var string
     */
    private $name;

    /**
     * @var boolean
     */
    private $isDefault;

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

    /**
     * @var \WWW\UserBundle\Entity\User
     */
    private $user;


     public function __construct(Array $address=null){
         
        if($address != null):
             
            $this->id = $address['id'];
            $this->street = $address['street'];
            $this->name = $address['name'];
            $this->isDefault = $address['is_default'];
            $this->createdDate = $address['created_date'];
            $this->modifiedDate = $address['modified_date'];
            $this->deletedDate = $address['deleted_date'];
            $this->isDeleted = $address['is_deleted'];
            //S$this->user = $address['user'];
            //$this->cp = $address['cp'];
             
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
     * Set street
     *
     * @param string $street
     * @return Address
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string 
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Address
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
     * Set isDefault
     *
     * @param boolean $isDefault
     * @return Address
     */
    public function setIsDefault($isDefault)
    {
        $this->isDefault = $isDefault;

        return $this;
    }

    /**
     * Get isDefault
     *
     * @return boolean 
     */
    public function getIsDefault()
    {
        return $this->isDefault;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return Address
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
     * @return Address
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
     * @return Address
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
     * @return Address
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
     * Set user
     *
     * @param \WWW\UserBundle\Entity\User $user
     * @return Address
     */
    public function setUser(\WWW\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \WWW\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @var \WWW\UserBundle\Entity\ZipCode
     */
    private $zipcode;


    /**
     * Set zipcode
     *
     * @param \WWW\UserBundle\Entity\ZipCode $zipcode
     * @return Address
     */
    public function setZipcode(\WWW\UserBundle\Entity\ZipCode $zipcode = null)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Get zipcode
     *
     * @return \WWW\UserBundle\Entity\ZipCode 
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }
    
     public function toArray(){
        return array(
            'id' => $this->getId(),
            'street' => $this->getStreet(),
            'name' => $this->getName(),
            'isDefault' =>(Boolean) $this->getIsDefault(),
            'createdDate' => $this->getCreatedDate(),
            'modifiedDate' => $this->getModifiedDate(),
            'deletedDate' => $this->getDeletedDate(),
            'isDeleted' => $this->getIsDeleted(),
            'cp' => $this->getCp()
        );
    }
}

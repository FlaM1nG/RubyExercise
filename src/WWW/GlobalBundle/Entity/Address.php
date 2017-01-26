<?php

namespace WWW\GlobalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Util\Inflector as Inflector;
use Symfony\Component\Validator\GroupSequenceProviderInterface;

/**
 * Address
 */
class Address implements GroupSequenceProviderInterface, \Serializable {
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank(groups={"address"})
     */
    private $street;
    /**
     * @var string
     * @Assert\NotBlank(groups={"address"})
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
    
    /**
     * @var integer
     * @Assert\NotBlank(groups={"address"})
     */
    private $zipCode;

    /**
     * @var string
     * @Assert\NotBlank(groups={"address"})
     */
    private $city;

    /**
     * @var string
     * @Assert\NotBlank(groups={"address"})
     */
    
    private $region;

    /**
     * @var string
     * @Assert\NotBlank(groups={"address"})
     */
    private $country;
    


    /**
     * @var string
     */
    private $prefix;

    /**
     * @var integer
     */
    private $phone;

    public function __construct(Array $address=null){
       
        if($address != null):
            foreach($address as $key => $value):
                $keyCamelize = Inflector::camelize($key);
               
                if(property_exists("WWW\GlobalBundle\Entity\Address", $keyCamelize) && !empty($value)):
                    $this->$keyCamelize = $value;
                endif;  
            endforeach;
//        else:
//            $this->id = 0;
//            $this->street = "";
//            $this->name = "";
//            $this->isDefault = "";
//            $this->createdDate = "";
//            $this->modifiedDate = "";
//            $this->deletedDate = "";
//            $this->isDeleted = "";
        endif;

    }
    
    public function setId($id){
        $this->id = $id;
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
    
    public function toArray(){
        
        return Array(
            'id' => $this->getId(),
            'street' =>$this->getStreet(),
            'name' => $this->getName(),
            'isDefault' => (boolean)$this->getIsDefault(),
            'createdDate' => $this->getCreatedDate(),
            'modifiedDate' => $this->getModifiedDate(),
            'deletedDate' => $this->getDeletedDate(),
            'isDeleted' => $this->getIsDeleted(),
        );    
    }

    /**
     * Set zipCode
     *
     * @param integer $zipCode
     * @return Address
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get zipCode
     *
     * @return integer 
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Address
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set region
     *
     * @param string $region
     * @return Address
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
     * Set country
     *
     * @param string $country
     * @return Address
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }


    /**
     * Set phone
     *
     * @param integer $phone
     * @return Address
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return integer 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set prefix
     *
     * @param string $prefix
     * @return Address
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Get prefix
     *
     * @return string 
     */
    public function getPrefix()
    {
        return $this->prefix;
    }
    
    /*
     * @return Array de grupos
     */
    public function getGroupSequence()
    {
        $groups = array('Address');

        if ($this->isAddress()) {
            
            $groups[] = 'Address';
            
        }

        return $groups;
    }

     /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->user->getId()
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->userId    
        ) = unserialize($serialized);
    }
}

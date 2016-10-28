<?php

namespace WWW\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adress
 */
class Adress
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $calle;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var bool
     */
    private $defecto;


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
     * Set calle
     *
     * @param string $calle
     * @return Direccion
     */
    public function setCalle($calle)
    {
        $this->calle = $calle;

        return $this;
    }

    /**
     * Get calle
     *
     * @return string 
     */
    public function getCalle()
    {
        return $this->calle;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Direccion
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set defecto
     *
     * @param boolean $defecto
     * @return Direccion
     */
    public function setDefecto($defecto)
    {
        $this->defecto = $defecto;

        return $this;
    }

    /**
     * Get defecto
     *
     * @return boolean 
     */
    public function getDefecto()
    {
        return $this->defecto;
    }
    /**
     * @var \WWW\UserBundle\Entity\User
     */
    private $id_user;

    /**
     * @var \WWW\UserBundle\Entity\CodigoPostal
     */
    private $id_cp;


    /**
     * Set id_user
     *
     * @param \WWW\UserBundle\Entity\User $idUser
     * @return Direccion
     */
    public function setIdUser(\WWW\UserBundle\Entity\User $idUser = null)
    {
        $this->id_user = $idUser;

        return $this;
    }

    /**
     * Get id_user
     *
     * @return \WWW\UserBundle\Entity\User 
     */
    public function getIdUser()
    {
        return $this->id_user;
    }

    /**
     * Set id_cp
     *
     * @param \WWW\UserBundle\Entity\CodigoPostal $idCp
     * @return Direccion
     */
    public function setIdCp(\WWW\UserBundle\Entity\CodigoPostal $idCp = null)
    {
        $this->id_cp = $idCp;

        return $this;
    }

    /**
     * Get id_cp
     *
     * @return \WWW\UserBundle\Entity\CodigoPostal 
     */
    public function getIdCp()
    {
        return $this->id_cp;
    }
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
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return Direccion
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
     * @return Direccion
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
     * @return Direccion
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
     * @return Direccion
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
     * @var \WWW\UserBundle\Entity\User
     */
    private $user;

    /**
     * @var \WWW\UserBundle\Entity\ZipCode
     */
    private $cp;


    /**
     * Set street
     *
     * @param string $street
     * @return Adress
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
     * @return Adress
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
     * @return Adress
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
     * Set user
     *
     * @param \WWW\UserBundle\Entity\User $user
     * @return Adress
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
     * Set cp
     *
     * @param \WWW\UserBundle\Entity\ZipCode $cp
     * @return Adress
     */
    public function setCp(\WWW\UserBundle\Entity\ZipCode $cp = null)
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * Get cp
     *
     * @return \WWW\UserBundle\Entity\ZipCode 
     */
    public function getCp()
    {
        return $this->cp;
    }
}

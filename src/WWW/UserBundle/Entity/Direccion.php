<?php

namespace WWW\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Direccion
 */
class Direccion
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
}

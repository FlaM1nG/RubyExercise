<?php

namespace WWW\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="www_direccion")
 */
class Direccion
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, columnDefinition="VARCHAR(255)")
     */
    protected $calle;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true, columnDefinition="VARCHAR(255)")
     */
    protected $nombre;
    
    /**
     * @ORM\Column(type="boolean", length=1, nullable=true)
     */
    protected $default;
        
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="direccion")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
    
    /**
     * @ORM\ManyToOne(targetEntity="CodigoPostal", inversedBy="direccion")
     * @ORM\JoinColumn(name="cp", referencedColumnName="cp")
     */
    protected $cp;


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
     * Set id
     *
     * @param integer $id
     * @return Direccion
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set user
     *
     * @param \WWW\UserBundle\Entity\User $user
     * @return Direccion
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
     * @param \WWW\UserBundle\Entity\CodigoPostal $cp
     * @return Direccion
     */
    public function setCp(\WWW\UserBundle\Entity\CodigoPostal $cp = null)
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * Get cp
     *
     * @return \WWW\UserBundle\Entity\CodigoPostal 
     */
    public function getCp()
    {
        return $this->cp;
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
     * Set default
     *
     * @param boolean $default
     * @return Direccion
     */
    public function setDefault($default)
    {
        $this->default = $default;

        return $this;
    }

    /**
     * Get default
     *
     * @return boolean 
     */
    public function getDefault()
    {
        return $this->default;
    }
}

<?php

namespace WWW\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="www_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=100, columnDefinition="VARCHAR(100)")
     */
    private $nombre;
    
    /**
     * @ORM\Column(type="string", length=255, columnDefinition="VARCHAR(255)")
     */
    private $apellidos;
    
    /**
     * @ORM\Column(type="string", length=1, columnDefinition="CHAR(1)")
     */
    private $sexo;
    
    /**
     * @ORM\Column(type="date", name="fecha_nacimiento")
     */
    private $fechaNacimiento;
    
    /**
     * @ORM\Column(type="string", name="link_invitacion", length=255, columnDefinition="VARCHAR(255)")
     */
    private $linkInvitacion;
    
    /**
     * @ORM\Column(type="integer", options={"default":NULL})
     */
    private $anfitrion;
    
    /**
     * @ORM\Column(type="integer", options={"default":0})
     */
    private $invitados;
    
    /**
     * @ORM\Column(type="string", length=10, columnDefinition="VARCHAR(10)")
     */
    private $cp;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $avisoLegal;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return User
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
     * Set apellidos
     *
     * @param string $apellidos
     * @return User
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string 
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set sexo
     *
     * @param string $sexo
     * @return User
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;

        return $this;
    }

    /**
     * Get sexo
     *
     * @return string 
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * Set fechaNacimiento
     *
     * @param \DateTime $fechaNacimiento
     * @return User
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    /**
     * Get fechaNacimiento
     *
     * @return \DateTime 
     */
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    /**
     * Set linkInvitacion
     *
     * @param string $linkInvitacion
     * @return User
     */
    public function setLinkInvitacion($linkInvitacion)
    {
        $this->linkInvitacion = $linkInvitacion;

        return $this;
    }

    /**
     * Get linkInvitacion
     *
     * @return string 
     */
    public function getLinkInvitacion()
    {
        return $this->linkInvitacion;
    }

    /**
     * Set anfitrion
     *
     * @param integer $anfitrion
     * @return User
     */
    public function setAnfitrion($anfitrion)
    {
        $this->anfitrion = $anfitrion;

        return $this;
    }

    /**
     * Get anfitrion
     *
     * @return integer 
     */
    public function getAnfitrion()
    {
        return $this->anfitrion;
    }

    /**
     * Set invitados
     *
     * @param integer $invitados
     * @return User
     */
    public function setInvitados($invitados)
    {
        $this->invitados = $invitados;

        return $this;
    }

    /**
     * Get invitados
     *
     * @return integer 
     */
    public function getInvitados()
    {
        return $this->invitados;
    }

    /**
     * Set cp
     *
     * @param string $cp
     * @return User
     */
    public function setCp($cp)
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * Get cp
     *
     * @return string 
     */
    public function getCp()
    {
        return $this->cp;
    }
    
    public function getAvisoLegal(){
        return $this->avisoLegal;
    }
}


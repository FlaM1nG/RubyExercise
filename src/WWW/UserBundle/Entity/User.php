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
     * @ORM\Column(type="string", length=255, nullable=true, columnDefinition="VARCHAR(255)")
     */
    private $apellidos;
    
    /**
     * @ORM\Column(type="string", length=1, nullable=true, columnDefinition="CHAR(1)")
     */
    private $sexo;
    
    /**
     * @ORM\Column(type="date", nullable=true, name="fecha_nacimiento", options={"default":NULL})
     */
    private $fechaNacimiento;
    
    /**
     * @ORM\Column(type="string", name="link_invitacion", nullable=true, length=255, columnDefinition="VARCHAR(255)")
     */
    private $linkInvitacion;
    
    /**
     * @ORM\Column(type="integer", nullable=true,options={"default":NULL})
     */
    private $anfitrion;
    
    /**
     * @ORM\Column(type="integer", nullable=true, options={"default":0})
     */
    private $invitados;
    
    /**
     * @ORM\Column(type="string", nullable=true, length=255)
     */
    protected $avisoLegal;
    
    /**
     *  @ORM\Column(type="integer", nullable=true, length=20)
     */
    protected $tlfn;
    
    
    /**
     * @ORM\OneToMany(targetEntity="Direccion", mappedBy="user")
     */
    protected $direcciones;
    
    
    public function __construct()
    {
        parent::__construct();
        // your own logic
        $this->roles = array('ROLE_USER');
        $this->features = new ArrayCollection();
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
     * Set avisoLegal
     *
     * @param int $avisoLegal
     */
    public function setAvisoLegal($avisoLegal){
        
        $this->avisoLegal = $avisoLegal;
        return $this;
        
    }
    
    /**
     * Get avisoLegal
     *
     * @return int
     */
    public function getAvisoLegal(){
        return $this->avisoLegal;
    }
    
    /**
     * Get tlfn
     * @return int
     */
    
    public function getTlfn(){
        return $this->tlfn;
    }
    
    /**
     * Set tlfn
     * 
     * @param int
     */
    
    public function setTlfn($tlfn){
        $this->tlfn = $tlfn;
        return $this->tlfn;
    }
    

    /**
     * Add direcciones
     *
     * @param \WWW\UserBundle\Entity\CodigoPostal $direcciones
     * @return User
     */
    public function addDireccione(\WWW\UserBundle\Entity\CodigoPostal $direcciones)
    {
        $this->direcciones[] = $direcciones;

        return $this;
    }

    /**
     * Remove direcciones
     *
     * @param \WWW\UserBundle\Entity\CodigoPostal $direcciones
     */
    public function removeDireccione(\WWW\UserBundle\Entity\CodigoPostal $direcciones)
    {
        $this->direcciones->removeElement($direcciones);
    }

    /**
     * Get direcciones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDirecciones()
    {
        return $this->direcciones;
    }
}

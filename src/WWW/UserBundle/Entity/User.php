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
     * @ORM\Column(type="date", name = "fecha_nacimiento")
     */
    private $fechaNacimiento;
    
    /**
     * @ORM\Column(type="string", length=255, columnDefinition="VARCHAR(255)")
     */
    private $linkInvitacion;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $anfitrion;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $invitados;
    
    /**
     * @ORM\Column(type="string", length=10, columnDefinition="VARCHAR(10))
     */
    private $cp;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
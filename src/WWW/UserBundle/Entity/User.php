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
     * @ORM\AvisoLegal
     * @ORM\Column(type="string", length=255)
     */
    protected $avisoLegal;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
    
    public function getAvisoLegal(){
        return $this->avisoLegal;
    }
   
}
<?php

namespace WWW\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="www_cp")
 */
class CodigoPostal
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $cp;
    
    /**
     * @ORM\Column(type="string", length=40, columnDefinition="VARCHAR(40)")
     */
    private $ciudad;
    
    /**
     * @ORM\Column(type="string", length=40, columnDefinition="VARCHAR(40)")
     */
    private $provincia;
    
    /**
     * @ORM\Column(type="string", length=40, columnDefinition="VARCHAR(40)")
     */
    private $pais;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}

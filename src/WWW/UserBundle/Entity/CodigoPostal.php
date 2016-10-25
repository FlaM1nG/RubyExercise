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
    /**
     * @var integer
     */
    private $id;



    /**
     * Get cp
     *
     * @return integer 
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * Set ciudad
     *
     * @param string $ciudad
     * @return CodigoPostal
     */
    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Get ciudad
     *
     * @return string 
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * Set provincia
     *
     * @param string $provincia
     * @return CodigoPostal
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return string 
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Set pais
     *
     * @param string $pais
     * @return CodigoPostal
     */
    public function setPais($pais)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get pais
     *
     * @return string 
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Set cp
     *
     * @param integer $cp
     * @return CodigoPostal
     */
    public function setCp($cp)
    {
        $this->cp = $cp;

        return $this;
    }
}

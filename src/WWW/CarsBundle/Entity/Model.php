<?php

namespace WWW\CarsBundle\Entity;

use WWW\CarsBundle\Entity\Brand;

/**
 * Model
 */
class Model
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var \WWW\CarsBundle\Entity\Brand
     */
    private $brand;


    public function __construct($id = null, $name = null, $idBrand = null, $brand = null){
        $this->id = $id;
        $this->name = $name;
        $this->brand = new Brand($idBrand, $brand);
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Model
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
     * Set slug
     *
     * @param string $slug
     *
     * @return Model
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set brand
     *
     * @param \WWW\CarsBundle\Entity\Brand $brand
     *
     * @return Model
     */
    public function setBrand(\WWW\CarsBundle\Entity\Brand $brand = null)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return \WWW\CarsBundle\Entity\Brand
     */
    public function getBrand()
    {
        return $this->brand;
    }
}

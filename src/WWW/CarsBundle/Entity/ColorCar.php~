<?php

namespace WWW\CarsBundle\Entity;

/**
 * ColorCar
 */
class ColorCar
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $color;


    public function __construct($color = null){ 
        $this->color = $color;
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
     * Set color
     *
     * @param string $color
     *
     * @return ColorCar
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->color;
    }
}

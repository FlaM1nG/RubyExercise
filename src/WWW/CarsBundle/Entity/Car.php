<?php

namespace WWW\CarsBundle\Entity;

/**
 * Car
 */
class Car
{
    /**
     * @var int
     */
    private $id;

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
     * @var string
     */
    private $plate;

    /**
     * @var string
     */
    private $color;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \DateTime
     */
    private $enrollmentDate;

    /**
     * @var string
     */
    private $kilometers;

    /**
     * @var string
     */
    private $carInsurance;

    /**
     * @var boolean
     */
    private $smoke;

    /**
     * @var boolean
     */
    private $animals;

    /**
     * @var boolean
     */
    private $music;

    /**
     * @var boolean
     */
    private $talk;

    /**
     * @var float
     */
    private $maxWidth;

    /**
     * @var float
     */
    private $maxHeight;

    /**
     * @var float
     */
    private $maxDepth;

    /**
     * @var float
     */
    private $maxWeight;

    /**
     * @var \WWW\UserBundle\Entity\User
     */
    private $user;


    /**
     * Set plate
     *
     * @param string $plate
     *
     * @return Car
     */
    public function setPlate($plate)
    {
        $this->plate = $plate;

        return $this;
    }

    /**
     * Get plate
     *
     * @return string
     */
    public function getPlate()
    {
        return $this->plate;
    }

    /**
     * Set color
     *
     * @param string $color
     *
     * @return Car
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

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Car
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set enrollmentDate
     *
     * @param \DateTime $enrollmentDate
     *
     * @return Car
     */
    public function setEnrollmentDate($enrollmentDate)
    {
        $this->enrollmentDate = $enrollmentDate;

        return $this;
    }

    /**
     * Get enrollmentDate
     *
     * @return \DateTime
     */
    public function getEnrollmentDate()
    {
        return $this->enrollmentDate;
    }

    /**
     * Set kilometers
     *
     * @param string $kilometers
     *
     * @return Car
     */
    public function setKilometers($kilometers)
    {
        $this->kilometers = $kilometers;

        return $this;
    }

    /**
     * Get kilometers
     *
     * @return string
     */
    public function getKilometers()
    {
        return $this->kilometers;
    }

    /**
     * Set carInsurance
     *
     * @param string $carInsurance
     *
     * @return Car
     */
    public function setCarInsurance($carInsurance)
    {
        $this->carInsurance = $carInsurance;

        return $this;
    }

    /**
     * Get carInsurance
     *
     * @return string
     */
    public function getCarInsurance()
    {
        return $this->carInsurance;
    }

    /**
     * Set smoke
     *
     * @param boolean $smoke
     *
     * @return Car
     */
    public function setSmoke($smoke)
    {
        $this->smoke = $smoke;

        return $this;
    }

    /**
     * Get smoke
     *
     * @return boolean
     */
    public function getSmoke()
    {
        return $this->smoke;
    }

    /**
     * Set animals
     *
     * @param boolean $animals
     *
     * @return Car
     */
    public function setAnimals($animals)
    {
        $this->animals = $animals;

        return $this;
    }

    /**
     * Get animals
     *
     * @return boolean
     */
    public function getAnimals()
    {
        return $this->animals;
    }

    /**
     * Set music
     *
     * @param boolean $music
     *
     * @return Car
     */
    public function setMusic($music)
    {
        $this->music = $music;

        return $this;
    }

    /**
     * Get music
     *
     * @return boolean
     */
    public function getMusic()
    {
        return $this->music;
    }

    /**
     * Set talk
     *
     * @param boolean $talk
     *
     * @return Car
     */
    public function setTalk($talk)
    {
        $this->talk = $talk;

        return $this;
    }

    /**
     * Get talk
     *
     * @return boolean
     */
    public function getTalk()
    {
        return $this->talk;
    }

    /**
     * Set maxWidth
     *
     * @param float $maxWidth
     *
     * @return Car
     */
    public function setMaxWidth($maxWidth)
    {
        $this->maxWidth = $maxWidth;

        return $this;
    }

    /**
     * Get maxWidth
     *
     * @return float
     */
    public function getMaxWidth()
    {
        return $this->maxWidth;
    }

    /**
     * Set maxHeight
     *
     * @param float $maxHeight
     *
     * @return Car
     */
    public function setMaxHeight($maxHeight)
    {
        $this->maxHeight = $maxHeight;

        return $this;
    }

    /**
     * Get maxHeight
     *
     * @return float
     */
    public function getMaxHeight()
    {
        return $this->maxHeight;
    }

    /**
     * Set maxDepth
     *
     * @param float $maxDepth
     *
     * @return Car
     */
    public function setMaxDepth($maxDepth)
    {
        $this->maxDepth = $maxDepth;

        return $this;
    }

    /**
     * Get maxDepth
     *
     * @return float
     */
    public function getMaxDepth()
    {
        return $this->maxDepth;
    }

    /**
     * Set maxWeight
     *
     * @param float $maxWeight
     *
     * @return Car
     */
    public function setMaxWeight($maxWeight)
    {
        $this->maxWeight = $maxWeight;

        return $this;
    }

    /**
     * Get maxWeight
     *
     * @return float
     */
    public function getMaxWeight()
    {
        return $this->maxWeight;
    }

    /**
     * Set user
     *
     * @param \WWW\UserBundle\Entity\User $user
     *
     * @return Car
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
}

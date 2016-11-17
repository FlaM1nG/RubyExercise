<?php

namespace WWW\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hobby
 */
class Hobby
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
    private $description;


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
     * Set name
     *
     * @param string $name
     * @return Hobby
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
     * Set description
     *
     * @param string $description
     * @return Hobby
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
     * @var \WWW\GlobalBundle\Entity\Photo
     */
    private $photo;


    /**
     * Set photo
     *
     * @param \WWW\GlobalBundle\Entity\Photo $photo
     * @return Hobby
     */
    public function setPhoto(\WWW\GlobalBundle\Entity\Photo $photo = null)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return \WWW\GlobalBundle\Entity\Photo 
     */
    public function getPhoto()
    {
        return $this->photo;
    }
    /**
     * @var boolean
     */
    private $deleted;


    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return Hobby
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean 
     */
    public function getDeleted()
    {
        return $this->deleted;
    }
}

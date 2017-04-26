<?php

namespace WWW\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cancelation
 */
class Cancelation
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $concept;


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
     * Set concept
     *
     * @param string $concept
     * @return Cancelation
     */
    public function setConcept($concept)
    {
        $this->concept = $concept;

        return $this;
    }

    /**
     * Get concept
     *
     * @return string 
     */
    public function getConcept()
    {
        return $this->concept;
    }
    /**
     * @var \DateTime
     */
    private $revisionDate;

    /**
     * @var \DateTime
     */
    private $createdDate;

    /**
     * @var \DateTime
     */
    private $modifiedDate;

    /**
     * @var \DateTime
     */
    private $deletedDate;

    /**
     * @var \WWW\UserBundle\Entity\User
     */
    private $open_user;

    /**
     * @var \WWW\UserBundle\Entity\User
     */
    private $guilt_user;

    /**
     * @var \WWW\UserBundle\Entity\User
     */
    private $revision_user;

    /**
     * @var \WWW\ServiceBundle\Entity\Inscription
     */
    private $inscription;


    /**
     * Set revisionDate
     *
     * @param \DateTime $revisionDate
     * @return Cancelation
     */
    public function setRevisionDate($revisionDate)
    {
        $this->revisionDate = $revisionDate;

        return $this;
    }

    /**
     * Get revisionDate
     *
     * @return \DateTime 
     */
    public function getRevisionDate()
    {
        return $this->revisionDate;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return Cancelation
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime 
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set modifiedDate
     *
     * @param \DateTime $modifiedDate
     * @return Cancelation
     */
    public function setModifiedDate($modifiedDate)
    {
        $this->modifiedDate = $modifiedDate;

        return $this;
    }

    /**
     * Get modifiedDate
     *
     * @return \DateTime 
     */
    public function getModifiedDate()
    {
        return $this->modifiedDate;
    }

    /**
     * Set deletedDate
     *
     * @param \DateTime $deletedDate
     * @return Cancelation
     */
    public function setDeletedDate($deletedDate)
    {
        $this->deletedDate = $deletedDate;

        return $this;
    }

    /**
     * Get deletedDate
     *
     * @return \DateTime 
     */
    public function getDeletedDate()
    {
        return $this->deletedDate;
    }

    /**
     * Set open_user
     *
     * @param \WWW\UserBundle\Entity\User $openUser
     * @return Cancelation
     */
    public function setOpenUser(\WWW\UserBundle\Entity\User $openUser = null)
    {
        $this->open_user = $openUser;

        return $this;
    }

    /**
     * Get open_user
     *
     * @return \WWW\UserBundle\Entity\User 
     */
    public function getOpenUser()
    {
        return $this->open_user;
    }

    /**
     * Set guilt_user
     *
     * @param \WWW\UserBundle\Entity\User $guiltUser
     * @return Cancelation
     */
    public function setGuiltUser(\WWW\UserBundle\Entity\User $guiltUser = null)
    {
        $this->guilt_user = $guiltUser;

        return $this;
    }

    /**
     * Get guilt_user
     *
     * @return \WWW\UserBundle\Entity\User 
     */
    public function getGuiltUser()
    {
        return $this->guilt_user;
    }

    /**
     * Set revision_user
     *
     * @param \WWW\UserBundle\Entity\User $revisionUser
     * @return Cancelation
     */
    public function setRevisionUser(\WWW\UserBundle\Entity\User $revisionUser = null)
    {
        $this->revision_user = $revisionUser;

        return $this;
    }

    /**
     * Get revision_user
     *
     * @return \WWW\UserBundle\Entity\User 
     */
    public function getRevisionUser()
    {
        return $this->revision_user;
    }

    /**
     * Set inscription
     *
     * @param \WWW\ServiceBundle\Entity\Inscription $inscription
     * @return Cancelation
     */
    public function setInscription(\WWW\ServiceBundle\Entity\Inscription $inscription = null)
    {
        $this->inscription = $inscription;

        return $this;
    }

    /**
     * Get inscription
     *
     * @return \WWW\ServiceBundle\Entity\Inscription 
     */
    public function getInscription()
    {
        return $this->inscription;
    }
}

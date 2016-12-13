<?php

namespace WWW\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ForgottenPassword
 */
class ForgottenPassword
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $token;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var bool
     */
    private $changed;
    
    /**
     * @var \WWW\UserBundle\Entity\User
     */
    private $user;


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
     * Set token
     *
     * @param string $token
     * @return ForgottenPassword
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return ForgottenPassword
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set changed
     *
     * @param boolean $changed
     * @return ForgottenPassword
     */
    public function setChanged($changed)
    {
        $this->changed = $changed;

        return $this;
    }

    /**
     * Get changed
     *
     * @return boolean 
     */
    public function getChanged()
    {
        return $this->changed;
    }


    /**
     * Set user
     *
     * @param \WWW\UserBundle\Entity\User $user
     * @return ForgottenPassword
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

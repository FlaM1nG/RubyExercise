<?php

namespace WWW\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConfirmEmail
 */
class ConfirmEmail
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $email;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var bool
     */
    private $clicked;

    /**
     * @var string
     */
    private $token;
    
    /**
     * @var boolean
     */
    private $original;

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
     * Set email
     *
     * @param string $email
     * @return ConfirmEmail
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return ConfirmEmail
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
     * Set clicked
     *
     * @param boolean $clicked
     * @return ConfirmEmail
     */
    public function setClicked($clicked)
    {
        $this->clicked = $clicked;

        return $this;
    }

    /**
     * Get clicked
     *
     * @return boolean 
     */
    public function getClicked()
    {
        return $this->clicked;
    }

    /**
     * Set token
     *
     * @param string $token
     * @return ConfirmEmail
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
     * Set original
     *
     * @param boolean $original
     * @return ConfirmEmail
     */
    public function setOriginal($original)
    {
        $this->original = $original;

        return $this;
    }

    /**
     * Get original
     *
     * @return boolean 
     */
    public function getOriginal()
    {
        return $this->original;
    }

    /**
     * Set user
     *
     * @param \WWW\UserBundle\Entity\User $user
     * @return ConfirmEmail
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

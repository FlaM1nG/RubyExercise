<?php

namespace WWW\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConfirmSms
 */
class ConfirmSms
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
    private $clicked;
        
    /**
     * @var \WWW\UserBundle\Entity\User
     */
    private $user;    
    
    /**
     * @var integer
     */
    private $phone;

    /**
     * @var string
     */
    private $prefix;


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
     * @return ConfirmSms
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
     * @return ConfirmSms
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
     * @return ConfirmSms
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
     * Set user
     *
     * @param \WWW\UserBundle\Entity\User $user
     * @return ConfirmSms
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


    /**
     * Set phone
     *
     * @param integer $phone
     * @return ConfirmSms
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return integer 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set prefix
     *
     * @param string $prefix
     * @return ConfirmSms
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Get prefix
     *
     * @return string 
     */
    public function getPrefix()
    {
        return $this->prefix;
    }
}

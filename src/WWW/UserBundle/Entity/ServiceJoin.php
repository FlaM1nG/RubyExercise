<?php

namespace WWW\UserBundle\Entity;

/**
 * ServiceJoin
 */
class ServiceJoin
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var bool
     */
    private $vip;

    /**
     * @var \DateTime
     */
    private $dateVip;

    /**
     * @var bool
     */
    private $autoRenove;

    /**
     * @var int
     */
    private $months;


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
     * Set vip
     *
     * @param boolean $vip
     *
     * @return ServiceJoin
     */
    public function setVip($vip)
    {
        $this->vip = $vip;

        return $this;
    }

    /**
     * Get vip
     *
     * @return bool
     */
    public function getVip()
    {
        return $this->vip;
    }

    /**
     * Set dateVip
     *
     * @param \DateTime $dateVip
     *
     * @return ServiceJoin
     */
    public function setDateVip($dateVip)
    {
        $this->dateVip = $dateVip;

        return $this;
    }

    /**
     * Get dateVip
     *
     * @return \DateTime
     */
    public function getDateVip()
    {
        return $this->dateVip;
    }

    /**
     * Set autoRenove
     *
     * @param boolean $autoRenove
     *
     * @return ServiceJoin
     */
    public function setAutoRenove($autoRenove)
    {
        $this->autoRenove = $autoRenove;

        return $this;
    }

    /**
     * Get autoRenove
     *
     * @return bool
     */
    public function getAutoRenove()
    {
        return $this->autoRenove;
    }

    /**
     * Set months
     *
     * @param integer $months
     *
     * @return ServiceJoin
     */
    public function setMonths($months)
    {
        $this->months = $months;

        return $this;
    }

    /**
     * Get months
     *
     * @return int
     */
    public function getMonths()
    {
        return $this->months;
    }
    /**
     * @var \WWW\UserBundle\Entity\User
     */
    private $user;

    /**
     * @var \WWW\UserBundle\Entity\User
     */
    private $service;


    /**
     * Set user
     *
     * @param \WWW\UserBundle\Entity\User $user
     *
     * @return ServiceJoin
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
     * Set service
     *
     * @param \WWW\UserBundle\Entity\User $service
     *
     * @return ServiceJoin
     */
    public function setService(\WWW\UserBundle\Entity\User $service = null)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return \WWW\UserBundle\Entity\User
     */
    public function getService()
    {
        return $this->service;
    }
}

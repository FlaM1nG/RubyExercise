<?php

namespace WWW\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Role
 */
class Role
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $permissions;
    
    private $users;

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
     * @return Role
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
     * Constructor
     */
    public function __construct($arrayData = null)
    {
        $this->permissions = new \Doctrine\Common\Collections\ArrayCollection();
        
        if(!empty($arrayData)):
            $this->id = $arrayData['id'];
            $this->name = $arrayData['name'];
        endif;
    }

    /**
     * Add permissions
     *
     * @param \WWW\UserBundle\Entity\Permission $permissions
     * @return Role
     */
    public function addPermission(\WWW\UserBundle\Entity\Permission $permissions)
    {
        $this->permissions[] = $permissions;

        return $this;
    }

    /**
     * Remove permissions
     *
     * @param \WWW\UserBundle\Entity\Permission $permissions
     */
    public function removePermission(\WWW\UserBundle\Entity\Permission $permissions)
    {
        $this->permissions->removeElement($permissions);
    }

    /**
     * Get permissions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * Add users
     *
     * @param \WWW\UserBundle\Entity\User $users
     * @return Role
     */
    public function addUser(\WWW\UserBundle\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \WWW\UserBundle\Entity\User $users
     */
    public function removeUser(\WWW\UserBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }
}

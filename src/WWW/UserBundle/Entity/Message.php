<?php

namespace WWW\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 */
class Message
{
    /**
     * @var int
     */
    private $id;
    
    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $message;

    /**
     * @var integer
     */
    private $status;

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
     * @var boolean
     */
    private $fromDeleted;

    /**
     * @var boolean
     */
    private $toDeleted;

    /**
     * @var \WWW\UserBundle\Entity\User
     */
    private $from;

    /**
     * @var \WWW\UserBundle\Entity\User
     */
    private $to;

    /**
     * @var \WWW\UserBundle\Entity\User
     */
    private $revisionUser;
    
    
    /**
     * @var \WWW\ServiceBundle\Entity\Offer
     */
    private $offer;

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
     * Set subject
     *
     * @param string $subject
     * @return Message
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return Message
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Message
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set revisionDate
     *
     * @param \DateTime $revisionDate
     * @return Message
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
     * @return Message
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
     * @return Message
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
     * @return Message
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
     * Set fromDeleted
     *
     * @param boolean $fromDeleted
     * @return Message
     */
    public function setFromDeleted($fromDeleted)
    {
        $this->fromDeleted = $fromDeleted;

        return $this;
    }

    /**
     * Get fromDeleted
     *
     * @return boolean 
     */
    public function getFromDeleted()
    {
        return $this->fromDeleted;
    }

    /**
     * Set toDeleted
     *
     * @param boolean $toDeleted
     * @return Message
     */
    public function setToDeleted($toDeleted)
    {
        $this->toDeleted = $toDeleted;

        return $this;
    }

    /**
     * Get toDeleted
     *
     * @return boolean 
     */
    public function getToDeleted()
    {
        return $this->toDeleted;
    }

    /**
     * Set from
     *
     * @param \WWW\UserBundle\Entity\User $from
     * @return Message
     */
    public function setFrom(\WWW\UserBundle\Entity\User $from = null)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Get from
     *
     * @return \WWW\UserBundle\Entity\User 
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Set to
     *
     * @param \WWW\UserBundle\Entity\User $to
     * @return Message
     */
    public function setTo(\WWW\UserBundle\Entity\User $to = null)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * Get to
     *
     * @return \WWW\UserBundle\Entity\User 
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Set revisionUser
     *
     * @param \WWW\UserBundle\Entity\User $revisionUser
     * @return Message
     */
    public function setRevisionUser(\WWW\UserBundle\Entity\User $revisionUser = null)
    {
        $this->revisionUser = $revisionUser;

        return $this;
    }

    /**
     * Get revisionUser
     *
     * @return \WWW\UserBundle\Entity\User 
     */
    public function getRevisionUser()
    {
        return $this->revisionUser;
    }


    /**
     * Set offer
     *
     * @param \WWW\ServiceBundle\Entity\Offer $offer
     * @return Message
     */
    public function setOffer(\WWW\ServiceBundle\Entity\Offer $offer = null)
    {
        $this->offer = $offer;

        return $this;
    }

    /**
     * Get offer
     *
     * @return \WWW\ServiceBundle\Entity\Offer 
     */
    public function getOffer()
    {
        return $this->offer;
    }
}

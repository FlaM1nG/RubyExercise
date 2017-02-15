<?php

namespace WWW\GlobalBundle\Entity;

/**
 * Calendar
 */
class Calendar
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
     * @var bool
     */
    private $isDeleted;


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
     * Set name
     *
     * @param string $name
     *
     * @return Calendar
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
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return Calendar
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
     *
     * @return Calendar
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
     *
     * @return Calendar
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
     * Set isDeleted
     *
     * @param boolean $isDeleted
     *
     * @return Calendar
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * Get isDeleted
     *
     * @return bool
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $dateLogs;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dateLogs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add dateLog
     *
     * @param \WWW\GlobalBundle\Entity\DateLog $dateLog
     *
     * @return Calendar
     */
    public function addDateLog(\WWW\GlobalBundle\Entity\DateLog $dateLog)
    {
        $this->dateLogs[] = $dateLog;

        return $this;
    }

    /**
     * Remove dateLog
     *
     * @param \WWW\GlobalBundle\Entity\DateLog $dateLog
     */
    public function removeDateLog(\WWW\GlobalBundle\Entity\DateLog $dateLog)
    {
        $this->dateLogs->removeElement($dateLog);
    }

    /**
     * Get dateLogs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDateLogs()
    {
        return $this->dateLogs;
    }
}

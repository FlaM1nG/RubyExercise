<?php

namespace WWW\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InscriptionHistory
 */
class InscriptionHistory
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
     * @var string
     */
    private $keyLog;

    /**
     * @var \DateTime
     */
    private $date;


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
     * @return InscriptionHistory
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
     * Set keyLog
     *
     * @param string $keyLog
     * @return InscriptionHistory
     */
    public function setKeyLog($keyLog)
    {
        $this->keyLog = $keyLog;

        return $this;
    }

    /**
     * Get keyLog
     *
     * @return string 
     */
    public function getKeyLog()
    {
        return $this->keyLog;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return InscriptionHistory
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
     * @var \WWW\ServiceBundle\Entity\Inscription
     */
    private $inscription;


    /**
     * Set inscription
     *
     * @param \WWW\ServiceBundle\Entity\Inscription $inscription
     * @return InscriptionHistory
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

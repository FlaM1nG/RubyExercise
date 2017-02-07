<?php

namespace WWW\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Util\Inflector as Inflector;

/**
 * Down
 */
class Down
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $reason;


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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Down
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
     * Set reason
     *
     * @param string $reason
     *
     * @return Down
     */
    public function setReason($reason)
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * Get reason
     *
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }
    /**
     * @var \WWW\UserBundle\Entity\User
     */
    private $user;


    public function __construct( $data=null){
        if(!empty($data)):
            foreach($data as $key => $value):
                $key = Inflector::camelize($key);

                if(property_exists('WWW\UserBundle\Entity\Down',$key)):
                    $this->$key = $value;

                endif;
            endforeach;





        endif;
    }
    /**
     * Set user
     *
     * @param \WWW\UserBundle\Entity\User $user
     *
     * @return Down
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

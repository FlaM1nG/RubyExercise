<?php

namespace WWW\OthersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trade
 */
class Trade
{
    /**
     * @var int
     */
    private $id;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}

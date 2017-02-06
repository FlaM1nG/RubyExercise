<?php
/**
 * Created by PhpStorm.
 * User: Julio
 * Date: 01/02/2017
 * Time: 9:24
 */
namespace WWW\PaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Payum\Core\Model\ArrayObject;

/**
 * @ORM\Table
 * @ORM\Entity
 */
class PaymentDetails extends ArrayObject
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @var integer $id
     */
    protected $id;
}
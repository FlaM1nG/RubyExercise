<?php
/**
 * Created by PhpStorm.
 * User: Julio
 * Date: 30/01/2017
 * Time: 12:56
 */
namespace WWW\PaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Payum\Core\Model\Token;

/**
 * @ORM\Table
 * @ORM\Entity
 */
class PaymentToken extends Token
{
}
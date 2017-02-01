<?php

namespace WWW\PaymentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
        
    public function indexAction()
    {
        return $this->render('PaymentBundle:Default:index.html.twig');
    }
}

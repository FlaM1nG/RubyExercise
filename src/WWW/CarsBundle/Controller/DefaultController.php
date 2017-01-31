<?php

namespace WWW\CarsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CarsBundle:Default:index.html.twig');
    }
}

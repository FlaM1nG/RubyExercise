<?php

namespace WWW\HouseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('HouseBundle:Default:index.html.twig');
    }
}

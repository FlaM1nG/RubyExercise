<?php

namespace WWW\GlobalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('GlobalBundle:Default:index.html.twig');
    }
}

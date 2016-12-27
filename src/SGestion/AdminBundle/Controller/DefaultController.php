<?php

namespace SGestion\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SGestionAdminBundle:Default:index.html.twig');
    }
}

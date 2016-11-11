<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('home/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ));
    }
    
    
    public function aboutUsAction() {
        return $this->render('pages/aboutUs.html.twig');
    }
    
    public function siteMapAction() {
        return $this->render('pages/siteMap.html.twig');
    }
    
    public function ordersAction() {
        return $this->render('pages/orders.html.twig');
    }
    
    public function devolutionsAction() {
        return $this->render('pages/devolutions.html.twig');
    }
    
    public function contactAction() {
        return $this->render('pages/contact.html.twig');
    }
    
    public function shippingAction() {
        return $this->render('pages/shipping.html.twig');
    }
    
    public function privacyPolicyAction() {
        return $this->render('pages/privacyPolicy.html.twig');
    }
}

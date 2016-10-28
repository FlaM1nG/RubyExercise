<?php

namespace WWW\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('UserBundle:Default:index.html.twig');
    }
    
    public function loginAction(Request $request){
        
    }
    
    public function showRegisterAction(){
        
        $formulario = $this->createForm('WWW\UserBundle\Form\RegisterType');
        
        return $this->render('UserBundle:Default:register.html.twig',array('formulario'=>$formulario->createView()));
             
    }
    
    public function registerAction(Request $request){
        
        $usuario = new User();

        
        
    }
    
    public function showAction(){
        
    }
}

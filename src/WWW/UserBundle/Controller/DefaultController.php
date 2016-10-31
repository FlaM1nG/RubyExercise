<?php

namespace WWW\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validation;
use WWW\UserBundle\Entity\User;

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
        
        $data = $request->request->all()['registroUsuario'];
        $usuario = new User();
        
        
        $usuario->setEmail($data['email']);
        $usuario->setUsername($data['username']);
        $usuario->setPassword($data['password']['first']);
        
        $validador = Validation::createValidatorBuilder()->getValidator();
        $validador->validate($usuario);
        
        print_r($validador);
        /*if(count($errors)> 0 ):
            echo "hay errores";
        else:
            echo "no hay errores";
        endif;*/
        
       
        exit;
        
        
    }
    
    public function showAction(){
        
    }
}

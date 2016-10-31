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
        
        $usuario = new User();
        
        $formulario = $this->createForm('WWW\UserBundle\Form\RegisterType',$usuario);
         
        //El usuario del formulario se asocia al objeto $usuario
        $formulario->handleRequest($request);
        
        if($formulario->isValid()):
            
            //Obtiene la codificador de usuario
            $encoder = $this->get('security.encoder_factory')->getEncoder($usuario);
        
            //Codificamos la contraseña
            $passwordCodificada = $encoder->encodePassword($usuario->getPassword(),$usuario->getSalt());
            $usuario->setPassword($passwordCodificada);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();
            
            return $this->render('UserBundle:Default:register.html.twig',array('formulario'=>$formulario->createView()));
        else:
            return $this->render('UserBundle:Default:register.html.twig',array('formulario'=>$formulario->createView()));
        endif;
                
    }
    
    public function showAction(){
        
    }
}

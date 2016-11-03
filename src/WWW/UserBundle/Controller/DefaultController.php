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
         if($request->getMethod()=="POST")
        {
            $email=$request->get("email");
            $password=$request->get("password");  
         
            //echo "correo=".$correo."<br>pass=".$pass;exit;
            $user=$this->getDoctrine()->getRepository('UserBundle:User')->findOneBy(array("email"=>$email,"password"=>$password));
        
            if($user)
            {
             $session=$request->getSession();
               $session->set("id",$user->getId());
               $session->set("username",$user->getUsername());
               //echo $session->get("username");exit;
               return $this->redirect($this->generateUrl('user_homepage'));
            }else
            {
                $this->get('session')->getFlashBag()->add(
                                'mensaje',
                                'Los datos ingresados no son válidos'
                            );
                    return $this->redirect($this->generateUrl('user_login'));
            }
        }
        
        return $this->render('UserBundle:Default:login.html.twig');
        
    }
    
    public function logoutAction(Request $request){
        $session=$request->getSession();
        $session->clear();
         $this->get('session')->getFlashBag()->add(
                                'mensaje',
                                'Se ha cerrado la sesion con exito'
                            );
                    return $this->redirect($this->generateUrl('user_login'));
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
            //$em->flush();
            
            return $this->render('UserBundle:Default:register.html.twig',array('formulario'=>$formulario->createView()));
        else:
            return $this->render('UserBundle:Default:register.html.twig',array('formulario'=>$formulario->createView()));
        endif;
                
    }
    
    public function showAction(){
        
    }
}

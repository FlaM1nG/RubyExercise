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
    
    public function registerAction(Request $request){
        
        $usuario = new User();
        
        $formulario = $this->createForm('WWW\UserBundle\Form\RegisterType',$usuario);
         
        //El usuario del formulario se asocia al objeto $usuario
        $formulario->handleRequest($request);
        
        if($formulario->isValid()):
            
            $ch = curl_init();
            
            // definimos la URL a la que hacemos la petición
            curl_setopt($ch, CURLOPT_URL,"http://localhost/api_rest/register_user.php");
            // indicamos el tipo de petición: POST
            curl_setopt($ch, CURLOPT_POST, TRUE);
            // definimos cada uno de los parámetros
            curl_setopt($ch, CURLOPT_POSTFIELDS, "username=".$usuario->getUsername().
                    "&email=".$usuario->getEmail().
                    "&password=".$usuario->getPassword()."");

            // recibimos la respuesta y la guardamos en una variable
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $remote_server_output = curl_exec ($ch);

            // cerramos la sesión cURL
            curl_close ($ch);
            /*
            //Obtiene la codificador de usuario
            $encoder = $this->get('security.encoder_factory')->getEncoder($usuario);
        
            //Codificamos la contraseña
            $passwordCodificada = $encoder->encodePassword($usuario->getPassword(),$usuario->getSalt());
            $usuario->setPassword($passwordCodificada);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();*/
            
            return $this->render('UserBundle:Register:register.html.twig',array('formulario'=>$formulario->createView()));
        else:
            return $this->render('UserBundle:Register:register.html.twig',array('formulario'=>$formulario->createView()));
        endif;
                
    }
    
    public function showAction(){
        
    }
}

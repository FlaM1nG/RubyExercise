<?php

namespace WWW\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Validation;
use WWW\UserBundle\Entity\User as User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use WWW\GlobalBundle\Entity\Address;
use WWW\UserBundle\Form\ProfileType;

class DefaultController extends Controller{
    
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        return $this->render('UserBundle:Default:index.html.twig');
    }
    
    public function loginAction(Request $request){

        $formulario = $this->createForm('WWW\UserBundle\Form\LoginType');
        
        $formulario->handleRequest($request);

        if($request->getMethod()=="POST"):
            
            $email=$request->request->all()['loginUser']['username'];
            $password=$request->request->all()['loginUser']['password'];  
         
            $ch = curl_init();
            
            // definimos la URL a la que hacemos la petición
            curl_setopt($ch, CURLOPT_URL,"http://www.whatwantweb.com/api_rest/user/registration/login_user.php");
            // indicamos el tipo de petición: POST
            curl_setopt($ch, CURLOPT_POST, TRUE);
            // definimos cada uno de los parámetros
            curl_setopt($ch, CURLOPT_POSTFIELDS, "username=".$email.
                    "&password=".$password."");

 
            // recibimos la respuesta y la guardamos en una variable
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
            $remote_server_output = curl_exec ($ch);
            var_dump($remote_server_output); 
            $data = json_decode($remote_server_output, true);
            
            $user = new User();
            
            $data = json_decode($remote_server_output, true);
         
             // cerramos la sesión cURL
            curl_close ($ch);
            
            if($data['result'] == 'ok'):
                
               $session=$request->getSession();
               $session->set("id",$data['id']);
               $session->set("username",$data['username']);
               $session->set("password",$data['password']);
               
               return $this->redirect($this->generateUrl('user_homepage'));
            else:
                $this->get('session')->getFlashBag()->add(
                                'mensaje',
                                'Los datos ingresados no son válidos'
                            );
                return $this->render('UserBundle:Default:login.html.twig',array('formulario'=>$formulario->createView()));
            endif;
        
        else: 
            return $this->render('UserBundle:Default:login.html.twig',array('formulario'=>$formulario->createView()));
        endif;
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
    
    public function registerAction(Request $request){
        
        $usuario = new User();
       
        $formulario = $this->createForm('WWW\UserBundle\Form\RegisterType',$usuario);
         
        //El usuario del formulario se asocia al objeto $usuario
        $formulario->handleRequest($request);
        
        if($formulario->isValid()):
           
            $arrayBirthdate = $request->request->all()['registroUsuario']['birthdate'];
            $mes = $arrayBirthdate['month'];
            $dia = $arrayBirthdate['day'];
            
            if(strlen($mes) < 2) 
                $mes = '0'.$mes;
            if(strlen($dia) < 2) 
                $dia = '0'.$dia;
            
            $nacimiento =$arrayBirthdate['year']."-".$mes.'-'.$dia;
            
            $ch = curl_init();
            
            // definimos la URL a la que hacemos la petición
            curl_setopt($ch, CURLOPT_URL,"http://www.whatwantweb.com/api_rest/user/registration/register_user.php");
            // indicamos el tipo de petición: POST
            curl_setopt($ch, CURLOPT_POST, TRUE);
            // definimos cada uno de los parámetros
            curl_setopt($ch, CURLOPT_POSTFIELDS, "username=".$usuario->getUsername().
                    "&email=".$usuario->getEmail().
                    "&date=".$nacimiento.
                    "&password=".$usuario->getPassword()."");

            // recibimos la respuesta y la guardamos en una variable
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
            $remote_server_output = curl_exec ($ch);
            
            $data = json_decode($remote_server_output, true);


            // cerramos la sesión cURL
            curl_close ($ch); 
             
            
            return $this->render('UserBundle:Register:register.html.twig',array('formulario'=>$formulario->createView()));
        else:
            return $this->render('UserBundle:Register:register.html.twig',array('formulario'=>$formulario->createView()));
        endif;
                
    }
    /**
     * Matches /change/*
     *
     * @Route("/change/{token}", name="user_change")
     */
    public function changePassAction(Request $request,$token){
        //pillar el usuario segun la relación token - user_id
        $usuario = new User();
       
        $formulario = $this->createForm('WWW\UserBundle\Form\ChangePassType',$usuario);
         
        //El usuario del formulario se asocia al objeto $usuario
        $formulario->handleRequest($request);
        
        if(!empty($usuario->getPassword())):
            
            $ch = curl_init();
            
            // definimos la URL a la que hacemos la petición
            curl_setopt($ch, CURLOPT_URL,"http://www.whatwantweb.com/api_rest/user/passwords/new_password.php");
            // indicamos el tipo de petición: POST
            curl_setopt($ch, CURLOPT_POST, TRUE);
            // definimos cada uno de los parámetros
            curl_setopt($ch, CURLOPT_POSTFIELDS, 
                    "&password=".$usuario->getPassword().
                    "&token=".$token."");

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
            
            return $this->render('UserBundle:ChangePass:changepass.html.twig',array('formulario'=>$formulario->createView(),'token'=>$token));
        else:
            return $this->render('UserBundle:ChangePass:changepass.html.twig',array('formulario'=>$formulario->createView(),'token'=>$token));
        endif;
                
    }
    
    public function forgotPassAction(Request $request){
        
        $usuario = new User();
       
        $formulario = $this->createForm('WWW\UserBundle\Form\ForgotPassType',$usuario);
         
        //El usuario del formulario se asocia al objeto $usuario
        $formulario->handleRequest($request);
        
        if(!empty($usuario->getEmail())):
            
            $ch = curl_init();
            
            // definimos la URL a la que hacemos la petición
            curl_setopt($ch, CURLOPT_URL,"http://www.whatwantweb.com/api_rest/user/passwords/forget_password.php");
            // indicamos el tipo de petición: POST
            curl_setopt($ch, CURLOPT_POST, TRUE);
            // definimos cada uno de los parámetros
            curl_setopt($ch, CURLOPT_POSTFIELDS, 
                    "&email=".$usuario->getEmail()."");
           
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
            
            return $this->render('UserBundle:ForgotPass:forgotpass.html.twig',array('formulario'=>$formulario->createView()));
        else:
            
            return $this->render('UserBundle:ForgotPass:forgotpass.html.twig',array('formulario'=>$formulario->createView()));
        endif;
                
    }
}

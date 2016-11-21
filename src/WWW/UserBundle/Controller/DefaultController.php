<?php

namespace WWW\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validation;
use WWW\UserBundle\Entity\User as User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use WWW\GlobalBundle\Entity\ApiRed;

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
         
            $file = "http://www.whatwantweb.com/api_rest/user/registration/login_user.php";
            $data = array("username" => $email,
                          "password" => $password);
            
            $ch = new ApiRed();
            
            $result = $ch->sendInformation($data, $file, "parameters");
            
            $user = new User();
            
            if($result['result'] == 'ok'):
                
               $session=$request->getSession();
               $session->set("id",$result['id']);
               $session->set("username",$result['username']);
               $session->set("password",$result['password']);
               
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
            
            $file = "http://www.whatwantweb.com/api_rest/user/registration/register_user.php";
            $data = array("username" => $usuario->getUsername(),
                          "email" => $usuario->getEmail(),
                          "date" => $nacimiento,
                          "password" => $usuario->getPassword());
            
            $ch = new ApiRed();
            $result = $ch->sendInformation($data, $file, "parameters");

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
            
            $file = "http://www.whatwantweb.com/api_rest/user/passwords/new_password.php";
            $ch = new ApiRed();
            $data = array("password" => $usuario->getPassword(),
                             "token" => $token);
            $result = $ch->sendInformation($data, $file, "parameters");
            
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
            
            $file = "http://www.whatwantweb.com/api_rest/user/passwords/forget_password.php";
            $data = array("email" => $usuario->getEmail());
        
            $ch = new ApiRed();
            $result = $ch->sendInformation($data, $file, "parameters");
            
            return $this->render('UserBundle:ForgotPass:forgotpass.html.twig',array('formulario'=>$formulario->createView()));
        else:
            
            return $this->render('UserBundle:ForgotPass:forgotpass.html.twig',array('formulario'=>$formulario->createView()));
        endif;
                
    }
}

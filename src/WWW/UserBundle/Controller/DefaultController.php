<?php

namespace WWW\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WWW\UserBundle\Entity\User as User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\MyConstants;

class DefaultController extends Controller{
    
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        return $this->render('::home/index.html.twig');
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
            
            $file = MyConstants::PATH_APIREST."user/passwords/new_password.php";
            $ch = new ApiRest();
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
            
            $file = MyConstants::PATH_APIREST."user/passwords/forget_password.php";
            $data = array("email" => $usuario->getEmail());
        
            $ch = new ApiRest();
            $result = $ch->sendInformation($data, $file, "parameters");
            
            return $this->render('UserBundle:ForgotPass:forgotpass.html.twig',array('formulario'=>$formulario->createView()));
        else:
            
            return $this->render('UserBundle:ForgotPass:forgotpass.html.twig',array('formulario'=>$formulario->createView()));
        endif;
                
    }
    
    public function publicProfileAction(Request $request){
        return $this->render('UserBundle:Default:profilePublic.html.twig');
    }
    
    public function ResendAction(Request $request){
        $usuario = new User();
        $formulario = $this->createForm('WWW\UserBundle\Form\ForgotPassType',$usuario);
         
        //El usuario del formulario se asocia al objeto $usuario
        $formulario->handleRequest($request);
        
        if(!empty($usuario->getEmail())):            

            $file = "http://www.whatwantweb.com/A67C1VY9OgkXN496HSxNYG598A3M13/api_rest/user/email/resend_email.php";
            $data = array("email" => $usuario->getEmail());
            $ch = new ApiRest();
            $result = $ch->sendInformation($data, $file, "parameters");            

            return $this->render('UserBundle:ForgotPass:forgotpass.html.twig',array('formulario'=>$formulario->createView()));
        else:
            return $this->render('UserBundle:ForgotPass:forgotpass.html.twig',array('formulario'=>$formulario->createView()));

        endif;

    }
}

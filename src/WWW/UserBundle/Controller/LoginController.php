<?php

namespace WWW\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WWW\UserBundle\Entity\User as User;
use WWW\GlobalBundle\Entity\ApiRest;

class LoginController extends Controller{
    
    public function loginAction(Request $request){
        
        $session=$request->getSession();
        
        
        if(empty($session->get('intentoLogin')))
            $session->set('intentoLogin',0);
        

        $formulario = $this->createForm('WWW\UserBundle\Form\LoginType');
        
        $formulario->handleRequest($request);

        if($request->getMethod()=="POST"):
            
            $email=$request->request->all()['loginUser']['username'];
            $password=$request->request->all()['loginUser']['password'];  
         
            $file = "http://www.whatwantweb.com/api_rest/user/registration/login_user.php";
            $data = array("username" => $email,
                          "password" => $password);
            
            $ch = new ApiRest();
            
            $result = $ch->sendInformation($data, $file, "parameters");
            
            $user = new User();
            
            if($result['result'] == 'ok'):
                
               $session=$request->getSession();
               $session->set("id",$result['id']);
               $session->set("username",$result['username']);
               $session->set("password",$result['password']);
               $session->set('intentoLogin',0);
               
               return $this->redirect($this->generateUrl('homepage'));
            else:
                $session->set('intentoLogin',$session->get('intentoLogin')+1);
            
                $this->addFlash(
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
                                'mensaje2',
                                'Se ha cerrado la sesion con exito'
                            );
                    return $this->redirect($this->generateUrl('user_login'));
    }

}

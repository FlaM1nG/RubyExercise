<?php

namespace WWW\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validation;
use WWW\UserBundle\Entity\User as User;
use WWW\GlobalBundle\Entity\ApiRest;
use Symfony\Component\Security\Core\SecurityContext;

class LoginController extends Controller{
    
    public function loginAction(Request $request){
        $session=$request->getSession();
        
        
        if(empty($session->get('intentoLogin')))
            $session->set('intentoLogin',0);
        
        
        $formulario = $this->createForm('WWW\UserBundle\Form\LoginType', array( 'action' => 'user_login_check'));
        
        $formulario->handleRequest($request);

        if($request->getMethod()=="POST"):
            
            $email=$request->request->all()['loginUser']['_username'];
            $password=$request->request->all()['loginUser']['_password'];  
         
            $file = "http://www.whatwantweb.com/api_rest/user/registration/login_user.php";
            $data = array("username" => $email,
                          "password" => $password);
            
            $ch = new ApiRest();
            
            $result = $ch->sendInformation($data, $file, "parameters");
            
            $user = new User();
            
            $authenticationUtils = $this->get('security.authentication_utils');
                // get the login error if there is one
                $error = $authenticationUtils->getLastAuthenticationError();
                // last username entered by the user
                $lastUsername = $authenticationUtils->getLastUsername();
                
            if($result['result'] == 'ok'):
                
               $this->get('app.manager.usuario_manager')->login($user);
               $tokenRoleUser=$this->get('security.token_storage')->getToken();
            
               $session=$request->getSession();
               $session->set('tokenRole', $tokenRoleUser);
               $session->set("id",$result['id']);
               $session->set("username",$result['username']);
               $session->set("password",$result['password']);
               $session->set('intentoLogin',0);
               
                
                
                return $this->render('UserBundle:Default:login.html.twig',array('last_username' => $lastUsername,'error' => $error,'formulario'=>$formulario->createView()));
            else:
                $session->set('intentoLogin',$session->get('intentoLogin')+1);
            
                $this->addFlash(
                                'mensaje',
                                'Los datos ingresados no son válidos'
                            );
                return $this->render('UserBundle:Default:login.html.twig',array('last_username' => $lastUsername,'error' => $error,'formulario'=>$formulario->createView()));
            endif;
        
        else: 
            $authenticationUtils = $this->get('security.authentication_utils');
                // get the login error if there is one
                $error = $authenticationUtils->getLastAuthenticationError();
                // last username entered by the user
                $lastUsername = $authenticationUtils->getLastUsername();
            return $this->render('UserBundle:Default:login.html.twig',array('last_username' => $lastUsername,'error' => $error,'formulario'=>$formulario->createView()));
        endif;
    }
    
    public function logoutAction(Request $request){
        $session=$request->getSession();
        $session->clear();
        $this->container->get('security.context')->setToken(null);
        $this->get('session')->getFlashBag()->add(
                                'mensaje2',
                                'Se ha cerrado la sesion con exito'
                            );
                    return $this->redirect($this->generateUrl('user_login'));
    }
      /**
     * @Route("/login_check", name="usuario_login_check")
     */
    public function loginCheckAction()
    {
        // el "login check" lo hace Symfony automáticamente
    }

}

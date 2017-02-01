<?php

namespace WWW\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WWW\UserBundle\Entity\User as User;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\MyConstants;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class LoginController extends Controller{
    
    public function loginAction(Request $request){
        $session=$request->getSession();
        
        if(empty($session->get('intentoLogin')))
            $session->set('intentoLogin',0);
        
        
        $formulario = $this->createForm('WWW\UserBundle\Form\LoginType', array( 'action' => 'user_login_check'));
        
        $formulario->handleRequest($request);

        if($formulario->isSubmitted()):
            
            $email=$request->request->all()['loginUser']['_username'];
            $password=$request->request->all()['loginUser']['_password'];  
         
            $file = MyConstants::PATH_APIREST."user/registration/login_user.php";
            $data = array("username" => $email,
                          "password" => $password);
            
            $ch = new ApiRest();
            
            $result = $ch->resultApiRed($data, $file);

            $authenticationUtils = $this->get('security.authentication_utils');
            // get the login error if there is one
            $error = $authenticationUtils->getLastAuthenticationError();
            // last username entered by the user
            $lastUsername = $authenticationUtils->getLastUsername();
            
                
            if($result['result'] == 'ok'):
                
                $file = MyConstants::PATH_APIREST."user/data/get_info_user.php";
                $ch = new ApiRest();
                $data['id'] = $result['id'];
                $data['username'] = $result['username'];
                $data['password'] = $result['password'];
                
                $resultUser = $ch->resultApiRed($data, $file);
                
                $user = new User($resultUser);
//                print_r($user->getAddresses()); exit;
            
                if(!$this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')){        
                    $this->get('app.manager.usuario_manager')->login($user);
                }

               $session=$request->getSession();
               
               $session->set("id",$result['id']);
               $session->set("username",$result['username']);
               $session->set("password",$result['password']);
               $session->set('intentoLogin',0);
               $path =$session->get('_security.user.target_path');
               var_dump($path);
               if($path==NULL || $path=='user_register'){
                   return $this->redirectToRoute('homepage');
               }
               else{  
                   return $this->redirect($path);
               }
                   
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

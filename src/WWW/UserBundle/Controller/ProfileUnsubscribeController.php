<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


namespace WWW\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\Entity\Utilities;
use WWW\GlobalBundle\MyConstants;
use WWW\UserBundle\Entity\Down;
use WWW\UserBundle\Form\ProfileUnsubscribeType;
use WWW\UserBundle\Entity\User;

/**
 * Description of ProfileUnsubscribe
 *
 * @author Julio
 */
class ProfileUnsubscribeController extends Controller{
    
    public function unsubscribeAction(Request $request){
        
        $user = null;

        $down=new Down();
        $user = $this->getUserProfile($request);

        $form = $this->createForm(ProfileUnsubscribeType::class,$down);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()):
            
            $ut = new Utilities();
            $file = MyConstants::PATH_APIREST . "user/registration/delete_user.php";
            $ch = new ApiRest();

            $data['id'] = $user->getId();
            $data['username'] = $user->getUsername();
            $data['password'] = $user->getPassword();
            $data['reason']   = $down->getReason();
            $result = $ch->resultApiRed($data, $file);
            
            $ut->flashMessage("general", $request, $result);
            
            //Se hace un logout
            $session = $request->getSession();
            $session->clear();
            $this->container->get('security.context')->setToken(null);
            $this->get('session')->getFlashBag()->add(
                    'mensaje2', 'se ha dado de baja, si se loguea se da de alta'
            );
            return $this->redirect($this->generateUrl('homepage'));

        endif;

        return $this->render("UserBundle:Profile:unSubscribe.html.twig", 
                       array('user' => $user,
                             'form' => $form->createView())
                );
        
    }
    
    private function getUserProfile(Request $request){
        
        $user = null;
        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST.'user/data/get_info_user.php';
        
        $data['id'] = $this->getUser()->getId();
        $data['username'] = $this->getUser()->getUsername();
        $data['password'] = $request->getSession()->get('password');
        
        $result = $ch->resultApiRed($data, $file);
       
        if($result['result'] == 'ok'):
            $user = new User($result);
        endif;
       
        return $user;
    }
    

}

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
use WWW\UserBundle\Form\ProfileEmailType;
use WWW\UserBundle\Entity\User;

/**
 * Description of ProfileEmailController
 *
 * @author Rocio
 */
class ProfileEmailController extends Controller {
    
    public function profileEmailAction(Request $request){

        $user = $this->getUserProfile($request);
        
        $form = $this->createForm(ProfileEmailType::class, $user);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()):
            $this->changeEmail($request, $user);
        endif;
        
        return $this->render('UserBundle:Profile:emailProfile.html.twig',
                array('form' => $form->createView(),
                      'user' => $user)
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
    
    private function changeEmail(Request $request, User $user){
                
        $ut = new Utilities();
        $file = MyConstants::PATH_APIREST."user/email/change_email.php";
        $ch = new ApiRest();
        
        $data['id'] = $this->getUser()->getId();
        $data['username'] = $this->getUser()->getUsername();
        $data['password'] = $user->getPasswordEnClaro();
        $data['email'] = $user->getEmail();
        
        $result = $ch->resultApiRed($data, $file);
        
        $ut->flashMessage("general", $request, $result);
        
    }
}

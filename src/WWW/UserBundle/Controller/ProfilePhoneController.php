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
use WWW\UserBundle\Form\ProfilePhoneType;
use WWW\UserBundle\Form\ConfirmCodePhoneType;
use WWW\UserBundle\Entity\User;

/**
 * Description of ProfilePhoneController
 *
 * @author Rocio
 */
class ProfilePhoneController extends Controller{
    
    public function profilePhoneAction(Request $request){
        $result = $this->getInfoPhone($request);
 
        return $this->render('UserBundle:Profile:phoneProfile.html.twig',
                       array('phones' => $result['phones']));
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
    
    private function getInfoPhone(Request $request){
        
        $ch = new ApiRest();
        $file =  MyConstants::PATH_APIREST."user/phone/unconfirmed_phones.php";
        
        $data['id'] = $this->getUser()->getId();
        $data['username'] = $this->getUser()->getUsername();
        $data['password'] = $request->getSession()->get('password');
        
        $result = $ch->resultApiRed($data, $file);
        
        return $result;
    }
    
    public function profileChangePhoneAction(Request $request){
        
        $user = $this->getUser();
        $form = $this->createForm(ProfilePhoneType::class, $user);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()):
            $this->changePhone($request, $user);
        endif;
        
        return $this->render("UserBundle:Profile:changePhoneProfile.html.twig",
                        array('form' => $form->createView()));
    }
    private function changePhone(Request $request, User $user){
                
        $ut = new Utilities();
        $file = MyConstants::PATH_APIREST."user/phone/send_sms.php";
        $ch = new ApiRest();
        
        $data['id'] = $this->getUser()->getId();
        $data['username'] = $this->getUser()->getUsername();
        $data['password'] = $request->getSession()->get('password');
        $data['phone'] = $user->getPhone();
        $data['prefix'] = $user->getPrefix();
        
        $result = $ch->resultApiRed($data, $file);
        
        $ut->flashMessage("general", $request, $result);
        
    }
    
    public function confirmCodeAction(Request $request){
        
        $form = $this->createForm(ConfirmCodePhoneType::class);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted()):
            $result = $this->confirmPhone($request);
            if($result == 'ok'):
                return $this->forward('UserBundle:ProfilePhone:profilePhone');
            endif;
        endif;
        
        return $this->render('UserBundle:Profile:confirmPhone.html.twig',
                       array('form' => $form->createView()));
    }
    
    private function confirmPhone(Request $request){
        
        $ut = new Utilities();
        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST."user/phone/confirm_sms.php";
        
        $data['id'] = $this->getUser()->getId();
        $data['username'] = $this->getUser()->getUsername();
        $data['password'] = $request->getSession()->get('password');
        $data['token'] = $request->get('profilePhone')['codConfirmation'];
        
        $result = $ch->resultApiRed($data, $file);
        
        $ut->flashMessage("Número confirmado", $request, $result, "Código no válido o expirado");
        
        return $result['result'];
    }
}

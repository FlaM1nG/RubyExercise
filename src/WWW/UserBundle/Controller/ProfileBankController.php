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
use WWW\UserBundle\Form\ProfileBankType;
use WWW\UserBundle\Entity\User;

/**
 * Description of ProfileBank
 *
 * @author Rocio
 */
class ProfileBankController extends Controller{
    
    public function profileBankAction(Request $request){
        
        $user = $this->getUserProfile($request);
//        print_r($user);
        $form = $this->createForm(ProfileBankType::class, $user);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()):
            $this->changeBank($request,$user);
        endif;
        
        return $this->render('UserBundle:Profile:bankProfile.html.twig',
                       array('form' => $form->createView()));
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
    
    private function changeBank(Request $request,$user){
        
        $file = MyConstants::PATH_APIREST."user/data/update_user.php";
        $ch = new ApiRest();
        $ut = new Utilities();
        
        $data['username']=$user->getUsername();
        $data['id']=$user->getId();
        $data['password']=$user->getPassword();
        $data['num_account'] = "'".$user->getNumAccount()."'";
        $informacion['data'] = json_encode($data); 
        
        $result = $ch->resultApiRed($informacion, $file);
        
        $ut->flashMessage("general",$request,$result);
    }
}

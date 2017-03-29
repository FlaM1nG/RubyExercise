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
use WWW\UserBundle\Form\ProfilePasswordType;
use WWW\UserBundle\Entity\User;

/**
 * Description of ProfilePasswordController
 *
 * @author Rocio
 */
class ProfilePasswordController extends Controller{
    
    public function profilePasswordAction(Request $request){
        
        $user = $this->getUserProfile($request);
        
        $form = $this->createForm(ProfilePasswordType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()):

            $this->changePassword($request, $user);
           
        endif;
        
        return $this->render('UserBundle:Profile:passwordProfile.html.twig',
                       array('form' => $form->createView(),
                             'user' => $user));
    }
    
    private function getUserProfile(Request $request){
        
        $user = null;
        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST.'user/data/get_info_user.php';
        
        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');

        $result = $ch->resultApiRed($data, $file);
       
        if($result['result'] == 'ok'):
            $user = new User($result);
        endif;
       
        return $user;
    }
    
    private function changePassword(Request $request, User $user){
                
        $ut = new Utilities();
        $file = MyConstants::PATH_APIREST."user/passwords/change_password.php";
        $ch = new ApiRest();
        
        $data['id'] = $this->getUser()->getId();
        $data['username'] = $this->getUser()->getUsername();
        $data['old_password'] = $user->getPasswordEnClaro();
        $data['new_password'] = $user->getPassword();
        
        $result = $ch->resultApiRed($data, $file);

        if($result['result'] == 'ok'):
            $request->getSession()->set("password",$result['password']);
            $ut->flashMessage("general", $request, $result);
        elseif($result['result'] == 'bad_credentials'):
            $ut->flashMessage("general",$request, $result, "La contraseña no es correcta");
        else:
            $ut->flashMessage("general", $request, $result);
        endif;

        
    }
}

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
use WWW\UserBundle\Form\ProfilePhotoType;
use WWW\UserBundle\Entity\User;

/**
 * Description of ProfilePhotoController
 *
 * @author Rocio
 */
class ProfilePhotoController extends Controller{
    
    public function profilePhotoAction(Request $request){
        
        $user = $this->getUserProfile($request);

        $form = $this->createForm(ProfilePhotoType::class, $user);
        $form->handleRequest($request);
        
        if($form->isSubmitted()):
            $form->changePhotoProfile($request, $user);
        endif;
        
        return $this->render('UserBundle:Profile:photoProfile.html.twig',
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
    


}

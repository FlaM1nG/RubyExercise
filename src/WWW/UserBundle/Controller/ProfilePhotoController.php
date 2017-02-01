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

        if(!empty($request->files->get('avatar'))):
            $this->changePhotoProfile($request);
        endif;
print_r($user);
        return $this->render('UserBundle:Profile:photoProfile.html.twig',
                       array(//'form' => $form->createView(),
                             'user' => $user)
                );
    }
    
    private function getUserProfile(Request $request){
        
        $user = $this->getUser();
        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST.'user/data/get_info_user.php';
        
        $data['id'] = $user->getId();
        $data['username'] = $user->getUsername();
        $data['password'] = $request->getSession()->get('password');
        
        $result = $ch->resultApiRed($data, $file);
       
        if($result['result'] == 'ok'):
            $user = new User($result);
        endif;

        return $user;
    }

    private function changePhotoProfile(Request $request){

        $file = MyConstants::PATH_APIREST.'user/photo/update_photo.php';
        $ch = new ApiRest();

        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');

        $photo = $request->files->get('avatar');
        $ch_photo = new \CURLFile($photo->getPathname(),$photo->getMimetype());
        $data['photo'] = $ch_photo;

        $result=$ch->resultApiRed($data,$file);

    }


}

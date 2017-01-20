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
use WWW\UserBundle\Form\ProfilePersonalDataType;
use WWW\UserBundle\Entity\User;

/**
 * Description of ProfilePersonalData
 *
 * @author Rocio
 */
class ProfilePersonalDataController extends Controller{
    
    public function personalDataAction(Request $request){
        
        $user = null;
        $user = $this->getUserProfile($request);
        $form = $this->createForm(ProfilePersonalDataType::class,$user);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()):
            $this->changePersonalData($request, $user);
        endif;
        
        return $this->render("UserBundle:Profile:dataPersonal.html.twig", 
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
    
    private function changePersonalData(Request $request, User $user){
        $ut = new Utilities();
        $file = MyConstants::PATH_APIREST."user/data/update_user.php";
        $ch = new ApiRest();
        
        $data['id'] = $this->getUser()->getId();
        $data['username'] = $this->getUser()->getUsername();
        $data['password'] = $request->getSession()->get('password');
        $data['name'] = "'".$user->getName()."'";
        $data['surname'] = "'".$user->getSurname()."'";
        $data['sex'] = "'".$user->getSex()."'";
        $data['nif'] = "'".$user->getNif()."'";
        $data['birthdate'] = $user->getBirthdate()->format('Y-m-d');
        $info['data'] = json_encode($data);
        
        $result = $ch->resultApiRed($info, $file);
        
        $ut->flashMessage("general", $request, $result);

    }
}

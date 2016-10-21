<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DefaultController
 *
 * @author Rocio
 */

namespace WWW\UserBundle\Controller;

use WWW\UserBundle\Form\Type\ProfileFormType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WWW\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
 
class DefaultController extends Controller{
    
    public function showAction(Request $request){
        
        $user = $this->getUser();
       /* if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
*/
        
        $form = $this->createForm(new ProfileFormType(),$user);
        
        return $this->render('WWWUserBundle:Profile:edit.html.twig', array('form' => $form->createView(),
        ));
    
        
       
    }
}

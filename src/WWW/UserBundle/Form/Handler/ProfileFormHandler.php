<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace WWW\UserBundle\Form\Handler;

use FOS\UserBundle\Form\Handler\ProfileFormHandler as BaseHandler;
use FOS\UserBundle\Model\UserInterface;



/**
 * Description of ProfileFormHandler
 *
 * @author Rocio
 */
class ProfileFormHandler extends BaseHandler{
    //put your code here
    
    protected function onSuccess(UserInterface $user, $confirmation)
    {
        // Nota: si planeas modificar el usuario entonces hazlo antes de llamar al
        // método padre debido a que el método padre debe vaciar los cambios

        parent::onSuccess($user, $confirmation);

        // de lo contrario añade tu funcionalidad aquí
    }
    
}

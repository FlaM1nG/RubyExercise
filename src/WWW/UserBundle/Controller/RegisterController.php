<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace WWW\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WWW\UserBundle\Entity\User as User;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\UserBundle\Form\RegisterType;
use Symfony\Component\Form\AbstractType;

/**
 * Description of RegisterController
 *
 * @author Rocio
 */
class RegisterController extends Controller{
    
    public function registerAction(Request $request){
        
        $usuario = new User();
        
        $ch = new ApiRest();
        
        $resultHobbies = $ch->sendInformationWihoutParameters("http://www.whatwantweb.com/api_rest/user/data/get_hobbies.php");
        $totalHobbies = count($resultHobbies);
        $formulario = $this->createForm(RegisterType::class,$usuario);
        
        //El usuario del formulario se asocia al objeto $usuario
        $formulario->handleRequest($request);
        if($formulario->isValid()):
           
            $arrayBirthdate = $request->request->all()['registroUsuario']['birthdate'];
            $mes = $arrayBirthdate['month'];
            $dia = $arrayBirthdate['day'];
            $hobbies = "";
            $totalHobbiesCheck = 0;
            
            for($i = 0; $i<$totalHobbies; $i++):
                if(key_exists("hobbies_".$i, $request->request->all())):
                    $totalHobbiesCheck++;
                
                    if(empty($hobbies)):
                        $hobbies .= $request->request->all()['hobbies_'.$i]; 
                    else:
                        $hobbies .="-". $request->request->all()['hobbies_'.$i];  
                    endif;
                endif;
            endfor;
            
            if(strlen($mes) < 2) 
                $mes = '0'.$mes;
            if(strlen($dia) < 2) 
                $dia = '0'.$dia;
            
            if($totalHobbiesCheck != 3):
                $this->addFlash('error', 'Debe elegir 3 hobbies');
                return $this->redirectToRoute('user_register');
            endif;
            
            $nacimiento =$arrayBirthdate['year']."-".$mes.'-'.$dia;
            
            $file = "http://www.whatwantweb.com/api_rest/user/registration/register_user.php";
            $data = array("username" => $usuario->getUsername(),
                          "email" => $usuario->getEmail(),
                          "date" => $nacimiento,
                          "password" => $usuario->getPassword(),
                          "prefix" => $usuario->getPrefix(),
                          "phone" => $usuario->getPhone(),
                          "hobbies" => $hobbies
                );
            
            $ch = new ApiRest();
            
            $result = $ch->sendInformation($data, $file, "parameters");
            return $this->render('UserBundle:Register:register.html.twig',array('formulario'=>$formulario->createView(), "hobbies" => $resultHobbies));
        else:
            return $this->render('UserBundle:Register:register.html.twig',array('formulario'=>$formulario->createView(), "hobbies" => $resultHobbies));
        endif;
                
    }

}

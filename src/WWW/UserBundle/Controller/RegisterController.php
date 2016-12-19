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
use WWW\GlobalBundle\Entity\Utilities;

/**
 * Description of RegisterController
 *
 * @author Rocio
 */
class RegisterController extends Controller{
    
    private $usuario = null;
    private $ut = null;
    
    public function registerAction(Request $request){
        
        $this->usuario = new User();
        $this->ut =  new Utilities();
        
        $ch = new ApiRest();
        
        $resultHobbies = $ch->sendInformationWihoutParameters("http://www.whatwantweb.com/api_rest/user/data/get_hobbies.php");
        $totalHobbies = count($resultHobbies);
        $formulario = $this->createForm(RegisterType::class,$this->usuario);
        
        //El usuario del formulario se asocia al objeto $usuario
        $formulario->handleRequest($request);
        
        if($formulario->isValid()):
            $this->newUser($request, $totalHobbies);
            $result = $this->ut->flashMessage('register', $request, null);
            if($result == 'ok')
                return $this->redirectToRoute('homepage');
            else
                return $this->render('UserBundle:Register:register.html.twig',array('formulario'=>$formulario->createView(), "hobbies" => $resultHobbies));
        else:
            return $this->render('UserBundle:Register:register.html.twig',array('formulario'=>$formulario->createView(), "hobbies" => $resultHobbies));
        endif;
                
    }
    
    private function newUser(Request $request,$totalHobbies){
        
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
            $this->addFlash('messageFail', 'Debe elegir 3 hobbies');
            return $this->redirectToRoute('user_register');
        endif;

        $nacimiento =$arrayBirthdate['year']."-".$mes.'-'.$dia;

        $file = "http://www.whatwantweb.com/api_rest/user/registration/register_user.php";
        $data = array("username" => $this->usuario->getUsername(),
                      "email" => $this->usuario->getEmail(),
                      "date" => $nacimiento,
                      "password" => $this->usuario->getPassword(),
                      "prefix" => $this->usuario->getPrefix(),
                      "phone" => $this->usuario->getPhone(),
                      "hobbies" => $hobbies
            );

        $ch = new ApiRest();

        $result = $ch->resultApiRed($data,$file);
        
        $this->ut->flashMessage("register",$request,$result);
        return $result['result'];
    }


}

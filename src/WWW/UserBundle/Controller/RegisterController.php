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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use WWW\GlobalBundle\Entity\Utilities;
use WWW\GlobalBundle\MyConstants;

/**
 * Description of RegisterController
 *Matches /registro/*
 * 
 * @Route("/registro/{token}", name="user_register")
 * @author Rocio
 */
class RegisterController extends Controller{
    
    private $usuario = null;
    private $ut = null;
    
    public function registerAction(Request $request,$token){
        
        $this->usuario = new User();
        $this->ut =  new Utilities();
        
        $ch = new ApiRest();
        
        $resultHobbies = $ch->sendInformationWihoutParameters(MyConstants::PATH_APIREST."user/data/get_hobbies.php");
        $totalHobbies = count($resultHobbies);
        $formulario = $this->createForm(RegisterType::class,$this->usuario);
        
        //El usuario del formulario se asocia al objeto $usuario
        $formulario->handleRequest($request);
        
        if($formulario->isValid()):
            
            $result = $this->newUser($request, $totalHobbies);
            
            if($result == 'ok'):
                $this->ut->flashMessage('register', $request, null);
                return $this->redirectToRoute('homepage');
            else:
                return $this->render('UserBundle:Register:register.html.twig',array('formulario'=>$formulario->createView(), "hobbies" => $resultHobbies));
            endif;
            
            $nacimiento =$arrayBirthdate['year']."-".$mes.'-'.$dia;
            $this->get('app.manager.usuario_manager')->login($usuario);
            $tokenRoleUser=$this->get('security.token_storage')->getToken();
            $request->getSession()->set('tokenRole', $tokenRoleUser);
            $request->getSession()->save();
            $file = "http://www.whatwantweb.com/A67C1VY9OgkXN496HSxNYG598A3M13/api_rest/user/registration/register_user.php";
            $data = array("username" => $usuario->getUsername(),
                          "email" => $usuario->getEmail(),
                          "date" => $nacimiento,
                          "password" => $usuario->getPassword(),
                          "prefix" => $usuario->getPrefix(),
                          "phone" => $usuario->getPhone(),
                          "hobbies" => $hobbies,
+                         "token"=>$token
                );
            
            $ch = new ApiRest();
            
            $result = $ch->sendInformation($data, $file, "parameters");
            return $this->render('UserBundle:Register:register.html.twig',array('formulario'=>$formulario->createView(), "hobbies" => $resultHobbies,'token'=>$token));
        else:
            return $this->render('UserBundle:Register:register.html.twig',array('formulario'=>$formulario->createView(), "hobbies" => $resultHobbies,'token'=>$token));
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

        $role = 1;
        if(!empty($this->usuario->getNif()))
            $role = 2;
        
        $file = MyConstants::PATH_APIREST."user/registration/register_user.php";
        $data = array("username" => $this->usuario->getUsername(),
                      "email" => $this->usuario->getEmail(),
                      "date" => $nacimiento,
                      "password" => $this->usuario->getPassword(),
                      "prefix" => $this->usuario->getPrefix(),
                      "phone" => $this->usuario->getPhone(),
                      "hobbies" => $hobbies,
                      "nif" => $this->usuario->getNif(),
                      "role" => $role
            );

        $ch = new ApiRest();

        $result = $ch->resultApiRed($data,$file);
        
        $this->ut->flashMessage("register",$request,$result);
        return $result;
    }


}

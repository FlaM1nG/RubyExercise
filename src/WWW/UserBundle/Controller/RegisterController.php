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
            
            if ($result['result'] == 'ok'):
//              Aqui guardamos el usuario registrado
//              $this->get('app.manager.usuario_manager')->guardar($this->usuario);
//                $this->get('app.manager.usuario_manager')->login($this->usuario);
                $this->ut->flashMessage('register', $request, null);

                return $this->redirectToRoute('prueba_validation');
                //return $this->forward('UserBundle:Login:login');
               // return $this->render('UserBundle:Default:login.html.twig',array('formulario'=>$formulario->createView()));
            else:
                return $this->render('UserBundle:Register:register.html.twig',array('formulario'=>$formulario->createView(), "hobbies" => $resultHobbies));
            endif;
                      

            $ch = new ApiRest();
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


    public function validationPhoneAction(Request $request){

        if(!empty($request->request->all())):
            $result = $this->validateCode($request);
        
            if($result == 'ok'):
                $this->redirectToRoute('user_resultValidation',array('resultConfirm' => 1));
            else:
                $session = $request->getSession();
                if(!$session->has('numIntento') && !$session->has('numSendSMS')):
                    $session->set('numIntento', 1);
                    $session->set('numSendSMS',1);

                else:
                    $session->set('numIntento', $session->get('numSMS')+1);
                    $session->set('numSendSMS', $session->get('numSendSMS')+1);
                endif;

                if($session->get('numSendSMS') > 3):
                    return $this->redirectToRoute('user_validationPhone',array('resultConfirm' => 2));
                endif;

            endif;    
        endif;

        return $this->render('UserBundle:Validation:validation.html.twig');
    }

    private function validateCode(Request $request){
        $file = MyConstants::PATH_APIREST."user/phone/confirm_sms.php";
        $ch = new ApiRest();

        $data['username'] = $request->getSession()->get('username');
        $data['id'] = $request->getSession()->get('id');
        $data['password'] = $request->getSession()->get('password');
        $data['token'] = $request->get('token');
        
        $result = $ch->resultApiRed($data,$file);
        
        return $result['result'];
    }
    
    public function resultValidationAction(Request $request){

        $resultConfirm = $request->get('resultConfirm');

        if($resultConfirm == 1):
            return $this->render('UserBundle:Validation:validationTrue.html.twig');
        elseif($resultConfirm == 2):
            return $this->render('UserBundle:Validation:validationFalse.html.twig');
        endif;
    }

    private function sendConfirmationCodeAction(Request $request){

        $file = MyConstants::PATH_APIREST.'user/phone/send_sms.php';
        $ch = new ApiRest();

        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');

        $result = $ch->resultApiRed($data,$file);

        $response = new JsonResponse();

        $response->setData(array('result' => 'ok',
                                 'message' => 'Se le ha enviado un mensaje nuevo con el código que debe introducir'));

        return $response;
    }
}

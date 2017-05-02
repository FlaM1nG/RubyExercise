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
use WWW\UserBundle\Form\ConfirmCodePhoneType;
use WWW\UserBundle\Form\ProfilePhoneType;
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

        $formulario->handleRequest($request);
        
        if($formulario->isSubmitted() AND $formulario->isValid()):
            //el sms se envía solo
            $result = $this->newUser($request, $totalHobbies);

            if ($result['result'] == 'ok'):

                $this->saveSessionUser($request, $result);
//                return $this->redirectToRoute('user_registerConfirmPhone');
                return $this->render('UserBundle:Register:registerSuccessfull.html.twig');
            else:
                return $this->render('UserBundle:Register:register.html.twig',array('formulario'=>$formulario->createView(), "hobbies" => $resultHobbies));
            endif;

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

    public function saveSessionUser(Request $request, $result){

        $session = $request->getSession();

        $session->set("id",$result['id']);
        $session->set("username",$result['username']);
        $session->set("password",$result['password']);
//        $session->set('phone', $this->usuario->getPhone());

    }

    public function confirmPhoneAction(Request $request){

        $numTried = null;
        $numSMS = null;
        $timeTried = null;
        $timeSMS = null;

        $resultUnconfirmePhones = $this->unconfirmedPhones($request);

        $phoneNew = $resultUnconfirmePhones['phones'][sizeof($resultUnconfirmePhones['phones'])-1]['phone'];

        $this->getInfoTriedSMS($request, $numTried, $numSMS, $timeTried, $timeSMS);
//        $arrayTried = $this->getTried($request);
//        $numTried = $arrayTried['phone_attempt_num'];
//        $numSMS = $arrayTried['confirm_sms_num'];
//
//        if(array_key_exists('phone_attempt_date', $arrayTried)):
//            $timeTried = $this->calculateTimeNewTried($arrayTried['phone_attempt_date']['date']);
//        endif;
//
//        if(array_key_exists('confirm_sms_date', $arrayTried)):
//            $timeSMS = $this->calculteTimeNewSMS($arrayTried['confirm_sms_date']['date']);
//        endif;

        $form = $this->createForm(ConfirmCodePhoneType::class,null,array('sendSMS' => $numSMS, 'tried' => $numTried));

        $form->handleRequest($request);

        if($form->isSubmitted()):

            if( $form->get('confirmPhone')->isClicked()):
                //el usuario ha enviado el código
                $result = $this->confirmPhone($request);

                if($result == 'ok'):
                    return $this->redirectToRoute('user_login');
                else:
                    $timeTried --;
                    if($timeTried == 0):
                        $this->getInfoTriedSMS($request, $numTried, $numSMS, $timeTried, $timeSMS);
                        $form = $this->createForm(ConfirmCodePhoneType::class,null,array('sendSMS' => $numSMS, 'tried' => $numTried));
                    endif;
                endif;

            elseif( $form->get('sendSMS')->isClicked()):
                $request->getSession()->set('newCode','1');
                return $this->redirectToRoute('user_registerNewSMS');

            endif;

        endif;


        
        return $this->render('UserBundle:validation:validation.html.twig',array(
                             'newPhone' => $phoneNew,
                             'form' => $form->createView(),
                             'numTried' => $numTried,
                             'numSMS' => $numSMS,
                             'timeTried' => $timeTried,
                             'timeSMS' => $timeSMS
        ));


    }

    private function unconfirmedPhones(Request $request){

        $ch = new ApiRest();
        $file =  MyConstants::PATH_APIREST."user/phone/unconfirmed_phones.php";

        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');

        $result = $ch->resultApiRed($data, $file);

        return $result;
    }

    private function getInfoTriedSMS(Request $request, &$numTried, &$numSMS, &$timeTried, &$timeSMS){

        $arrayTried = $this->getTried($request);
        $numTried = $arrayTried['phone_attempt_num'];
        $numSMS = $arrayTried['confirm_sms_num'];

        if(array_key_exists('phone_attempt_date', $arrayTried)):
            $timeTried = $this->calculateTimeNewTried($arrayTried['phone_attempt_date']['date']);
        endif;

        if(array_key_exists('confirm_sms_date', $arrayTried)):
            $timeSMS = $this->calculteTimeNewSMS($arrayTried['confirm_sms_date']['date']);
        endif;
    }

    private function getTried(Request $request){

        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST."user/phone/get_times.php";

        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');

        $result = $ch->resultApiRed($data, $file);

        return $result;

    }

    private function confirmPhone(Request $request){

        $ut = new Utilities();
        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST."user/phone/confirm_sms.php";

        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        $data['token'] = $request->get('profilePhone')['codConfirmation'];

        $result = $ch->resultApiRed($data, $file);

        $ut->flashMessage("Número confirmado", $request, $result, "Código no válido o expirado");

        return $result['result'];
    }

    public function newPhoneAction(Request $request){

        $user = new User();
        $sendSMS = null;
        

        if(empty($request->getSession()->get('newCode'))):
            $sendSMS = 1;
        else:
            $request->getSession()->remove('newCode');
        endif;
        
        $form = $this->createForm(ProfilePhoneType::class, $user, array('sendSMS' => $sendSMS));

        $form->handleRequest($request);

        if($form->isSubmitted()):
            //Envio un mensaje nuevo
            $result = $this->sendNewSMS($request);

            if($result['result'] == 'ok'):
                return $this->redirectToRoute('user_registerConfirmPhone');
            endif;
        endif;

        return $this->render('UserBundle:Register:newPhoneCode.html.twig', array(
                             'formulario' => $form->createView()
        ));
    }

    public function sendNewSMS(Request $request){

        $file = MyConstants::PATH_APIREST.'user/phone/send_sms.php';
        $ch = new ApiRest();

        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        $data['prefix'] = $request->get('profileNewCodePhone')['prefix'];
        $data['phone'] = $request->get('profileNewCodePhone')['phone'];

        $result = $ch->resultApiRed($data, $file);

        return $result;

    }

    private function calculateTimeNewTried($hora){

        $fecha =  \DateTime::createFromFormat('Y-m-d H:i:s.u',$hora);
        $fecha->modify('+1 hour');
        $horaFinal = $fecha->format('H:i:s');

        $horaInicial = (new \DateTime('now'))->format('H:i:s');

        $horai = substr($horaInicial,0,2);
        $mini = substr($horaInicial,3,2);
        $segi = substr($horaInicial,6,2);

        $horaf = substr($horaFinal,0,2);
        $minf = substr($horaFinal,3,2);
        $segf = substr($horaFinal,6,2);

        $ini = ((($horai*60)*60)+($mini*60)+$segi);
        $fin = ((($horaf*60)*60)+($minf*60)+$segf);

        $dif = $fin-$ini;

        $difh = floor($dif/3600);
        $difm = floor(($dif-($difh*3600))/60);
        $difs = $dif-($difm*60)-($difh*3600);

        $resultado = date("H:i",mktime($difh,$difm));

        return $resultado;
    }

    private function calculteTimeNewSMS($time){

        $fecha = \DateTime::createFromFormat('Y-m-d H:i:s.u', $time);
        $fecha->modify('+1 month');

        $fechaActual = new \DateTime('now');
        $interval = $fechaActual->diff($fecha);

        return $interval->format('%d días %h horas y %i minutos');

    }

}
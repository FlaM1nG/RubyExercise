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
use WWW\UserBundle\Form\ProfilePhoneType;
use WWW\UserBundle\Form\ConfirmCodePhoneType;
use WWW\UserBundle\Entity\User;

/**
 * Description of ProfilePhoneController
 *
 * @author Rocio
 */
class ProfilePhoneController extends Controller{
    
    public function profilePhoneAction(Request $request){
        
        return $this->render('UserBundle:Profile:phoneProfile.html.twig');
    }
    
    public function profileChangePhoneAction(Request $request){

        $arrayPhones = null;
        $form = null;
        
        $result = $this->getInfoPhone($request);
        $arrayPhones = $result['phones'];

        if(empty($arrayPhones)):

            $user = new User();

            $form = $this->createForm(ProfilePhoneType::class, $user);

            $form->handleRequest($request);

            if($form->isSubmitted()):
                $result = $this->changePhone($request, $user);
                if($result == 'ok'):
                    return $this->redirectToRoute("user_profileConfirmPhone");
                endif;
            endif; 
            
            return $this->render("UserBundle:Profile:changePhoneProfile.html.twig",
                array('form' => $form->createView()));

        else:
            return $this->redirectToRoute('user_profileConfirmPhone');
        endif;


    }

    private function getInfoPhone(Request $request){

        $ch = new ApiRest();
        $file =  MyConstants::PATH_APIREST."user/phone/unconfirmed_phones.php";

        $data['id'] = $this->getUser()->getId();
        $data['username'] = $this->getUser()->getUsername();
        $data['password'] = $request->getSession()->get('password');

        $result = $ch->resultApiRed($data, $file);


        return $result;
    }

    private function changePhone(Request $request, User $user){
                
//        $ut = new Utilities();
        $file = MyConstants::PATH_APIREST."user/phone/send_sms.php";
        $ch = new ApiRest();
        
        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        $data['phone'] = $user->getPhone();
        $data['prefix'] = $user->getPrefix();
        
        $result = $ch->resultApiRed($data, $file);
        return ($result['result']);

//        $ut->flashMessage("general", $request, $result);
        
    }
    
    public function confirmCodeAction(Request $request){

        $result = $this->getInfoPhone($request);
        $arrayPhones = $result['phones'];

        $infoTried = $this->getTried($request);
        $timeNewTried = null;
        $timeNewSMS = null;
        
        $ut = new Utilities();

        if(array_key_exists('phone_attempt_date', $infoTried)):
            $timeNewTried = $this->calculateTimeNewTried($infoTried['phone_attempt_date']['date']);
            $result['result'] = 'ko';
            $ut->flashMessage("",$request,$result,'Puede volver a intentarlo en '.$timeNewTried.' minutos');
        endif;

        if(array_key_exists('confirm_sms_date',$infoTried)):
            $timeNewSMS = $this->calculteTimeNewSMS($infoTried['confirm_sms_date']['date']);
            $result['result'] = 'ko';
            $ut->flashMessage("",$request,$result,'Puede solicitar un nuevo sms en '.$timeNewSMS);
        endif;

        $form = $this->createForm(ConfirmCodePhoneType::class,null,array('sendSMS' =>$timeNewSMS));
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->get('confirmPhone')->isClicked()):

            $result = $this->confirmPhone($request);

            if($result == 'ok'):
                return $this->render('user_profilePhone');
            endif;
        elseif($form->isSubmitted() AND $form->get('sendSMS')->isClicked()):
            return $this->redirectToRoute('user_profileChangePhone');

        endif;
        
        return $this->render('UserBundle:Profile:confirmPhone.html.twig',
                       array('form' => $form->createView(),
                             'infoTried' => $infoTried,
                             'timeNewTried' => $timeNewTried,
                             'timeNewSMS' => $timeNewSMS,
                             'phone' => $arrayPhones[sizeof($arrayPhones)-1]['phone']));
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
        
        $data['id'] = $this->getUser()->getId();
        $data['username'] = $this->getUser()->getUsername();
        $data['password'] = $request->getSession()->get('password');
        $data['token'] = $request->get('profilePhone')['codConfirmation'];
        
        $result = $ch->resultApiRed($data, $file);

        $ut->flashMessage("Número confirmado", $request, $result, "Código no válido o expirado");
        
        return $result['result'];
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

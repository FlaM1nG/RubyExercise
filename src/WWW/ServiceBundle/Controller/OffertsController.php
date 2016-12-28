<?php

namespace WWW\ServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WWW\GlobalBundle\Entity\ApiRest;

class OffertsController extends Controller{
    
    private $usuario = null;
    private $session = null;
    
    public function showOffertsAction(Request $request){
        
        $this->session = $request->getSession();
      
        /*$ch = new ApiRest();
        
        $file = "http://www.whatwantweb.com/api_rest/user/data/get_info_user.php";
        $arrayData = array("username" => $this->session->get('username'),
                           "id" => $this->session->get('id'),
                           "password" => $this->session->get('password'));
        
        $result = $ch->resultApiRed($arrayData, $file);
        
        if($result['result'] == 'ok'):
            
            $this->usuario = new User($result);
        
            if($this->usuario->getAddresses()->isEmpty()):
                $address = new Address();
                $this->usuario->addAddress($address);
            endif;
        
            $formPersonal = $this->createForm(ProfilePersonalType::class,$this->usuario);
           
            if($request->getMethod()=="POST"):
                
                
            endif;
           
        endif;
        
        $formPersonal = $this->createForm(ProfilePersonalType::class,$this->usuario);
        
        */
        return $this->render('UserBundle:Default:profile.html.twig',
                array('formPersonal'=>$formPersonal->createView(),
                      'usuario'=>$this->usuario));
    }
}

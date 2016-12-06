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
use WWW\GlobalBundle\Entity\Address;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\UserBundle\Form\ProfilePersonalType;
use WWW\UserBundle\Form\ProfileAddressType;
use WWW\UserBundle\Form\ProfileBankType;
use WWW\UserBundle\Form\ProfileEmailType;
use WWW\UserBundle\Form\ProfilePasswordType;
use WWW\UserBundle\Form\ProfilePhoneType;
use WWW\UserBundle\Form\ProfilePhotoType;


/**
 * Description of ProfileController
 *
 * @author Rocio
 */
class ProfileController extends Controller{
    
    private $usuario = null;
    private $session = null;
    private $dataProfile = null;
    private $sectionActive = null;
    
    public function profileAction(Request $request){ 
        
        $this->session = $request->getSession();
      
        $ch = new ApiRest();
        
        $file = "http://www.whatwantweb.com/api_rest/user/data/get_info_user.php";
        $arrayData = array("username" => $this->session->get('username'),
                           "id" => $this->session->get('id'),
                           "password" => $this->session->get('password'));
        
        $result = $ch->sendInformation($arrayData, $file, "parameters");
 
        if($result['result'] == 'ok'):
            
            $this->usuario = new User($result);
        
            if($this->usuario->getAddresses()->isEmpty()):
                $address = new Address();
                $this->usuario->addAddress($address);
            endif;
        
            $formPersonal = $this->createForm(ProfilePersonalType::class,$this->usuario);
            $formEmail = $this->createForm(ProfileEmailType::class,$this->usuario);
            $formPassword = $this->createForm(ProfilePasswordType::class,$this->usuario);
            $formPhone = $this->createForm(ProfilePhoneType::class,$this->usuario);
            $formPhoto = $this->createForm(ProfilePhotoType::class,$this->usuario);
            $formAddress = $this->createForm(ProfileAddressType::class,$this->usuario);
            $formBank = $this->createForm(ProfileBankType::class,$this->usuario);
        
            if($request->getMethod()=="POST"):
                
                $this->dataProfile = $request->request->all()['profileUser'];
                $section = $this->dataProfile['section'];
                
                if($section == 'personal'):
                    $formPersonal->handleRequest($request);
                    
                    $this->sectionActive = 'personal';
                    $this->updateProfile();
                    
                elseif($section == 'email'):
                    $this->sectionActive = 'email';
                    $this->changeEmail();
                elseif($section == 'password'):
                    $this->sectionActive ='password';
                    $this->changePassword();
     
                elseif($section == 'phone'):
                    $this->sectionActive = 'phone';
                    $this->changePhone($request);
                elseif($section == 'photo'):
                    $this->sectionActive = 'photo';
                    $this->changePhoto();
                elseif($section == 'address'):
                    $this->sectionActive = 'address';
                    $this->profileAddress($request);
                elseif($section == 'bank'):
                    $this->sectionActive = 'bank';
                    $this->changeBank();
                endif;
              
            endif;
           
        endif;
        
        $formPersonal = $this->createForm(ProfilePersonalType::class,$this->usuario);
        $formEmail = $this->createForm(ProfileEmailType::class,$this->usuario);
        $formPassword = $this->createForm(ProfilePasswordType::class,$this->usuario);
        $formPhone = $this->createForm(ProfilePhoneType::class,$this->usuario);
        $formPhoto = $this->createForm(ProfilePhotoType::class,$this->usuario);
        $formAddress = $this->createForm(ProfileAddressType::class,$this->usuario);
        $formBank = $this->createForm(ProfileBankType::class,$this->usuario);
        
        return $this->render('UserBundle:Default:profile.html.twig',
                array('formPersonal'=>$formPersonal->createView(),
                      'formEmail'=>$formEmail->createView(),
                      'formPassword'=>$formPassword->createView(),
                      'formPhone'=>$formPhone->createView(),
                      'formPhoto'=>$formPhoto->createView(),
                      'formAddress'=>$formAddress->createView(),
                      'formBank'=>$formBank->createView(),
                      'usuario'=>$this->usuario,
                      'tabActive' => $this->sectionActive));
    }
    
        
    private function updateProfile(){
        $fecha = $this->dataProfile['birthdate']['year'].'-'.$this->dataProfile['birthdate']['month'].'-'.$this->dataProfile['birthdate']['day'];

        $date = \DateTime::createFromFormat('Y-m-d', $fecha);
        
        if($date < new\DateTime('today - 18 years')):
            
            $ch = new ApiRest();
        
            $file = "http://www.whatwantweb.com/api_rest/user/data/update_user.php";

            $data = array();
            $data['username']=$this->usuario->getUsername();
            $data['id']=$this->usuario->getId();
            $data['password']=$this->usuario->getPassword();
            
            $data['name']="'".$this->dataProfile['name']."'";
            $data['surname']="'".$this->dataProfile['surname']."'";
            $data['birthdate'] = $fecha;
            $data['sex'] = "'".$this->dataProfile['sex']."'";

            $informacion['data'] = json_encode($data); 
            $result = $ch->resultApiRed($informacion, $file);
            
            $this->flashMessageGeneral($result['result']);
            
            if($result['result'] == "ok"):
            
                foreach($data as $key => $value):

                    if($key != "id"):
                        $aux = str_replace("_", "", $key);
                        $aux = "set".ucwords($aux);

                        if($key != 'birthdate'):    
                            //Al forma el array algunos datos se les añade comillas x lo que hay que quitarlas
                            if($value[0] == "'"):
                                $value = substr($value,1);
                                $value = substr($value,0,-1);
                            endif;
                        else:
                        $value = \DateTime::createFromFormat('Y-m-d', $fecha);

                        endif;    
                        $this->usuario->$aux($value);
                    endif;    

                endforeach;
            endif;
        else:
            $this->addFlash('messageFail','Fecha no válida, debe ser mayor de edad');
        endif;
       
    }
    
    private function changeEmail(){
        
        if($this->dataProfile['email']['first'] == $this->dataProfile['email']['second']):
            
            $file = "http://www.whatwantweb.com/api_rest/user/email/change_email.php";
            $data = array('username' => $this->usuario->getUsername(),
                          'id' =>$this->usuario->getId(),
                          'password' =>$this->dataProfile['password'],
                          'email' => $this->dataProfile['email']['first'] );

            $ch = new ApiRest();

            $result = $ch->resultApiRed($data,$file);
       
            if($result['result'] == "ok"):
                $this->usuario->setEmail($data['email']);

            endif;
            $this->flashMessageGeneral($result['result']);
        else:
            $this->addFlash('messageFail','Email no válido');
        endif;
        
        
    }
    
    private function profileAddress(Request $request){
       //print_r($request);
       
       if(array_key_exists('newAddress', $request->request->all()) ||
         (array_key_exists('saveAddress',$request->request->all()) &&
         !array_key_exists('posArrayAddress',$request->request->all()))):
           //guardar una dirección nueva
           $this->addAddress($request);
       
       elseif(array_key_exists('saveAddress', $request->request->all())):
           //modificar una dirección existente
            $this->updateAddress( $request);
           
       elseif(array_key_exists('eliminar', $request->request->all())):
           //eliminar dirección
           $this->deleteAddress($request);
       endif;
  
    }
    
    private function updateAddress(Request $request){
        
        $arrayAdress = $request->request->all()['profileUser']['addresses'];
        $posArrayAddress = $request->request->all()['idChangeAddress'];
        
        $ch = new ApiRest();
        $file = "http://www.whatwantweb.com/api_rest/user/addresses/update_address.php";
        
        $data = array();
        $data['username']=$this->usuario->getUsername();
        $data['id_user']=$this->usuario->getId();
        $data['password']=$this->usuario->getPassword();
        $data['id'] = $arrayAdress[$posArrayAddress]['id'];
        $data['name'] = "'".$arrayAdress[$posArrayAddress]['name']."'";
        $data['street'] = "'".$arrayAdress[$posArrayAddress]['street']."'";
        
        if(array_key_exists('isDefault',$arrayAdress[$posArrayAddress]))
            $data['is_default'] = 1;
        else
            $data['is_default'] = 0;

        $informacion['data'] = json_encode($data);
        $result = $ch->resultApiRed($informacion, $file);

        if($result['result'] == 'ok'):
            $this->updateAddressFormUser($data, $posArrayAddress);
            $this->flashMessageGeneral($result['result']);
        endif;
               
    }
    
    private function deleteAddress(Request $request){

        $arrayAdress = $this->dataProfile['addresses'];
        $posArrayAddress = $request->request->all()['idDeleteAddress'];
        
        $ch = new ApiRest();
        $file = "http://www.whatwantweb.com/api_rest/user/addresses/delete_address.php";
            
        $data = array("username" => $this->usuario->getUsername(),
                      "password" => $this->usuario->getPassword(),
                      "id_user" => $this->usuario->getId(),
                      "id" => $arrayAdress[$posArrayAddress]['id']);
        
        $result = $ch->resultApiRed($data, $file);
        
        if($result['result'] == 'ok'):
            $this->usuario->deleteAddress($posArrayAddress);
        
            if(count($this->usuario->getAddresses()) == 0):
                $address = new Address();
                $this->usuario->addAddress($address);
            endif;
            
            $this->flashMessageGeneral($result['result']);
        endif;
    }
    
    private function addAddress(Request $request){
     
        $newAddress = new Address();
        
        $address = $this->dataProfile['addresses'];
        $data['username'] = $this->usuario->getUsername();
        $data['id_user'] = $this->usuario->getId();
        $data['password'] =$this->usuario->getPassword();
        
        if(!array_key_exists('posArrayAddress',$request->request->all())):
            //Dirección cuando no existe ninguna
            
            $data['name'] = "'".$address[0]["name"]."'";
            $data['street'] = "'".$address[0]["street"]."'";
            $data['zipcode_id'] = 1;
            
            if(array_key_exists('isDefault',$address[0])):
                $data['is_default'] = 1;
            else:
                $data['is_default'] = 0;
            endif;
            
            unset($this->usuario->getAddresses()[0]);
            
        else: 
            //Nueva dirección cuando ya existen direcciones
            $data['name'] = "'".$request->request->all()['nameNewAddress']."'";
            $data['street'] = "'".$request->request->all()["streetNewAddress"]."'";
            $data['zipcode_id'] = 1;
            if(array_key_exists('isDefaultNewAddress',$request->request->all()))
                $data['is_default'] = 1;
            else 
                $data['is_default'] = 0;
        endif; 
       
        $ch = new ApiRest();
        $file = "http://www.whatwantweb.com/api_rest/user/addresses/insert_address.php";
        
        $result = $ch->sendInformation($data, $file, "json");
        
        if($result['result'] == 'ok'):
           $this->flashMessageGeneral($result['result']);
           $this->updateAddressFormUser($data, $result['id']); 
        endif;

    }
    
    private function updateAddressFormUser(Array $data, $id){

        $aux = null;
        
        foreach($data as $key => $value):
            if($key != "username" && $key != "id_user" && $key != "password" && $key != "is_default"):
                    //Al forma el array algunos datos se les añade comillas x lo que hay que quitarlas
                if($value[0] == "'"):
                    $value = substr($value,1);
                    $value = substr($value,0,-1);
                endif;
                $aux[$key] = $value;
            endif;    
        endforeach;
        
        $aux['zipcode_id'] = 1;
        $aux['id'] = $id;
        
        if($data['is_default'] == 1)
            $aux['isDefault'] = true;
        else $aux['isDefault'] = false;
        
        $this->usuario->getAddresses()[$id] = $aux;
    }
    
    private function changePassword(){
        
        $ch = new ApiRest();
        $file = "http://www.whatwantweb.com/api_rest/user/passwords/change_password.php";
        
        if($this->dataProfile['password']['first'] == $this->dataProfile['password']['second']):
            
            $id = $this->usuario->getId();
            $username = $this->usuario->getUsername();
            $oldPassword = $this->dataProfile['oldPassword'];
            $newPassword = $this->dataProfile['password']['first'];

            $data = array("username" => $username,
                          "old_password" => $oldPassword,
                          "new_password" => $newPassword,
                          "id" => $id);

            $result = $ch->resultApiRed($data, $file);
            $this->flashMessageGeneral($result['result']);
        else:
            $this->addFlash('messageFail','Las contraseñas deben ser iguales');
        endif;    
    }
    
    private function confirmCodePhone(){
        
        $file = "http://www.whatwantweb.com/api_rest/user/phone/send_sms";

        $data = array('username' => $this->usuario->getUsername(),
                          'id' => $this->usuario->getId(),
                          'password' => $this->usuario->getPassword(),
                          'phone' => $this->dataProfile['phone'],
                          'prefix' => $this->dataProfile['prefix']);

        $ch = new ApiRest();
        $result = $ch->resultApiRed($data, $file);
        
        $this->flashMessageGeneral($result['result']);
    }
    
    private function changeBank(){
        
        $file = "http://www.whatwantweb.com/api_rest/user/data/update_user.php";
        
        $data['username']=$this->usuario->getUsername();
        $data['id']=$this->usuario->getId();
        $data['password']=$this->usuario->getPassword();
        $data['num_account'] = "'".$this->dataProfile['num_account']."'";
        $informacion['data'] = json_encode($data); 
        
        $ch = new ApiRest();
        $result = $ch->resultApiRed($informacion, $file);
        
        $this->flashMessageGeneral($result['result']);
    }
    
    private function changePhone(){
        
        if(empty($this->dataProfile['codConfirmation']) ||
            array_key_exists("confirmPhone", $this->dataProfile)):    
            
            $this->confirmCodePhone();
   
        elseif(!empty($this->dataProfile['codConfirmation'])):
            
            $file = "http://www.whatwantweb.com/api_rest/user/phone/confirm_sms";
            $data = array('username' => $this->usuario->getUsername(),
                          'id' => $this->usuario->getId(),
                          'password' => $this->usuario->getPassword(),
                          'token' => $this->dataProfile['codConfirmation']);
            
            $ch = new ApiRest();
            $result = $ch->resultApiRed($data, $file);
            
            if($result['result'] == 'ok'):
                $this->usuario->setSmsConfirmed(1);
                
                $this->usuario->setPhone($result['phone']);
                $this->usuario->setPrefix($result['prefix']);
            endif;

        endif;
         
        
    }
    
    private function changePhoto(Request $request){
        echo "cambio foto";
        $file = "http://www.whatwantweb.com/api_rest/global/photo/add_photos.php";
        
        $dataFiles = $request->files->all()['profileUser']['photo'];
        $fileUpload = "http://www.whatwantweb.com/img/user_".$this->usuario->getId()."/profile/perfil";
        
        $typePhoto = $request->files->all()['profileUser']['photo']->getMimeType();
        $name = $dataFiles->getClientOriginalName();
        $tmpName = $dataFiles->getPathname();
        $extension = $dataFiles->getClientoriginalExtension();
        
        
        if(strstr($typePhoto,"image") === false){
            echo "error";
        }
        $carpeta = "http://www.whatwantweb.com/img/profile";
        $target_path = "http://www.whatwantweb.com/img/profile";
        $directorio = "http://www.whatwantweb.com/img/profile"; // directorio de tu elección
            
        // almacenar imagen en el servidor
        move_uploaded_file($tmpName,'http://www.whatwantweb.com/img/profile/'.$this->usuario->getId().$extension);
   
    }
    
    private function flashMessageGeneral($result){
        
        if($result == 'ok'):
            $this->addFlash('messageSuccess','Datos actualizados correctamente');
        else:
            $this->addFlash('messageFail','Error al actualizar');
        endif;
    }
}

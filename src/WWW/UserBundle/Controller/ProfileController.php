<?php

namespace WWW\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WWW\UserBundle\Entity\User as User;
use WWW\UserBundle\Entity\Role;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\UserBundle\Form\ProfilePersonalDataType;
use WWW\UserBundle\Form\ProfileEmailType;
use WWW\UserBundle\Form\ProfilePasswordType;
use WWW\UserBundle\Form\ProfilePhoneType;
use WWW\UserBundle\Form\ProfilePhotoType;
use WWW\UserBundle\Form\ProfileAddressesType;
use WWW\UserBundle\Form\ProfileBankType;
use Doctrine\Common\Util\Inflector as Inflector;
use WWW\GlobalBundle\Entity\Utilities;
use WWW\ServiceBundle\Entity\Offer;

class ProfileController extends Controller{
    
    private $user = null;
    private $session = null;
    private $tabActive = 'myMessage';
    private $ut;
    private $email = "";
    
    
    public function profileAction(Request $request){ 
        
        $this->sesion = $request->getSession();
        $this->tabActive = 'myMessage';
        $this->ut = new Utilities();
        
        $this->user = new User();
        $this->getUserExist($request);
        
        
        $formPersonalData = $this->createForm(ProfilePersonalDataType::class,$this->user); 
        $formEmail = $this->createForm(ProfileEmailType::class,$this->user);
        $formPassword = $this->createForm(ProfilePasswordType::class,$this->user);
        $formPhone = $this->createForm(ProfilePhoneType::class,$this->user);
        $formPhoto = $this->createForm(ProfilePhotoType::class,$this->user);
        $formAddresses = $this->createForm(ProfileAddressesType::class,$this->user);
        $formBank = $this->createForm(ProfileBankType::class,$this->user);
        
        $formPersonalData->handleRequest($request);
        $formEmail->handleRequest($request);
        $formPassword->handleRequest($request);
        $formPhone->handleRequest($request);
        $formPhoto->handleRequest($request);
        $formAddresses->handleRequest($request);
        $formBank->handleRequest($request);        
        
        if($formPersonalData->isSubmitted()):
            $this->tabActive = 'personal';
        
            if($formPersonalData->isValid()):
                $this->savePersonalData($request);
            endif;
        elseif($formEmail->isSubmitted()):
            $this->tabActive = 'email';
        
            if($formEmail->isValid()):
                $this->saveEmail($request);
            endif;
        elseif($formPassword->isSubmitted()):
            $this->tabActive = 'password';
        
            if($formPassword->isValid()):
                $this->savePassword($request);
            endif;
        elseif($formPhone->isSubmitted()):
            $this->tabActive = 'phone';
        
            if($formPhone->isValid()):
                if($formPhone->get('savePhone')->isClicked()):
                        //envia email para confirmar
                        $this->sendSMS($request);

                elseif($formPhone->get('confirmPhone')->isClicked()):
                        //guarda el móvil después de introducir el código de confirmación
                        $this->savePhone($request);
                endif;
            endif;
        elseif($formPhoto->isSubmitted()):
            $this->tabActive = 'photo';
        
            if($formPhoto->isValid()):
                $this->savePhoto($request);
            endif;
        elseif($formBank->isSubmitted()):
            $this->tabActive = 'bank';
        
            if($formBank->isValid()):
                $this->saveBank($request);
            endif;
            
        elseif($formAddresses->isSubmitted()):
            $this->tabActive = 'addresses';
            echo "estoy en Address<br>";
            if($formAddresses->isValid()):
                echo "formAddress validado<br>";
                if($formAddresses->get('addAddress')->isClicked()): 
                    echo "pinchada nuevaDirección<br>";
                    $this->newAddresses($request);
                elseif($formAddresses->get('deleteAddresses')->isClicked()):
                    echo "pincho borrar<br>";
                    $this->deleteAddresses($request);
                    $formAddresses = $this->createForm(ProfileAddressesType::class,$this->user); 
                else: 
                    echo "actualizo dirección <br>";
                    $this->updateAddresses($request);
                endif;
            endif;    
        endif;    

        return $this->render('UserBundle:Profile:indexProfile.html.twig',
                             array('formPersonalData'=>$formPersonalData->createView(),
                                   'formEmail'=>$formEmail->createView(),
                                   'formPassword'=>$formPassword->createView(),
                                   'formPhone'=>$formPhone->createView(),
                                   'formPhoto'=>$formPhoto->createView(),
                                   'formAddresses'=>$formAddresses->createView(),
                                   'formBank'=>$formBank->createView(), 
                                   'usuario' => $this->user,
                                   'email' => $this->email, 
                                   'tabActive' => $this->tabActive));
        
    }    
    
    private function getUserExist(Request $request){
        
        $this->session = $request->getSession();
      
        $ch = new ApiRest();
        
        $file = "http://www.whatwantweb.com/api_rest/user/data/get_info_user.php";
        $arrayData = array("username" => $this->session->get('username'),
                           "id" => $this->session->get('id'),
                           "password" => $this->session->get('password'));
        
        $result = $ch->sendInformation($arrayData, $file, "parameters");
        //print_r($result);
        if($result['result'] == 'ok')
            $this->fillUser($result);
        
        return $result;
 
    }
    
    private function fillUser($result){
        
        foreach($result as $key => $value):
            
            $key = Inflector::camelize($key);
            $function = "set".ucwords($key);
            
            if($key == 'birthdate') 
                $value = \DateTime::createFromFormat('Y-m-d', $value);
        
            if($key != 'addresses' && $key != 'role' && $key!= 'hobbies' && 
               $key != 'id' && $key != 'inviteds' && $key != 'invit_num' &&     
               property_exists('WWW\UserBundle\Entity\User',$key)):
                
                $this->user->$function($value);
            endif;    
            
            if($key == 'addresses'):
                foreach($value as $arrayAddress):
                    $this->user->addAddress($arrayAddress);
                    
                endforeach;
            endif;
                
            $role = new Role($result['role']);
            $this->user->setRole($role);
        endforeach;
        $this->email = $this->user->getEmail();
        $this->searchOffers();
    }
    
    private function searchOffers(){
        
        $file = 'http://www.whatwantweb.com/api_rest/services/offer/get_all_user_offers.php';
        $ch = new ApiRest();
        $arrayOffers = array();
        
        $data = array();
        $data['username'] = $this->session->get('username');
        $data['id'] = $this->session->get('id');
        $data['password'] = $this->session->get('password');
        
        $result = $ch->resultApiRed($data, $file);
        
        if(!empty($result['offers'])):
            foreach($result['offers'] as $array):
                $offer = new Offer($array);
                array_push($arrayOffers, $offer);
            endforeach;

            $this->user->setOffers($arrayOffers);
        endif;    
    }
    
    private function savePersonalData(Request $request){
        
        $this->tabActive = "personal";
        $fecha = $this->user->getBirthdate();
        
        if($fecha < new\DateTime('today - 18 years')):
            $fecha = $fecha->format('Y-m-d');
            $ch = new ApiRest();
        
            $file = "http://www.whatwantweb.com/api_rest/user/data/update_user.php";

            $data = array();
            $data['username'] = $this->session->get('username');
            $data['id'] = $this->session->get('id');
            $data['password'] = $this->session->get('password');
            
            $data['name']="'".$this->user->getName()."'";
            $data['surname']="'".$this->user->getSurname()."'";
            $data['birthdate'] = $fecha;
            $data['sex'] = "'".$this->user->getSex()."'";
            $data['nif'] = "'".$this->user->getNif()."'";
            $informacion['data'] = json_encode($data); 
            
            $result = $ch->resultApiRed($informacion, $file);
           
            $this->ut->flashMessage("general", $request, $result);
        endif;
       
    }
    
    private function saveEmail(Request $request){
        $this->tabActive = 'email';
        
        $file = "http://www.whatwantweb.com/api_rest/user/email/change_email.php";
        $data = array('username' => $this->session->get('username'),
                      'id' =>$this->session->get('id'),
                      'password' =>$this->user->getPasswordEnClaro(),
                      'email' => $this->user->getEmail());

        $ch = new ApiRest();

        $result = $ch->resultApiRed($data,$file);
       
        if($result['result'] == "ok"):
            $this->email = $this->user->getEmail();
        endif;
        
        $this->ut->flashMessage("general", $request,$result);
    }
    
    private function savePassword(Request $request){
        
        $this->tabActive = 'password';
        
        $ch = new ApiRest();
        $file = "http://www.whatwantweb.com/api_rest/user/passwords/change_password.php";

        $data = array("username" => $this->session->get('username'),
                      "old_password" => $this->user->getPasswordEnClaro(),
                      "new_password" => $this->user->getPassword(),
                      "id" => $this->session->get('id'));

        $result = $ch->resultApiRed($data, $file);
        
        if($result['result'] == 'ok')
            $this->session->set('password',$result['password']);
        
        $this->ut->flashMessage("general", $request, $result);
       
    }
    
    private function savePhoto(Request $request){
        
        $this->tabActive = "photo";
 
        $foto = $request->files->all()['profilePhoto']['fileImage'];
        
        if(!empty($foto)):
           
            $rutaFoto = $this->ut->uploadImage($foto, $this->session->get('id'));
        endif;
        
        $arrayPhotos = null;
        $arrayPhotos[]=$rutaFoto;
        $result = $this->ut->saveFoto($arrayPhotos);
        
        if($result['result'] == 'ok'):
            $this->addPhotoProfile($request,$result['photos'][0]['id']);
            
        else:
            $this->ut->flashMessage("general", $request, $result);
        endif;
    }
    
    private function addPhotoProfile(Request $request, $idPhoto){
        $file = "http://www.whatwantweb.com/api_rest/user/data/update_user.php";
        $ch = new ApiRest();
        $data = array();
        
        $data['username'] = $this->session->get('username');
        $data['id'] = $this->session->get('id');
        $data['password'] = $this->session->get('password');

        
        $data['photo_id'] = $idPhoto;
        $informacion['data'] = json_encode($data); 
            
        $result = $ch->resultApiRed($informacion, $file);

        $this->ut->flashMessage("general", $request, $result);
    }
    
    private function sendSMS(Request $request){
        
        $this->tabActive = 'phone';
        
        $file = "http://www.whatwantweb.com/api_rest/user/phone/send_sms.php";

        $data = array('username' => $this->session->get('username'),
                      'id' => $this->session->get('id'),
                      'password' => $this->session->get('password'),
                      'phone' => $this->user->getPhone(),
                      'prefix' => $this->user->getPrefix());

        $ch = new ApiRest();
        
        $result = $ch->resultApiRed($data, $file);
        
        $this->ut->flashMessage("confirmTlfn", $request, $result);
    }
    
    private function savePhone(Request $request){
        
        $this->tabActive = "phone";
        
        $file = "http://www.whatwantweb.com/api_rest/user/phone/confirm_sms.php";
        $data = array('username' => $this->session->get('username'),
                      'id' => $this->session->get('id'),
                      'password' => $this->session->get('password'),
                      'token' => $request->request->all()['profileUser']['codConfirmation']);
        

        $ch = new ApiRest();
        $result = $ch->resultApiRed($data, $file);
        
        $this->ut->flashMessage("general", $request, $result);
        
    }
    
    private function saveBank(Request $request){
        
        $this->tabActive = "bank";
        
        $ch = new ApiRest();
        
        $data = array();
        $file = "http://www.whatwantweb.com/api_rest/user/data/update_user.php";
        
        $data['username']=$this->user->getUsername();
        $data['id']=$this->session->get('id');
        $data['password']=$this->session->get('password');
        $data['num_account'] = "'".$this->user->getNumAccount()."'";
        $informacion['data'] = json_encode($data); 
        
        $result = $ch->resultApiRed($informacion, $file);
        
        $this->ut->flashMessage("general",$request,$result);
    }
    
    private function newAddresses(Request $request){
        echo "nueva dirección";
        $this->tabActive = "address";
        
        $arrayAddress = $this->user->getAddresses();
        
        $address = end($arrayAddress);
        $pos = key($arrayAddress);
        

        $data['username'] = $this->session->get('username');
        $data['id_user'] = $this->session->get('id');
        $data['password'] = $this->session->get('password');
        $data['name'] = "'".$address->getName()."'";
        $data['street'] = "'".$address->getStreet()."'";
        $data['region'] = "'".$address->getRegion()."'";
        $data['country'] = "'".$address->getCountry()."'";
        $data['city'] = "'".$address->getCity()."'";
        $data['zip_code'] = "'".$address->getZipCode()."'";
        
        if(!empty($address->getIsDefault()))
            $data['is_default'] = 1;
        else $data['is_default'] = 0;
        
        $informacion['data'] = json_encode($data); 

        $ch = new ApiRest();
        $file = "http://www.whatwantweb.com/api_rest/user/addresses/insert_address.php";
         
        
        $result = $ch->resultApiRed($informacion, $file);
      
        if($result['result'] == 'ok')
            $this->user->getAddresses()[$pos]->setId($result['id']);
        
        $this->ut->flashMessage("general", $request, $result);
        
    }
    
    private function deleteAddresses(Request $request){
        
        $this->tabActive = "address";
        $arrayAddresses = $request->request->all()['profileAddress']['addresses'];
        
        $resultDelete['result'] = 'ok';
        
        $file = "http://www.whatwantweb.com/api_rest/user/addresses/delete_address.php";
        
        $data = array("username" => $this->session->get('username'),
                      "password" => $this->session->get('password'),
                      "id_user" => $this->session->get('id'));
        
        foreach($arrayAddresses as $address):
            if(array_key_exists('checkDeleteAddress', $address)):
                $ch = new ApiRest();
                $data["id"] = $address['id'];
                $result = $ch->resultApiRed($data, $file);
                
                if($result['result'] == 'ok'):
                    $this->updateAddressUser($address['id']);
                else:
                    $resultDelete['result'] = 'ko';
                endif;
            endif;
        endforeach;
        
        $this->ut->flashMessage("general", $request, $result);
        
    }
    
    private function updateAddressUser($id){
        $arrayAddresses = $this->user->getAddresses();
        
        foreach($arrayAddresses as $key => $value):
            if($value->getId() == $id):
                $this->user->deleteAddress($key);
            endif;
        endforeach;
       
    }
    
    private function updateAddresses(Request $request){
        
        $this->tabActive = "address";
        
        $arrayAddresses = $request->request->all()['profileAddress']['addresses'];
        $addressUpdate = null;
        $data = null;
        
        foreach($arrayAddresses as $address):
           if(array_key_exists('editAddress', $address)):
               $addressUpdate = $address;
               break;
           endif; 
        endforeach;
        
        $ch = new ApiRest();
        $file = "http://www.whatwantweb.com/api_rest/user/addresses/update_address.php";

        $data['username'] = $this->session->get('username');
        $data['id_user'] = $this->session->get('id');
        $data['password'] = $this->session->get('password');
        $data['id'] = $addressUpdate['id'];
        $data['name'] = "'".$addressUpdate['name']."'";
        $data['street'] = "'".$addressUpdate['street']."'";
        
        if(array_key_exists('isDefault',$addressUpdate))
            $data['is_default'] = 1;
        else
            $data['is_default'] = 0;

        $informacion['data'] = json_encode($data);
        
        $result = $ch->resultApiRed($informacion, $file);

        $this->ut->flashMessage("general", $request, $result);

    }
    
    public function profilePublicAction(Request $request){
        return $this->render('UserBundle:Profile:publicProfile.html.twig');
    }

}

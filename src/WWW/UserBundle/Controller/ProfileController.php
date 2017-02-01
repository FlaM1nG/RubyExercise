<?php

namespace WWW\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WWW\UserBundle\Entity\User as User;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\UserBundle\Form\ProfilePersonalType;
use WWW\UserBundle\Form\ProfileAddressType;
use WWW\UserBundle\Form\ProfileBankType;
use WWW\UserBundle\Form\ProfileEmailType;
use WWW\UserBundle\Form\ProfilePasswordType;
use WWW\UserBundle\Form\ProfilePhoneType;
use WWW\UserBundle\Form\ProfilePhotoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use WWW\UserBundle\Form\ProfileType;
use Doctrine\Common\Util\Inflector as Inflector;
use WWW\GlobalBundle\Entity\Utilities;
use WWW\ServiceBundle\Entity\Offer;
use WWW\UserBundle\Form\ProfilePersonalDataType;
use WWW\UserBundle\Form\ProfileAddressesType;
use WWW\GlobalBundle\MyConstants;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Description of ProfileController
 * 
 * 
 *
 * @author Rocio
 */
class ProfileController extends Controller{
    
    private $user = null;
    private $session = null;
    private $ut;
    private $email = "";
    
    
    public function profileAction(Request $request){ 
//        echo "ENTRO";
//       \Doctrine\Common\Util\Debug::dump((object)$this->getUser());
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $ut = new Utilities();
        $numMessage = $ut->messageNoRead($request);
        
        $session = $request->getSession();
        if(empty($session->get('numMessage'))):
            $session->set("numMessage",$numMessage);
        endif;

        print_r('ENTRA');
        print_r($this->user);
        die();
        
        return $this->render('UserBundle:Profile:indexProfile.html.twig',
                             array('usuario' => $this->user 
                            ));
        
    }
    
    
    
    public function personalDataAction(Request $request){
        
        $this->user = $this->getUser();
        $formPersonalData = $this->createForm(ProfilePersonalDataType::class,$this->user);
        $formPersonalData->handleRequest($request);
        
        if($formPersonalData->isSubmitted() && $formPersonalData->isValid()):
            $this->savePersonalData($request);
        endif;
        
        return $this->render('UserBundle:Profile:dataPersonal.html.twig',
                             array('form' => $formPersonalData->createView(),
                                   'user' => $this->user));
        
    }
    private function getUserExist(Request $request){
        
        $this->session = $request->getSession();
        
        $ch = new ApiRest();
        
        $file = MyConstants::PATH_APIREST."user/data/get_info_user.php";
        $arrayData = array("username" => $this->session->get('username'),
                           "id" => $this->session->get('id'),
                           "password" => $this->session->get('password'));
        
        $result = $ch->resultApiRed($arrayData, $file);
        //print_r($result);
        if($result['result'] == 'ok')
            //$this->fillUser($result);
            $this->user = new User($result);
        return $result;
 
        
            $this->usuario = new User($result);
        if($result['result'] == 'ok'):
                       
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
        
        $file = MyConstants::PATH_APIREST.'services/offer/get_all_user_offers.php';
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
        print_r($this->get('security.token_storage')->getToken()->getUser());
//        $this->tabActive = "personal";
        $fecha = $this->user->getBirthdate();
        
//        if($fecha < new\DateTime('today - 18 years')):
            $fecha = $fecha->format('Y-m-d');
            $ch = new ApiRest();
        
            $file = MyConstants::PATH_APIREST."user/data/update_user.php";
//print_r($this->user->getAddresses());
            $data = array();
            $data['username'] = $this->user->getUsername();
            $data['id'] = $this->user->getId();
            $data['password'] = $this->user->getPassword();
            
            $data['name']="'".$this->user->getName()."'";
            $data['surname']="'".$this->user->getSurname()."'";
            $data['birthdate'] = $fecha;
            $data['sex'] = "'".$this->user->getSex()."'";
            $data['nif'] = "'".$this->user->getNif()."'";
            $informacion['data'] = json_encode($data); 
            print_r($data);
//            $result = $ch->resultApiRed($informacion, $file);
//           
//            $this->ut->flashMessage("general", $request, $result);
//        endif;
       
    }
    
    private function saveEmail(Request $request){
        $this->tabActive = 'email';
        
        $file = MyConstants::PATH_APIREST."user/email/change_email.php";
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
        $file = MyConstants::PATH_APIREST."user/passwords/change_password.php";

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
        $file = MyConstants::PATH_APIREST."user/data/update_user.php";
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
        
        $file = MyConstants::PATH_APIREST."user/phone/send_sms.php";

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
        
        $file = MyConstants::PATH_APIREST."user/phone/confirm_sms.php";
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
        $file = MyConstants::PATH_APIREST."user/data/update_user.php";
        
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
        $file = MyConstants::PATH_APIREST."user/addresses/insert_address.php";
         
        
        $result = $ch->resultApiRed($informacion, $file);
      
        if($result['result'] == 'ok')
            $this->user->getAddresses()[$pos]->setId($result['id']);
        
        $this->ut->flashMessage("general", $request, $result);
        
    }
    
    public function deleteAddressesAction(Request $request){

        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST."user/addresses/delete_address.php";
        
        $data['id_user'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        $data['id'] = $request->get('id');
        
        $result = $ch->resultApiRed($data, $file);
        
        $response = new JsonResponse();
       
        if($result['result'] == 'ok'):
            $response->setData(array(
                'result' => 'ok',
                'message' => 'Datos actualizados correctamente'));
        else:
             $response->setData(array(
                'result' => 'ko',
                'message' => 'Ha ocurrido un error, por favor vuelva a intentarlo'));
        endif;
        
        return $response;
        
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
        $file = MyConstants::PATH_APIREST."user/addresses/update_address.php";

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

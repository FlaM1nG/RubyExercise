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
use WWW\GlobalBundle\Entity\ApiRed;
use WWW\UserBundle\Form\ProfileType;


/**
 * Description of ProfileController
 *
 * @author Rocio
 */
class ProfileController extends Controller{
    
    private $usuario;
    
    public function profileAction(Request $request){ 
        
        $session = $request->getSession();
        
        $section = null;
       
        $ch = new ApiRed();
        
        $file = "http://www.whatwantweb.com/api_rest/user/data/get_info_user.php";
        $arrayData = array("username" => $session->get('username'),
                           "id" => $session->get('id'),
                           "password" => $session->get('password'));
        
        $result = $ch->sendInformation($arrayData, $file, "parameters");
        print_r($result);
        
        $formAddress = null;
        $formulario = $this->createForm(ProfileType::class,$this->usuario);
       
        if($result['result'] == 'ok'):
            
            $this->usuario = new User($result);
            if($request->getMethod()=="POST"):
                
                $section = $request->request->all()['section'];
           
                if(array_key_exists('buttonAddAddress',$request->request->all() )):
                    $newAddress = new Address();
                
                    $this->usuario->addAddress($newAddress);
        
                    $form = $this->createForm(ProfileType::class,$this->usuario);

                    return $this->render('UserBundle:Default:profile.html.twig',array('formulario'=>$form->createView(),
                                                                          'usuario'=>$this->usuario));
                else:

                    if($section == 'sectionAddress')
                        $this->profileAddress($this->usuario,$request);
                                
                    if($section == 'sectionPassword')
                        $this->changePassword($this->usuario,$request);
                    
                    else
                        $this->updateProfile($request);
                endif;    
            
            endif;
           
        endif;
        
        $formulario = $this->createForm(ProfileType::class,$this->usuario);
        
        return $this->render('UserBundle:Default:profile.html.twig',array('formulario'=>$formulario->createView(),
                                                                          'usuario'=>$this->usuario));
    }
    
        
    private function updateProfile(Request $request){
        
        $arrayUser = $request->request->all()['profileUser'];
        $section = $request->request->all()['section'];
        
        $ch = new ApiRed();
        
        $file = "http://www.whatwantweb.com/api_rest/user/data/update_user.php";
        
        $data = array();
        $data['username']=$this->usuario->getUsername();
        $data['id']=$this->usuario->getId();
        $data['password']=$this->usuario->getPassword();

        if($section == 'sectionPersonal'):
            $fecha = "'".$arrayUser['birthdate']['year'].'-'.$arrayUser['birthdate']['month'].'-'.$arrayUser['birthdate']['day']."'";
        
            $date= \DateTime::createFromFormat('YYYY-mm-dd', $fecha);

            /*if($date >= new\DateTime('today - 18 years')):
                return false;
            endif;*/
            $data['name']="'".$arrayUser['name']."'";
            $data['surname']="'".$arrayUser['surname']."'";
            $data['phone']=$arrayUser['phone'];
            $data['birthdate'] = $fecha;
            $data['sex'] = "'".$arrayUser['sex']."'";

        elseif($section == 'sectionEmail'):
            
            $data['email'] = "'".$arrayUser['email']."'";
            
        elseif($section == 'sectionPassword'):
        
            $data['password'] = $arrayUser['password'];
        
        elseif($section == 'sectionPhoto'):
            
            $data['photo'] = "'".$arrayUser['photo']."'";
            
        endif;

        $result = $ch->sendInformation($data, $file, "json");

        if($result['result'] == "ok"):
            
            foreach($data as $key => $value):
            
                if($key != "id" && $key != "birthdate"):
                    $aux = "set".ucwords($key);
                    //Al forma el array algunos datos se les añade comillas x lo que hay que quitarlas
                    if($value[0] == "'"):
                        $value = substr($value,1);
                        $value = substr($value,0,-1);
                    endif;
                    $this->usuario->$aux($value);
                endif;    

            endforeach;
        endif;
        
    }
    
    private function profileAddress(User $user, Request $request){

        if(isset($request->request->all()["idChangeAddress"]) 
                && $request->request->all()["idChangeAddress"] == "" 
                && empty($request->request->all()["idDeleteAddress"])):
           echo "añade direcciój";
            $this->addAddress($user,$request);

        elseif(array_key_exists("idChangeAddress", $request->request->all()) && 
                isset($request->request->all()["idChangeAddress"]) && 
                $request->request->all()["idChangeAddress"] != ""):
            echo "actulización dirección";
            $this->updateAddress($user, $request);
        
        elseif(array_key_exists("idDeleteAddress", $request->request->all())):
            echo "borra dirección";
            $this->deleteAddress($user,$request);
           
        endif;
  
    }
    
    private function updateAddress(User $user, Request $request){
        
        $arrayAdress = $request->request->all()['profileUser']['addresses'];
        $posArrayAddress = $request->request->all()['idChangeAddress'];
        
        $ch = new ApiRed();
        $file = "http://www.whatwantweb.com/api_rest/user/addresses/update_address.php";
        
        $data = array();
        $data['username']=$user->getUsername();
        $data['id_user']=$user->getId();
        $data['password']=$user->getPassword();
        $data['id'] = $arrayAdress[$posArrayAddress]['id'];
        $data['name'] = "'".$arrayAdress[$posArrayAddress]['name']."'";
        $data['street'] = "'".$arrayAdress[$posArrayAddress]['street']."'";
        
        if(array_key_exists('isDefault',$arrayAdress[$posArrayAddress]))
            $data['is_default'] = 1;
        else
            $data['is_default'] = 0;

        $result = $ch->sendInformation($data, $file, "json");
        
        //print_r($result);        
    }
    
    private function deleteAddress(User $user, Request $request){

        $arrayAdress = $request->request->all()['profileUser']['addresses'];
        $posArrayAddress = $request->request->all()['idDeleteAddress'];
        
        $ch = new ApiRed();
        $file = "http://www.whatwantweb.com/api_rest/user/addresses/delete_address.php";
            
        $data = array("username" => $user->getUsername(),
                      "password" => $user->getPassword(),
                      "id_user" => $user->getId(),
                      "id" => $arrayAdress[$posArrayAddress]['id']);
        
        $result = $ch->sendInformation($data, $file,"parameters");
        
        if($result['result'] == 'ok'):
            $this->usuario->deleteAddress($posArrayAddress);
        endif;
    }
    
    private function addAddress(User $user, Request $request){
    print_r($request->request->all());
        $dataForm= $request->request->all();
        $posAddress = count( $request->request->all()['profileUser']['addresses']);
        $addressDefault = 0;
        
        echo "<br><br>Direcciones <br><br>".$posAddress."<br>";
        print_r($request->request->all());
        $data = array();
        $data['username'] = $user->getUsername();
        $data['id_user'] = $user->getId();
        $data['password'] =$user->getPassword();
        $data['name'] = "'".$dataForm["nameNewAddress"]."'";
        $data['street'] = "'".$dataForm["streetNewAddress"]."'";
        $data['zipcode_id'] = 1;
        
        if(array_key_exists('isDefaultNewAddress',$dataForm))
            $data['is_default'] = 1;
        else 
            $data['is_default'] = 0;
        
        $ch = new ApiRed();
        $file = "http://www.whatwantweb.com/api_rest/user/addresses/insert_address.php";
        
        $result = $ch->sendInformation($data, $file, "json");
        echo "data<br>"; print_r($data);echo "<br>";
        print_r($result);
        
        if($result['result'] == 'ok'):
            echo "<br><br>Direccion nueva<br>PosAddress ".$posAddress;
        
            print_r($this->usuario->getAddresses()[$posAddress]);
        endif;
        
        //print_r($result);
    }
    
    public function changePassword(User $user, Request $request){
        $datos = $request->request->all()['profileUser'];
       
        $ch = new ApiRed();
        $file = "http://www.whatwantweb.com/api_rest/user/passwords/change_password.php";
            
        $id = $user->getId();
        $username = $user->getUsername();
        $oldPassword = $datos['oldPassword'];
        $newPassword = $datos['password']['first'];
        
        $data = array("username" => $username,
                      "old_password" => $oldPassword,
                      "new_password" => $newPassword,
                      "id" => $id);
        
        $result = $ch->sendInformation($data, $file, "parameters");
        
        //print_r($result);
    }
}

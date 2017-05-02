<?php

namespace WWW\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use WWW\GlobalBundle\Form\AddressType;
use WWW\GlobalBundle\Entity\Address;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\Entity\Utilities;
use WWW\GlobalBundle\MyConstants;
use WWW\UserBundle\Entity\User;

class ProfileAddressController extends Controller
{
    
    public function listAddressAction(Request $request){
        
        $user = $this->getUserProfile($request);
        
        return $this->render("UserBundle:Profile:profileAddresses.html.twig",
                        array('usuario' => $user));
    }
    
    private function getUserProfile(Request $request){
        
        $user = null;
        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST.'user/data/get_info_user.php';
        
        $data['id'] = $this->getUser()->getId();
        $data['username'] = $this->getUser()->getUsername();
        $data['password'] = $request->getSession()->get('password');
        
        $result = $ch->resultApiRed($data, $file);
      
        if($result['result'] == 'ok'):
            $user = new User($result);
        endif;

        return $user;
    }
    
    public function newAddressAction(Request $request){

        $this->redirectRouteAddresses($request);
        
        $address = new Address();
        $formAddress = $this->createForm(AddressType::class, $address);
        
        $formAddress->handleRequest($request);
        
        if($formAddress->isSubmitted() && $formAddress->isValid()):
            $result = $this->createAddress($request, $address);

            if($result == 'ok'):

                $path = $request->getSession()->get('_security.user.target_path');
                
                if (!empty($path)):
                    $request->getSession()->remove('_security.user.target_path');

                    if(strpos($path, '/payment/trade/offer/') !== false):
                        return $this->redirect($path);
                    else:
                        return $this->redirect($this->generateUrl($path));
                    endif;
                else:
                    return $this->forward('UserBundle:ProfileAddress:listAddress');
                    
                endif;

            endif;
        endif;
       
        return $this->render('UserBundle:Profile:profileNewAddress.html.twig',
                             array('form' => $formAddress->createView() )
                            );
    }

    private function redirectRouteAddresses(Request $request){

        $path = parse_url($request->headers->get('referer'),PHP_URL_PATH);

        if($path == $this->generateUrl('service_newClothes')):
            $request->getSession()->set('_security.user.target_path','service_newClothes');

        elseif($path == $this->generateUrl('service_newTrade')):
            $request->getSession()->set('_security.user.target_path','service_newTrade');

        elseif($path == $this->generateUrl('service_newBarter')):
            $request->getSession()->set('_security.user.target_path','service_newBarter');

        elseif(strpos($path, '/payment/trade/offer/') !== false):
            $request->getSession()->set('_security.user.target_path',$request->headers->get('referer'));
        //vengo de hacer un submit o de cualquier otro sitio
        elseif($path != $this->generateUrl('user_profiler_newAdress')):
            $request->getSession()->remove('_security.user.target_path');
        
        endif;

    }
    
    private function createAddress(Request $request, $address){
        
        $ch = new ApiRest();
        $ut = new Utilities();
        
        $file = MyConstants::PATH_APIREST."user/addresses/insert_address.php";
        $session = $request->getSession();
        $isDefault = 0;
        
        if(isset($request->get('adressUser')['isDefault'])):
            $isDefault = 1;
        endif;
        
        $data['username'] = $session->get('username');
        $data['id_user'] = $session->get('id');
        $data['password'] = $session->get('password');
        $data['name'] = "'".$address->getName()."'";
        $data['street'] = "'".$address->getStreet()."'";
        $data['city'] = "'".$address->getCity()."'";
        $data['zip_code'] = "'".$address->getZipCode()."'";
        $data['is_default'] = $isDefault;
        $data['region'] = "'".$address->getCountry()->getRegion()."'";
        $data['country'] = "'".$address->getCountry()->getCountry()."'";

        if(!empty($address->getPhone())):
            $data['prefix'] = "'".$address->getPrefix()."'";
            $data['phone'] = "'".$address->getPhone()."'";
        endif;
        
        $info['data'] = json_encode($data);
        
        $result = $ch->resultApiRed($info, $file);
        
        $ut->flashMessage("Dirección creada", $request, $result);
        
        return $result['result'];
        
    }
    
    public function editAddressAction(Request $request){
        
        $ut = new Utilities();
        
        $idAddress = $request->get('idAddress');
        $user = $this->getUserProfile($request);
        
        $address = $this->searchAddress($user,$idAddress);
        $form = $this->createForm(AddressType::class,$address);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()):
            $this->updateAddress($request,$address,$ut);
        endif;
        
        return $this->render('UserBundle:Profile:profileEditAddress.html.twig',
                             array('form' => $form->createView() )
                            );
    }
    
    private function searchAddress($user, $idAddress){
        
        $arrayAddress = $user->getAddresses();
        $addressDefault = $user->getDefaultAddress();
        $address = null;
        
        if(!empty($addressDefault) AND $addressDefault->getId() == $idAddress):
            $address = $addressDefault;
            $address->setIsDefault(true);
        else:

            foreach($arrayAddress[0] as $data): 
                if($data->getId() == $idAddress):
                    $address = $data;
                    break;
                endif;
                
            endforeach;
        endif;
        
        return $address;
    }
    
    private function updateAddress(Request $request, $address, $ut){

        $ch =  new ApiRest();
        $file = MyConstants::PATH_APIREST."user/addresses/update_address.php";

        $data['id_user'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        $data['id'] = $request->get('idAddress');
        $data['name'] = "'".$address->getName()."'";
        $data['street'] = "'".$address->getStreet()."'";
        $data['country'] = "'".$address->getCountry()->getCountry()."'";
        $data['region'] = "'".$address->getCountry()->getRegion()."'";
        $data['city'] = "'".$address->getCity()."'";
        $data['zip_code'] = "'".$address->getZipCode()."'";
        
        if(!empty($address->getPhone())):
            $data['prefix'] = "'".$address->getPrefix()."'";
            $data['phone'] = "'".$address->getPhone()."'";
        endif;

        if(!empty($address->getIsDefault())):
            $data['is_default'] = 1;
        else:
            $data['is_default'] = 0;
        endif;
        
        $info['data'] = json_encode($data);

        $result = $ch->resultApiRed($info, $file);

        $ut->flashMessage("general", $request, $result);

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
        elseif($result['result'] == 'data_error' AND $result['error'] == 'addressTrade'):
             $response->setData(array(
                'result' => 'ko',
                'message' => 'No se ha podido llevar a cabo el borrado, la dirección está asociada a ofertas de compra-venta'));
        else:
            $response->setData(array(
                'result' => 'ko',
                'message' => 'Ha ocurrido un error, por favor, vuelvalo intentar más tarde'));
        endif;
        
        return $response;
    }
}

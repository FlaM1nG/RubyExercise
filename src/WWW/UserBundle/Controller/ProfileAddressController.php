<?php

namespace WWW\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WWW\GlobalBundle\Form\AdressType;
use WWW\GlobalBundle\Entity\Address;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\Entity\Utilities;
use WWW\GlobalBundle\MyConstants;

class ProfileAddressController extends Controller
{
    public function newAddressAction(Request $request){
        
        $address = new Address();
        $formAddress = $this->createForm(AdressType::class, $address);
        
        $formAddress->handleRequest($request);
        
        if($formAddress->isSubmitted() && $formAddress->isValid()):
            $result = $this->createAddress($request, $address);
            
            if($result == 'ok'):
                return $this->forward('UserBundle:Profile:profile', 
                                        array( 'tabActive'  => "address" ));
            endif;
        endif;
        
        return $this->render('UserBundle:Profile:profileNewAddress.html.twig',
                             array('form' => $formAddress->createView() )
                            );
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
        $data['region'] = "'".$address->getRegion()."'";
        $data['country'] = "'".$address->getCountry()."'";
        $data['city'] = "'".$address->getCity()."'";
        $data['zip_code'] = "'".$address->getZipCode()."'";
        $data['is_default'] = $isDefault;
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
        $idAddress = $request->get('idAddress');
        echo $idAddress;
        
        return $this->render('UserBundle:Profile:profileEditAddress.html.twig'
//                             array('form' => $formAddress->createView() )
                            );
    }
}

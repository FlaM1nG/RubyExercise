<?php

namespace Acme\PaymentBundle\Controller;

require_once ( 'C:\xampp\htdocs\wwweb\vendor\autoload.php' );

//require_once $_SERVER['DOCUMENT_ROOT'] . '/JS9NAJ8JEABj8jcsk9xbGTC7VSM9XAMbaxnbs3873778dhd4m/vendor/autoload.php';

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Postmen\Postmen;
use WWW\GlobalBundle\Entity\Utilities;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\MyConstants;
use Symfony\Component\HttpFoundation\Request;
use WWW\UserBundle\Entity\User;
use WWW\OthersBundle\Entity\Trade;

class CorreosController extends Controller {
    
    private $ut;
    private $offer;
    private $buyer;
    private $addressBuyer;
    private $em;
    private $trackingNumber;


    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
{
        $this->em = $entityManager;
}

    public function checkCode($idInscription,$arrayDetails, $request) {
        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST . 'services/inscription/get_inscription.php';

        if(empty( $arrayDetails['idUser'])){
            $data['id'] = $request->getSession()->get('id');
            $data['username'] = $request->getSession()->get('username');
            $data['password'] = $request->getSession()->get('password');
        
        }
        else{
            $data['id'] = $arrayDetails['idUser'];
            $data['username'] = $arrayDetails['username'];
            $data['password'] = $arrayDetails['password'];
        }
        $data['inscription_id'] = $idInscription;
        
        $result = $ch->resultApiRed($data, $file);
        if(!empty($result['data_extra'])){
            $this->trackingNumber=$result['data_extra'];
            return true;
        }
        else{
            return false;
        }
    }
    
    public function getTrackingNumberAction($idOffer, Request $request, $idDir, $sendOffice,$arrayDetails, $idInscription) {
        //Inicio las variables propias
        if(!$this->checkCode($idInscription,$arrayDetails, $request)){
			
        $this->searchAddressBuyer($idDir);
        $this->offer = new Trade();
        $this->buyer = new User();
        
        //Se cargan los datos 
        $this->buyer = $this->getUserProfile($request,$arrayDetails);
        $this->getOffer($idOffer, $request);
         
        
        //claves 
        $api_key = 'e0955a76-61fc-4267-ae31-599f047aca58';
        $region = 'sandbox';
        $shipper = '6c25c10e-af38-4641-9127-4cdfeb35392d';

        //Proceso de creacion del tiquet
        
        if (!isset($shipper)) {
            echo "\$shipper is not set, modify file labels_create.php\n";
        }

        $parcel = array(
            'description' => $this->offer->getOffer()->getTitle(),
            'box_type' => 'custom',
            'weight' => array(
                'value' => floatval($this->offer->getWeight()),
                'unit' => 'kg',
            ),
            'dimension' => array(
                'width' => 1,
                'height' => 1,
                'depth' => 1,
                'unit' => 'cm',
            ),
            'items' => array(
                0 => array(
                    'description' => $this->offer->getOffer()->getTitle(),
                    'origin_country' => 'ESP',
                    'quantity' => 1,
                    'price' => array(
                        'amount' => floatval($this->offer->getPrice()),
                        'currency' => 'EUR',
                    ),
                    'weight' => array(
                        'value' => floatval($this->offer->getWeight()),
                        'unit' => 'kg',
                    ),
                    'sku' => 'imac2014'
                ),
            ),
        );
        
        $sender = array(
            'contact_name' => $this->offer->getOffer()->getUserAdmin()->getUsername(),
            'email' => $this->offer->getOffer()->getUserAdmin()->getEmail(),
            'phone' =>  '697478793',//strval( $this->offer->getOffer()->getUserAdmin()->getPhone() ),
            'street1' => $this->offer->getAddress()->getStreet(),
            'city' => $this->offer->getAddress()->getCity(),
            'postal_code' => $this->offer->getAddress()->getZipCode(),
            'state' => $this->offer->getRegion(),            
            'country' => 'ESP',
            'type' => 'residential'
        );
       
        if($sendOffice==0){
            $receiver = array(
                'contact_name' => $this->buyer->getUsername(),
                'phone' =>  '697478793',//strval( $this->buyer->getPhone()),
                'email' => $this->buyer->getEmail(),
                'street1' => $this->addressBuyer->getStreet(),
                'postal_code' => $this->addressBuyer->getZipCode(),
                'city' => $this->addressBuyer->getCity(),
                'state' => $this->addressBuyer->getRegion(),            
                'country' => 'ESP',    
                'type' => 'residential'
            );
        }
        
        else {
            $receiver = array(
                'contact_name' => 'Felix Estrada Muñoz',
                'company_name' => 'WhatWantWeb',
                'phone' => '653409736',
                'email' => 'info@whatwantweb.com',
                'street1' => 'Avd Fernado de los Ríos 11 bq. 1, of. 3',
                'postal_code' => '18100',
                'city' => 'Armilla',
                'state' => 'Granada',            
                'country' => 'ESP',    
                'type' => 'business'
            );
        }
        
        $payload = array(
            'async' => false,
            'billing' => array(
                'paid_by' => 'shipper',
            ),
            'return_shipment' => false,
            'is_document' => false,
            'service_type' => 'spain-correos-es_paq72_home',
            'paper_size' => 'default',
            'invoice' => array(
                'date'=> date("Y-m-d"),                
            ),            
            'shipper_account' => array(
                'id' => $shipper,
            ),
            'references' => array(
                    0 => ' ',
                ),
            'shipment' => array(
                'ship_from' => $sender,
                'ship_to' => $receiver,
                'parcels' => array(
                    0 => $parcel,
                ),

            ),
        );
		

        try {
            $api = new Postmen($api_key, $region);
            $result = $api->create('labels', $payload);
			
            $this->trackingNumber= $result->tracking_numbers[0];

        } catch (exception $e) {
            echo "ERROR:\n";
            echo $e->getCode() . "\n";      // error code
            echo $e->getMessage() . "\n";   // error message
            print_r($e->getDetails());      // error details
        }
        }
        return $this->trackingNumber;
            
            
    }
    
        private function getOffer($id, Request $request) {
        $this->ut = new Utilities();
        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST . "services/offer/get_offer.php";
        
        $this->offer = null;

        $data['id'] = $id;

        $result = $ch->resultApiRed($data, $file);
     
        if ($result['result'] == 'ok'):
            $this->offer = new Trade($result);
            

        else:
            $this->ut->flashMessage("general", $request);
        endif;
    }
    
    private function getUserProfile(Request $request, $arrayDetails) {

        $user = null;
        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST . 'user/data/get_info_user.php';

        if(empty( $arrayDetails['idUser'])){
            $data['id'] = $request->getSession()->get('id');
            $data['username'] = $request->getSession()->get('username');
            $data['password'] = $request->getSession()->get('password');
        
        }
        else{
            $data['id'] = $arrayDetails['idUser'];
            $data['username'] = $arrayDetails['username'];
            $data['password'] = $arrayDetails['password'];
        }
        
        
        $result = $ch->resultApiRed($data, $file);

        if ($result['result'] == 'ok'):
            $user = new User($result);
        endif;

        return $user;
    }
    private function searchAddressBuyer($idAddress){
        
        //Metodo para busar una direccion por id usando Doctrine
        $address= $this->em->getRepository('GlobalBundle:Address')->find($idAddress);
        
        if (!$address) {
            throw $this->createNotFoundException(
                'No product found for id '.$address
            );
        
        }
        $this->addressBuyer = $address;
        
    }

}
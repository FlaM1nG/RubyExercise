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
use Symfony\Component\HttpFoundation\JsonResponse;
use WWW\ServiceBundle\Entity\Offer;
use WWW\OthersBundle\Entity\Trade;
use WWW\OthersBundle\Form\TradeType;


/**
 * Description of OfferController
 *
 * @author Rocio
 */
class OfferController extends Controller{
    
    private $ut;
    private $offer;
    
    public function myOffersAction(Request $request){
        
        $offers = $this->listMyOffers($request);
        
        return $this->render('UserBundle:Profile:offers/profileMyOffers.html.twig',
                       array('listOffers' => $offers));
    }
    
    private function listMyOffers(Request $request){
        
        $file = MyConstants::PATH_APIREST."services/offer/get_all_user_offers.php";
        $ch = new ApiRest();
        $session = $request->getSession();
        $arrayOffers = null;
        
        $data['username'] = $session->get('username');
        $data['id'] = $session->get('id');
        $data['password'] = $session->get('password');
        
        $result = $ch->resultApiRed($data, $file);
        
        if($result['result'] == 'ok'):
            foreach($result['offers'] as $offer):
                $arrayOffers[] = new Offer($offer);
            endforeach;
        endif;
        
        return $arrayOffers;
        
    }
    
    public function editOfferAction(Request $request){
        
        $this->ut = new Utilities();
        $form = $this->searchOffer($request);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted()):
            $this->updateOffer($request);
        endif;
        
        return $this->render('UserBundle:Profile:offers/profileEditOffer.html.twig',
                        array('form' =>$form->createView()));
    }
    
    private function updateOffer(Request $request){
        
        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST."services/offer/update_offer.php";
        
        $info['id'] = $request->getSession()->get('id');
        $info['username'] = $request->getSession()->get('username');
        $info['password'] = $request->getSession()->get('password');
        $info['offer_id'] = $this->offer->getId();
 
        $data['values']['title'] = "'".$this->offer->getOffer()->getTitle()."'"; 
        $data['values']['description'] = "'".$this->offer->getOffer()->getDescription()."'"; 
        $data['sub_values']['price'] = $this->offer->getPrice();
        $data['sub_values']['dimensions'] = "'".$this->offer->getDimensions()."'";
        $data['sub_values']['weight'] = $this->offer->getWeight();
        $data['sub_values']['region'] = "'".$this->offer->getRegion()."'";
        $data['sub_values']['category_id'] = $this->offer->getCategory()->getId();
        
        $info['data']= json_encode($data);
        
        if(!empty($request->files->get('imgOffer')[0])):
            $this->uploadImage($request);
        endif;
        
//        $result = $ch->resultApiRed($info, $file);

//        $this->ut->flashMessage("general", $request, $result);
    }
    
    private function searchOffer(Request $request){
       
       $file = MyConstants::PATH_APIREST."services/offer/get_offer.php";
       $ch = new ApiRest();
       
       $data['id'] = $request->get('idOffer');
       $result = $ch->resultApiRed($data, $file);
       $formulario = null;
     
        if($result['result'] == 'ok'):

            $this->service = $result['service_id'];

             if($result['service_id'] == 1):
                 $this->createTrade($result);
                 $formulario = $this->createForm(TradeType::class,$this->offer);
             endif;
        else:     
            $this->ut->flashMessage("offer", $request, $result);
        endif;

        return $formulario;
   }
   
   private function createTrade($result){
       
        $offer = new Trade($result,true);
        
        $arrayCategory = $this->ut->getArrayCategoryTrade();
        $offer->setCategory($arrayCategory[$result['category_id']]);
        
        $this->offer = $offer;

   }
   
   public function deleteImageOfferAction(Request $request){
      
        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST."services/photos/delete_offer_photo.php";
        
        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        $data['offer_id'] = $request->get('idOffer');
        $data['photos_id'] = $request->get('key');

        $result = $ch->resultApiRed($data, $file);

        $response = new JsonResponse();
        
        return $response;
   }
   
   public function uploadImage(Request $request){
    
        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST."services/photos/insert_offer_photo.php";
        
        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        $data['offer_id'] = $request->get('idOffer');
        $data['photos'] = $request->files->get('imgOffer');

        $data['photos'] = $request->files;

        
        print_r($data);
        
        $result = $ch->resultApiRed($data, $file);
        print_r($result);
   }
}

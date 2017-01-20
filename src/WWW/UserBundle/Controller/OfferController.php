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
        
        return $this->render('UserBundle:Profile:offers/profileEditOffer.html.twig',
                        array('form' =>$form->createView()));
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
        echo $file."<br>";
        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        $data['offer_id  '] = $request->get('idOffer');
        $data['photos_id'] = $request->get('idImages');
        
        print_r($data);
//        $result = $ch->resultApiRed($data, $file);
        
        $response = new JsonResponse();
        $result['result'] = 'ok';
        
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
}

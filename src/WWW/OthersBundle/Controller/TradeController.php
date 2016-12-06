<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace WWW\OthersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WWW\OthersBundle\Entity\Trade;
use WWW\OthersBundle\Form\TradeType;
use WWW\ServiceBundle\Entity\Offer;
use WWW\ServiceBundle\Form\OfferType;
use Symfony\Component\HttpFoundation\Request;
use WWW\GlobalBundle\Entity\ApiRest;

/**
 * Description of TradeController
 *
 * @author Rocio
 */
class TradeController extends Controller{
    
    private $sesion;
    
    public function createOfertAction(Request $request){
        $this->sesion = $request->getSession();
        
        $offer = new Offer();
        $trade = new Trade();
        
        $formOffer = $this->createForm(new OfferType(),$offer);
        $formTrade = $this->createForm(new TradeType(),$trade);
        
         if($request->getMethod()=="POST"):
             $this->saveTrade($request);
         endif;
        
        return $this->render('OthersBundle:Trade:offerTrade.html.twig',
                       array('formOffer' => $formOffer->createView(),
                             'formTrade' => $formTrade->createView()));
    }
    
    private function saveTrade(Request $request){
        //print_r($request);
        
        $service = $request->server->all()['PATH_INFO'];
        $requestOffer = $request->request->all()['offer'];
        $requestTrade = $request->request->all()['trade'];
       
        $ch = new ApiRest();
        $file = "http://www.whatwantweb.com/api_rest/services/offer/insert_offer.php";
        $dataOffer = array("id" => $this->sesion->get('id'),
                      "username" => $this->sesion->get('username'),
                      "password" =>$this->sesion->get('password'),
                      "title" => $requestOffer['title'],
                      "description" => $requestOffer['description'],
                      "service_id" => 1);
        $dataTrade = array();
        
        $dataTrade['photos'] = array(1,2);
        //category_id debe venir de un array de categorías
        
        $dataTrade['values'] = array("category_id" => 1,
                           "price_user" => $requestTrade['priceUser'],
                           "dimensions" => "'".$requestTrade['dimensions']."'",
                           "weight" => $requestTrade['weight'] );
        
        $result = $ch->sendSeveralInformation($dataOffer, $dataTrade, $file);
        //print_r($result);
        
        if($result['result'] == "ok"):
            $this->addFlash(
                                'messageOffer',
                                'Oferta guardada con éxito'
                            );
        else:
            $this->addFlash('messageOffer', 'Ha ocurrido un error');
        endif;
                
    }
}

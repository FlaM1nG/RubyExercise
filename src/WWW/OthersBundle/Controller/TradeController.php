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
use Symfony\Component\HttpFoundation\Request;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\Entity\Utilities;

/**
 * Description of TradeController
 *
 * @author Rocio
 */
class TradeController extends Controller{
    
    private $sesion;
    private $trade;
    private $ut;
    
    public function createOfferAction(Request $request){
        
        $this->ut = new Utilities();
        
        $this->sesion = $request->getSession();
        
        $trade = new Trade();
        $formTrade = $this->createForm(TradeType::class,$trade);
        $formTrade->handleRequest($request);
        
         if($formTrade->isSubmitted()):
             
             $this->saveTrade($request,$trade);
         endif;
        
        return $this->render('OthersBundle:Trade:offerTrade.html.twig',
                       array('formTrade' => $formTrade->createView(),
                             'trade' => $trade));
    }
    
    private function saveTrade(Request $request, Trade $trade){
        
        $service = $request->server->all()['PATH_INFO'];
        
        $dataExtra['url']=$this->uploadImage($request);
        
        if($this->uploadImage($request) == false):
            $result['result'] = 'ko';
            $this->ut->flashMessage("tradeImageN", $request, $result);
            return false;
        else:
            $ch = new ApiRest();
            $file = "http://www.whatwantweb.com/api_rest/services/offer/insert_offer.php";
            $dataOffer = array("id" => $this->sesion->get('id'),
                             "username" => $this->sesion->get('username'),
                            "password" =>$this->sesion->get('password'),
                            "title" => $trade->getOffer()->getTitle(),
                            "description" => $trade->getOffer()->getDescription(),
                            "service_id" => 1);

            $dataExtra['values'] = array("category_id" => $trade->getCategory()->getId(),
                               "price" => $trade->getPrice(),
                               "dimensions" => "'".$trade->getDimensions()."'",
                               "weight" => $trade->getWeight(),
                               "region" => "'".$trade->getRegion()."'");


            $dataOffer['data'] = json_encode($dataExtra);

            $result = $ch->resultApiRed($dataOffer, $file);
            $this->ut->flashMessage("general", $request, $result);
        endif;        
    }
    
    private function uploadImage(Request $request){
        
        $arrayFiles = $request->files->all()['trade']['offer']['fileImage'];
        $arrayUrls = false;
        
        if(!empty($arrayFiles[0])): 
            if(count($arrayFiles) > 5): 
                
                return $arrayUrls;
            else:     
                $arrayUrls = $this->ut->uploadImage($arrayFiles, $this->sesion->get('id'));
            endif;
        endif;
        
        return $arrayUrls;
        
    }
    
    private function flashMessageGeneral($result){
        
        if($result == 'ok'):
            $this->addFlash('messageSuccess','Datos guardados correctamente');
        else:
            $this->addFlash('messageFail','Error al guardar');
        endif;
    }
    
    public function listTradeAction(Request $request){
       // print_r($request);
        $this->ut = new Utilities();
        $varPost = $request->request->all();
        
        
        $data['service'] = 'trade';
        $data['search'] = '';
        
        if(!empty($varPost)):
            
            if(!empty($request->get('object')))
                $data['search'] = $request->get('object');
            
            if(!empty($request->get('city')))
                $data['filters']['location'] = $request->get('city'); 
            
            if(!empty($request->get('minPrice'))):
                $data['filters']['min_price'] = (int)$request->get('minPrice'); 
            endif;
            
            if(!empty($request->get('maxPrice')))
                $data['filters']['max_price'] = (int)$request->get('maxPrice'); 
            
            if(array_key_exists('category', $varPost)):
                foreach($request->get('category') as $cat):
                    $data['filters']['categories'][] = (int)$cat;
                endforeach;
            endif;     
             
        endif;
        
        $arrayOffers = $this->searchTrades($data);
        
        return $this->render('services/serTrade.html.twig',array(
                             'arrayTrades' => $arrayOffers,
                             'categories' => $this->ut->getArrayCategoryTrade()
        ));
    }
    
    private function searchTrades($data){
        
        $arrayOffers = array();
        $ch = new ApiRest();
        $file = "http://www.whatwantweb.com/api_rest/services/trade/list_trades.php";
        
        $informacion['data'] = json_encode($data);
         
        $result = $ch->resultApiRed($informacion, $file);
        
        if($result['result'] == 'ok'):
            foreach($result['offers'] as $trade):
                $newTrade = new Trade($trade);
                array_push($arrayOffers, $newTrade);
            endforeach;
        endif;
        return $arrayOffers;
    }
    
    public function showTradeAction(Request $request){
        $ch = new ApiRest();
        $ut = new Utilities();
        $trade = null;
        $file = "http://www.whatwantweb.com/api_rest/services/trade/get_trade.php";
       
        $data['id'] = $request->get('idOffer');
        
        $result = $ch->resultApiRed($data, $file);
        
        if($result['result'] == 'ok'):
            $trade = new Trade($result);
        
        else:
            $ut->flashMessage("general", $request);
        endif;
        
        return $this->render('offer/offTrade.html.twig',array(
                             'trade' => $trade
        ));
    }
}

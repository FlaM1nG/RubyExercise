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

/**
 * Description of TradeController
 *
 * @author Rocio
 */
class TradeController extends Controller{
    
    private $sesion;
    private $trade;
    
    public function createOfferAction(Request $request){
        //print_r($request);
        $this->sesion = $request->getSession();
        
        $trade = new Trade();
        $formTrade = $this->createForm(TradeType::class,$trade);
        $formTrade->handleRequest($request);
        
         if($formTrade->isSubmitted()):
             
             $this->saveTrade($request,$trade);
             //echo "enviado";

         endif;
        
        return $this->render('OthersBundle:Trade:offerTrade.html.twig',
                       array('formTrade' => $formTrade->createView(),
                             'trade' => $trade));
    }
    
    private function saveTrade(Request $request, Trade $trade){
        //print_r($trade);
        
        $service = $request->server->all()['PATH_INFO'];
        $dataTrade['photos'] = array();
       
        $ch = new ApiRest();
        $file = "http://www.whatwantweb.com/api_rest/services/offer/insert_offer.php";
        $dataOffer = array("id" => $this->sesion->get('id'),
                      "username" => $this->sesion->get('username'),
                      "password" =>$this->sesion->get('password'),
                      "title" => $trade->getOffer()->getTitle(),
                      "description" => $trade->getOffer()->getDescription(),
                      "service_id" => 1);
        $dataTrade = array();
        
        if(array_key_exists('trade', $request->files->all()))
            $dataTrade['photos'] = $this->uploadImage($request);
         
        $dataTrade['values'] = array("category_id" => $trade->getCategory()->getId(),
                           "price" => $trade->getPrice(),
                           "dimensions" => "'".$trade->getDimensions()."'",
                           "weight" => $trade->getWeight(),
                           "region" => "'".$trade->getRegion()."'");
        print_r($dataTrade);
        
        $result = $ch->sendSeveralInformation($dataOffer, $dataTrade, $file);
        print_r($result);
        $this->flashMessageGeneral($result['result']);
                
    }
    
    private function uploadImage(Request $request){
        
        $filePhotos = "http://www.whatwantweb.com/api_rest/global/photo/add_photos.php";
        $arrayFiles = $request->files->all()['trade']['offer']['photos'][1]['fileImage'];
        $arrayPhotos = null;
        $i = 1;
        
        $directorio = 'C:/xampp/htdocs/img/user_1';
        //$directorio = 'http://www.whatwantweb.com/img/user_'.$this->usuario->getId();
        
        if(!file_exists($directorio)):
            mkdir($directorio, 0777, true);
        
        else:
            
            $i = count(scandir($directorio))+1;
        
        endif;

        foreach($arrayFiles as $file):
            $tmpName = $file->getPathname();
            $extension = $file->getClientoriginalExtension();
            $nameImg = 'image_'.$i.$extension;
            $arrayPhotos[] = $directorio.'/'.$nameImg;
            move_uploaded_file($tmpName,$directorio.'/'.$nameImg);
            
            $i++;
        endforeach;
        
        $ch = new ApiRest();
        
        $data['url'] = $arrayPhotos; 
        $informacion['data'] = json_encode($data);
        
        $result = $ch->resultApiRed($informacion, $filePhotos);
        
        if($result['result'] == 'ok'):
            $arrayPhotos = null;
            
            foreach($result['photos'] as $photo):
               $arrayPhotos[] = $photo['id'];
            endforeach;
            
            return $arrayPhotos;
        else:
            $this->flashMessageGeneral($result['result']);
        endif;
        
    }
    
    private function flashMessageGeneral($result){
        
        if($result == 'ok'):
            $this->addFlash('messageSuccess','Datos guardados correctamente');
        else:
            $this->addFlash('messageFail','Error al guardar');
        endif;
    }
}

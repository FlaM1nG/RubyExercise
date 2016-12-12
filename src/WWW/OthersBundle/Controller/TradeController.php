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
    private $trade;
    
    public function createOfferAction(Request $request){
        //print_r($request);
        $this->sesion = $request->getSession();
        
        $trade = new Trade();
        $formTrade = $this->createForm(TradeType::class,$trade);
        $formTrade->handleRequest($request);
        
         if($formTrade->isSubmitted()):
             
             //$this->trade = $trade;
        
             $this->saveTrade($request,$trade);
             echo "enviado";
             
         else: 
             echo "fallo";
         endif;
        
        return $this->render('OthersBundle:Trade:offerTrade.html.twig',
                       array('formTrade' => $formTrade->createView(),
                             'trade' => $trade));
    }
    
    private function saveTrade(Request $request, Trade $trade){
        //print_r($trade);
        
        $service = $request->server->all()['PATH_INFO'];
       
        $ch = new ApiRest();
        $file = "http://www.whatwantweb.com/api_rest/services/offer/insert_offer.php";
        $dataOffer = array("id" => $this->sesion->get('id'),
                      "username" => $this->sesion->get('username'),
                      "password" =>$this->sesion->get('password'),
                      "title" => $trade->getOffer()->getTitle(),
                      "description" => $trade->getOffer()->getDescription(),
                      "service_id" => 1);
        $dataTrade = array();
        
        $dataTrade['photos'] = array(1,2);
        
        
        $dataTrade['values'] = array("category_id" => $trade->getCategory()->getId(),
                           "price" => $trade->getPrice(),
                           "dimensions" => "'".$trade->getDimensions()."'",
                           "weight" => $trade->getWeight() );
        
        $this->uploadImage($request);
        /*$result = $ch->sendSeveralInformation($dataOffer, $dataTrade, $file);
        
        if($result['result'] == "ok"):
            $this->addFlash(
                                'messageOffer',
                                'Oferta guardada con éxito'
                            );
        else:
            $this->addFlash('messageOffer', 'Ha ocurrido un error');
        endif;
                */
    }
    
    private function uploadImage(Request $request){
        $file = "http://www.whatwantweb.com/api_rest/global/photo/add_photos.php";
        $arrayFiles = $request->files->all()['trade']['offer']['photos'][1]['fileImage'];
        $i = 1;
        
        if(($ficherosUsuario  = scandir('C:\xampp\img\user_1',1)) !== false):
            $i = count($ficherosUsuario)+1;
        print_r($ficherosUsuario);endif;
        foreach($arrayFiles as $file):
            echo $file->getPathname()."<br>";
        endforeach;
       
        //$dataFiles = $request->files->all()['profileUser']['photo'];
        
        
        
        $tmpName = $dataFiles->getPathname();
        $extension = $dataFiles->getClientoriginalExtension();
        
        $ficherosUsuario  = scandir('http://www.whatwantweb.com/img/user_'.$this->usuario->getId());
        $totalImg = coun($ficherosUsuario);
        $nameImg = 'image'.($totalImg+1).$extension;
            
        // almacenar imagen en el servidor
        //move_uploaded_file($tmpName,'http://www.whatwantweb.com/img/user_'.$this->usuario->getId().'/'.$nameImg);
    }
}

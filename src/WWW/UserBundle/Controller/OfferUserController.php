<?php

namespace WWW\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WWW\OthersBundle\Entity\Trade;
use WWW\OthersBundle\Form\TradeType;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\Entity\Utilities;
use WWW\GlobalBundle\Entity\Photo;

class OfferUserController extends Controller{
    
    private $service = null;
    private $offer = null;
    private $session = null;
    
   public function showOfferAction(Request $request){ 
       $this->session = $request->getSession();
       
       $arrayOffer = $this->searchOffer($request->get('idOffer'));
       
       $this->service = $arrayOffer['service'];
       $this->offer = $arrayOffer['offer'];
       $formulario = $this->createForm(TradeType::class,$this->offer);
       $typeService = "";
       
       if($this->service == 1):                      
            
            $typeService = 'trade';
            $formulario = $this->createForm(TradeType::class,$this->offer);
       endif;
       
       $formulario->handleRequest($request);
       
       if($formulario->isSubmitted()):
          
           $this->saveOffer($request);
       endif;
       
       return $this->render('UserBundle:Offers:'.$typeService.'.html.twig',
                       array('formulario' => $formulario->createView(),
                             'offer' => $this->offer));
   }

   private function searchOffer($id){
       $file = "http://www.whatwantweb.com/api_rest/services/offer/get_offer.php";
       $arrayOffer = null;
       $offer = null;
       
       $ch = new ApiRest();
       $data['id'] = $id;
       $result = $ch->resultApiRed($data, $file);
     
       $this->flashMessageErrorSearch($result);
       
       $arrayOffer['service'] = $result['service_id'];
      
       if($result['service_id'] == 1):
            $offer = new Trade($result,true);
            $utility = new Utilities();
            $arrayCategory = $utility->getArrayCategoryTrade();
            $offer->setCategory($arrayCategory[$result['category_id']]);
       endif; 
       
       $arrayOffer['offer'] = $offer;
       
       return $arrayOffer;
   }
   
   private function saveOffer(Request $request){
       
       switch ($this->service):
           case 1: $this->saveTrade($request);
                   break; 
       endswitch;
       
   }
   
    private function saveTrade(Request $request){
        $arrayImage = $request->files->get('trade')['offer']['fileImage'];   
        $ch = new ApiRest();
        $file = "http://www.whatwantweb.com/api_rest/services/offer/update_offer.php";
        
        $info['id'] = $this->session->get('id');
        $info['username'] = $this->session->get('username');
        $info['password'] = $this->session->get('password');
        $info['offer_id'] = $this->offer->getId();
 
        $data['values']['title'] = "'".$this->offer->getOffer()->getTitle()."'"; 
        $data['values']['description'] = "'".$this->offer->getOffer()->getDescription()."'"; 
        $data['sub_values']['price'] = $this->offer->getPrice();
        $data['sub_values']['dimensions'] = "'".$this->offer->getDimensions()."'";
        $data['sub_values']['weight'] = $this->offer->getWeight();
        $data['sub_values']['region'] = "'".$this->offer->getRegion()."'";
        
        $info['data']= json_encode($data);
       
        $result = $ch->resultApiRed($info, $file);
        
        if($result['result'] == 'ok'):
            if(!empty($arrayImage[0])):
                $ids = $this->uploadImage ($arrayImage);
                $this->insertPhotoOffer($ids);
            endif;
        endif;
   }
   
    private function uploadImage($arrayImage){
        $arrayPhotos = null;
        $ut = new Utilities();
        $arrayPhotos = $ut->uploadImage($arrayImage, $this->session->get('id'));
        
        $filePhotos = "http://www.whatwantweb.com/api_rest/global/photo/add_photos.php";
        
        $ch = new ApiRest();
        
        $data['url'] = $arrayPhotos; 
        $informacion['data'] = json_encode($data);
        $result = $ch->resultApiRed($informacion, $filePhotos);

        print_r($result);
        if($result['result'] == 'ok'):
            $idsPhotos = '';
            
            foreach($result['photos'] as $photo):
               $objectPhoto = new Photo($photo);
               $this->offer->getOffer()->addPhoto($objectPhoto); 
               $idsPhotos .= $photo['id'].",";
            endforeach;
            
            $idsPhotos = substr($idsPhotos, 0, -1);
           
            return $idsPhotos;
        else:
            $this->flashMessageErrorSearch($result['result']);
        endif;
        
    }
    
    private function insertPhotoOffer($ids){
        
        $filePhotos = "http://www.whatwantweb.com/api_rest/services/photos/insert_offer_photo.php";
        
        $ch = new ApiRest();
        
        $info['id'] = $this->session->get('id');
        $info['username'] = $this->session->get('username');
        $info['password'] = $this->session->get('password');
        $info['offer_id'] = $this->offer->getId();
        $info['photos_id'] = $ids;

        $result = $ch->resultApiRed($info, $filePhotos);
        print_r($result);
        $this->flashMessageGeneral($result);   
    }
   
   private function flashMessageGeneral($result){
       
       if($result['result'] == 'ok'):
           $this->addFlash('messageSuccess','Datos actualizados correctamente');
        else:
            $this->addFlash('messageFail','Error al actualizar');
        endif;
           
   }
   
   private function flashMessageErrorSearch($result){
       
       if($result['result'] != 'ok')
            $this->addFlash('messageFail','Ups ha ocurrido algún problema, inténtelo de nuevo más tarde');
       
   }

}

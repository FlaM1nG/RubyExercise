<?php

namespace WWW\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WWW\OthersBundle\Entity\Trade;
use WWW\OthersBundle\Form\TradeType;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\Entity\Utilities;

class OfferUserController extends Controller{
    
   public function showOfferAction(Request $request){
       
       $arrayOffer = $this->searchOffer($request->get('idOffer'));
       $offer = $arrayOffer['offer'];
       $formulario = $this->createForm(TradeType::class,$offer);
       $typeService = "";
       
       if($arrayOffer['service'] == 1):                      
            
            $typeService = 'trade';
            $formulario = $this->createForm(TradeType::class,$offer);
       endif;
       
       
       
       $formulario->handleRequest($request);
       
       return $this->render('UserBundle:Offers:'.$typeService.'.html.twig',
                       array('formulario' => $formulario->createView(),
                             'offer' => $offer));
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
   
   
   private function flashMessageSaveDelete($result){
       
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

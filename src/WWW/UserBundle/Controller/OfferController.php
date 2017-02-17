<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace WWW\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WWW\CarsBundle\Entity\ShareCar;
use WWW\CarsBundle\Form\ShareCarType;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\Entity\Utilities;
use WWW\GlobalBundle\MyConstants;
use Symfony\Component\HttpFoundation\JsonResponse;
use WWW\ServiceBundle\Entity\Offer;
use WWW\OthersBundle\Entity\Trade;
use WWW\OthersBundle\Form\TradeType;
use WWW\ServiceBundle\Entity\Service;
use WWW\CarsBundle\Entity\Car;


/**
 * Description of OfferController
 *
 * @author Rocio
 */
class OfferController extends Controller{
    
    private $ut;
    private $offer;
    private $service;

    public function myOffersAction(Request $request){

        $offers = $this->listMyOffers($request);

        $paginator = $this->get('knp_paginator');
        $pagination = null;

        if(!empty($offers)):
            $pagination = $paginator->paginate(
                $offers,
                $request->query->getInt('page', 1),
                MyConstants::NUM_OFFERS_PROFILE
            );
        endif;

        return $this->render('UserBundle:Profile:offers/profileMyOffers.html.twig',
                       array('listOffers' => $offers,
                             'pagination' => $pagination));
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
        $pathRender = "";
        $form = $this->searchOffer($request);
        $form->handleRequest($request);

        if($form->isSubmitted()):
            $result = null;
            if($this->service <= 3):
                $result = $this->updateOfferTrade($request);
            elseif($this->service == 4):
                $result = $this->updateOfferShareCar($request);
            endif;

            if($result == 'ok'):
                return $this->redirectToRoute('user_profiler_offers');
            endif;
        endif;

        if($this->service <= 3):
            $pathRender = 'UserBundle:Profile:offers/profileEditOfferTrades.html.twig';
        elseif($this->service == 4):
            $pathRender = 'UserBundle:Profile:offers/profileEditOfferShareCar.html.twig';
        endif;

        return $this->render($pathRender,
                        array('form' => $form->createView(),
                              'service' => $this->service,
                              'offer' => $this->offer ));
    }

    private function updateOfferShareCar(Request $request){
        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST."services/offer/update_offer_photos.php";

        $info['id'] = $request->getSession()->get('id');
        $info['username'] = $request->getSession()->get('username');
        $info['password'] = $request->getSession()->get('password');
        $info['offer_id'] = $this->offer->getOffer()->getId();
        $info['inserted_photos_id'] = $this->offer->getCar()->getPhotos()[0]->getId();
        $info['deleted_photos_id'] = "all";

        $data['values']['title'] = "'".$this->offer->getOffer()->getTitle()."'";
        $data['values']['description'] = "'".$this->offer->getOffer()->getDescription()."'";
        $data['values']['holders'] = $this->offer->getOffer()->getHolders();

        $data['sub_values']['from_place'] = "'".$this->offer->getFromPlace()."'";
        $data['sub_values']['to_place'] = "'".$this->offer->getToPlace()."'";
        $data['sub_values']['price'] = $this->offer->getPrice();
        $data['sub_values']['car_id'] = $this->offer->getCar()->getId();
        $data['sub_values']["date"] = "'".$this->offer->getDate()->format("Y-m-d H:i")."'";
        if(!empty($this->offer->getBackTwo()))  $data['sub_values']["back_two"] = 1;


        $info['data']= json_encode($data);

        $result = $ch->resultApiRed($info, $file);

        $this->ut->flashMessage("general", $request, $result);
        
        return $result['result'];
    }

    private function updateOfferTrade(Request $request){

        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST."services/offer/update_offer_photos.php";

        $info['id'] = $request->getSession()->get('id');
        $info['username'] = $request->getSession()->get('username');
        $info['password'] = $request->getSession()->get('password');
        $info['offer_id'] = $this->offer->getId();

        $data['values']['title'] = "'".$this->offer->getOffer()->getTitle()."'";
        $data['values']['description'] = "'".$this->offer->getOffer()->getDescription()."'";

        if($this->service != 3):
//            $data['sub_values']['dimensions'] = "'".$request->get('trade')['width']."x".
//                                                    $request->get('trade')['height']."x".
//                                                    $request->get('trade')['long']."'";
            $data['sub_values']['weight'] = $this->offer->getWeight();
            $data['sub_values']['price'] = $this->offer->getPrice();
        endif;

        $data['sub_values']['region'] = "'".$this->offer->getRegion()->getRegion()."'";
        $data['sub_values']['category_id'] = $this->offer->getCategory()->getId();

        $info['data']= json_encode($data);

        if(!empty($request->files->get('imgOffer')[0])):
            $photos = $request->files->get('imgOffer');
            $count = 0;

            foreach($photos as $photo){
                $ch_photo = new \CURLFile($photo->getPathname(),$photo->getMimetype());
                $info['photos['.$count.']'] = $ch_photo;
                $count += 1;
            }
        endif;


        $result = $ch->resultApiRed($info, $file);
        $this->ut->flashMessage("general", $request, $result);

        return $result['result'];
    }

    private function searchOffer(Request $request){

       $file = MyConstants::PATH_APIREST."services/offer/get_offer.php";
       $ch = new ApiRest();

       $data['id'] = $request->get('idOffer');

       $result = $ch->resultApiRed($data, $file);

       $formulario = null;

        if($result['result'] == 'ok'):

            $this->service = $result['service_id'];

             if($result['service_id'] == 1 || $result['service_id'] == 2 || $result['service_id'] == 3):
                 $this->createTrade($result);
                 $formulario = $this->createForm(TradeType::class,$this->offer);

             elseif($result['service_id'] == 4):
                 $this->offer = new ShareCar($result);
                 $arrayCars = $this->getCarsUser($request);
                 $formulario = $this->createForm(ShareCarType::class ,$this->offer, array('listCar' => $arrayCars));
             endif;
        else:
            $this->ut->flashMessage("offer", $request, $result);
        endif;

        return $formulario;
   }

    private function getCarsUser(Request $request){

        $file = MyConstants::PATH_APIREST.'user/car/get_cars.php';
        $ch = new ApiRest();
        $arrayCars = null;

        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');

        $result = $ch->resultApiRed($data,$file);

        if($result['result'] == 'ok'):
            foreach($result['cars'] as $value):
                $car = new Car($value);
                $arrayCars[] = $car;
            endforeach;
        endif;

        return $arrayCars;

    }

   private function createTrade($result){

        $offer = new Trade($result);

        $arrayCategory = $this->ut->getArrayCategoryTrade($result['service_id']);

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

        $photos = $request->files->get('imgOffer');
        $count = 0;

        foreach($photos as $photo){
            $ch_photo = new \CURLFile($photo->getPathname(),$photo->getMimetype());
            $data['photos['.$count.']'] = $ch_photo;
            $count += 1;
        }


        $result = $ch->resultApiRed($data, $file);
//        print_r($result);

    }
   
   public function valorationOfferAction(Request $request){

       $file = MyConstants::PATH_APIREST."services/inscription/rate.php";
       $ch = new ApiRest();

       $rating = $request->get('rating');
       $idOffer = $request->get('idOffer');
       $comment = $request->get('comment');
       
       $data['id'] = $request->getSession()->get('id');
       $data['username'] = $request->getSession()->get('username');
       $data['password'] = $request->getSession()->get('password');
       $data['offer_id'] = $idOffer;
       $data['score'] = $rating;
       $data['comment'] = $comment;

       $result = $ch->resultApiRed($data, $file);

       if($result['result'] == 'ok'):

           return $this->forward('UserBundle:Offer:myOffers');

       else:
           $response = new JsonResponse();

           return $response;
       endif;


   }

    public function deleteOfferAction(Request $request){

        $id = $request->get('id');
        $session = $request->getSession();

        $response = new JsonResponse();

        $file = MyConstants::PATH_APIREST."services/offer/delete_offer.php";
        $ch = new ApiRest();

        $data['username'] = $session->get('username');
        $data['id'] = $session->get('id');
        $data['password'] = $session->get('password');
        $data['offer_id'] = $id;

        $result = $ch->resultApiRed($data, $file);

        if($result['result'] == 'ok'):
            $response->setData(array(
                'result' => 'ok',
                'message' => 'Oferta eliminada correctamente'));
        else:
            $response->setData(array(
                'result' => 'ko',
                'message' => 'Ha ocurrido un error, por favor vuelva a intentarlo'));
        endif;

        return $response;

    }
}

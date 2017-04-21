<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace WWW\OthersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WWW\GlobalBundle\Entity\Address;
use WWW\OthersBundle\Entity\Trade;
use WWW\OthersBundle\Form\TradeType;
use Symfony\Component\HttpFoundation\Request;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\Entity\Utilities;
use WWW\ServiceBundle\Entity\Comment;
use WWW\ServiceBundle\Form\CommentType;
use WWW\ServiceBundle\Entity\Offer;
use WWW\GlobalBundle\MyConstants;
use WWW\UserBundle\Entity\Message;
use WWW\UserBundle\Form\MessageType;
use WWW\UserBundle\Entity\User;
use WWW\ServiceBundle\Form\OfferSuscribeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Description of TradeController
 *
 * @author Rocio
 */
class TradeController extends Controller{
    
    private $session;
    private $trade;
    private $ut;
    private $service;
    
    public function createOfferAction(Request $request){
//        print_r($request);
//        print_r($request->headers->get('referer'));
//       echo "<br>". parse_url($request->headers->get('referer'),PHP_URL_PATH );

        $this->setUpVars($request);
        $arrayAddresses = null;

        if($this->service != 3):
            $arrayAddresses = $this->hasAddresses($request);
        endif;

        if(!empty($arrayAddresses)):

//            $request->getSession()->remove('_security.user.target_path');

            $trade = new Trade();

            $trade->getCategory()->setId($this->service);
            $trade->getOffer()->getService()->setId($this->service);
//print_r($arrayAddresses);
            $formTrade = $this->createForm(TradeType::class,$trade,array('arrayAddresses' => $arrayAddresses));

            $formTrade->handleRequest($request);

             if($formTrade->isSubmitted()):
                 $result = $this->saveTrade($request,$trade);

                 if($result == 'ok'):

                     if($this->service == 1):
                        return $this->redirectToRoute('service_listTrade');

                     elseif($this->service == 2):
                        return $this->redirectToRoute('service_listClothes');

                     elseif($this->service == 3):
                        return $this->redirectToRoute('service_listBarter');
                     endif;
                 endif;
             endif;
        
            return $this->render('OthersBundle:Trade:offerTrade.html.twig',
                           array('formOffer' => $formTrade->createView(),
                                 'offer' => $trade,
                                 'service' => $this->service,
                                 'addresses' => $arrayAddresses));

        else:

//            $route = $request->get('_route');
//
//            $request->getSession()->set('_security.user.target_path',$route);

            return $this->render('OthersBundle:Trade:offerTrade.html.twig',
                            array('service' => $this->service,
                                  'addresses' => $arrayAddresses));
        endif;
    }

    public function setUpVars(Request $request){
        
        $this->ut = new Utilities(); 
        $this->session = $request->getSession();
        $this->trade = null;

        $path = $request->getPathInfo();
 
        if(strstr($path,'trade')!== false): 
            $this->service = 1;
        elseif(strstr($path,'barter')!== false):
            $this->service = 3;
        else:
            $this->service = 2;
        endif;

    }
    
    private function saveTrade(Request $request, Trade $trade){

        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST."services/offer/insert_offer.php";

        $dataOffer = array("id" => $this->session->get('id'),
                            "username" => $this->session->get('username'),
                            "password" =>$this->session->get('password'),
                            "title" => $trade->getOffer()->getTitle(),
                            "description" => $trade->getOffer()->getDescription(),
                            "service_id" => $this->service,
                            "holders" => 1);

        $dataExtra["category_id"] = $trade->getCategory()->getId();
        $dataExtra["region"] = "'".$trade->getAddress()->getRegion()."'";
        $dataExtra["price"] = 0;
  
        if($this->service != 3):
            $dataExtra["price"] = $trade->getPrice();
            $dataExtra["address_id"] = $trade->getAddress()->getId();
//            $dataExtra["dimensions"] = "'".$request->get('trade')['width']."x".
//                                                   $request->get('trade')['height']."x".
//                                                   $request->get('trade')['long']."'";
            $dataExtra["weight"] = $trade->getWeight();
        endif;

        if(!empty($request->files->get('imgOffer')[0])):
            $photos = $request->files->get('imgOffer');
            $count = 0;

            foreach($photos as $photo){
                $ch_photo = new \CURLFile($photo->getPathname(),$photo->getMimetype());
                $dataOffer['photos['.$count.']'] = $ch_photo;
                $count += 1;
            }
        endif;

        $dataOffer['data'] = json_encode($dataExtra);

        $result = $ch->resultApiRed($dataOffer, $file);

        $this->ut->flashMessage("general", $request, $result);
print_r($result);
        return $result['result'];
    }
    
    public function listTradeAction(Request $request){

        $this->setUpVars($request);
        $varPost = $request->query->all();

        $title = '';

        if($this->service == 1):
            $title = 'Compra-Venta';
        elseif($this->service == 2):
            $title = 'Compra-Venta de Ropa';
        elseif($this->service == 3):
            $title = 'Trueque';
        endif;
        
        $data['service_id'] = $this->service;
        $data['search'] = '';
        
        if(!empty($varPost)):
            
            if(!empty($request->query->get('object')))
                $data['search'] = $request->query->get('object');
            
            if(!empty($request->query->get('city')))
                $data['filters']['location'] = $request->query->get('city'); 
            
            if(!empty($request->query->get('minPrice'))):
                $data['filters']['min_price'] = (int)$request->query->get('minPrice'); 
            endif;
            
            if(!empty($request->query->get('maxPrice')))
                $data['filters']['max_price'] = (int)$request->query->get('maxPrice'); 
            
            if(array_key_exists('category', $varPost)):
                foreach($request->query->get('category') as $cat):
                    $data['filters']['categories'][] = (int)$cat;
                endforeach;
            endif;
        else:
            $data['filters']['sort'] = 'date';
             
        endif;
        
        $arrayOffers = $this->searchTrades($data);

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $arrayOffers,
            $request->query->getInt('page', 1),
            MyConstants::NUM_TRADES_PAGINATOR
        );

        /* ARRAYTRADES NO HACE FALTA PORQUE VA DENTRO DE PAGINATION  */
        return $this->render('services/serTrade.html.twig',array(
//                            'arrayTrades' => $arrayOffers,
                            'categories' => $this->ut->getArrayCategoryTrade($this->service),
                            'title' => $title,
                            'service' => $this->service,
                            'pagination' => $pagination
                            ));
    }
    
    private function searchTrades($data){
        
        $arrayOffers = array();
        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST."services/trade/list_trades.php";

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

        $this->setUpVars($request);

        $this->getTrade($request);

        $comment = new Comment();
        $message = $this->fillMessage();

        $formComment = $this->createForm(CommentType::class, $comment);
        $formMessage = $this->createForm(MessageType::class, $message);
        $formSubscribe = $this->createForm(OfferSuscribeType::class);

        $formComment->handleRequest($request);
        $formMessage->handleRequest($request);
        $formSubscribe->handleRequest($request);

        if($formComment->isSubmitted()):

            $result = $this->saveComment($request, $this->trade->getOffer()->getId(), $comment);
            $formComment = $this->createForm(CommentType::class, new Comment());
            
            if($result == 'ok'):
                return $this->redirectToRoute('service_trade',array('idOffer'=> $this->trade->getOffer()->getId()));
            endif;
        
        elseif($formMessage->isSubmitted()):
            $this->sendMessage($request);

        elseif($formSubscribe->isSubmitted()):
            $this->offerSubscribe($this->trade);
            return $this->redirectToRoute('acme_payment_homepage', array(
                'idOffer'=> $this->trade->getOffer()->getId(),
                'service'=> "trade",
                    ));
        endif;

        $paginator = $this->get('knp_paginator');
        $pagination = null;

        if(!empty($this->trade->getOffer()->getComments())):
            $pagination = $paginator->paginate(
                $this->trade->getOffer()->getComments(),
                $request->query->getInt('page', 1),
                MyConstants::NUM_COMMENTS_PAGINATOR
            );
        endif;

        return $this->render('offer/offTrade.html.twig',array(
                             'offer' => $this->trade,
                             'formComment' => $formComment->createView(),
                             'formMessage' => $formMessage->createView()  ,
                             'formSubscribe' => $formSubscribe->createView(),
                             'service' => $this->service,
                             'pagination' => $pagination,
                             'numComment' => MyConstants::NUM_COMMENTS_PAGINATOR
        ));
    }

    private function fillMessage(){
        $message = new Message();
        
        $user = new User();
        $user->setId($this->session->get('id'));
        $user->setUsername($this->session->get('username'));
        
        $userTo = new User();
        $userTo->setId($this->trade->getOffer()->getUserAdmin()->getId());
        $userTo->setUsername($this->trade->getOffer()->getUserAdmin()->getUsername());
        
        $message->setFrom($user);
        $message->setTo($userTo);
        $message->setSubject('Oferta: '.$this->trade->getOffer()->getTitle());
        
        return $message;
    }
    
    private function getTrade($request){
        
        $this->setUpVars($request);
        
        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST."services/offer/get_offer.php";

        $trade = null;
       
        $data['id'] = $request->get('idOffer');
        
        $result = $ch->resultApiRed($data, $file);
         
        if($result['result'] == 'ok'):
            $this->trade = new Trade($result);

        else:
            $this->ut->flashMessage("general", $request);
        endif;

    }

    
    private function saveComment(Request $request, $idOffer, $comment){
        
        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST."services/inscription/comment.php";
        
        $data['id'] = $this->session->get('id');
        $data['username'] = $this->session->get('username');
        $data['password'] = $this->session->get('password');
        $data['offer_id'] = $idOffer;
        $data['comment'] = $comment->getComment();
        
        $result = $ch->resultApiRed($data, $file);

        if($result['result'] == 'ok'):
            return $result['result'];
        else:
            $this->ut->flashMessage("comment", $request, $result);
        endif;

    }
    
    private function sendMessage(Request $request){
        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST."user/messages/send_message.php";
        
        $data['id'] = $this->session->get('id');
        $data['username'] = $this->session->get('username');
        $data['password'] = $this->session->get('password');
        $data['to'] = $this->trade->getOffer()->getUserAdmin()->getUsername();
        $data['subject'] = $request->get('message')['subject'];
        $data['message'] = $request->get('message')['message'];
        $data['offer'] = $this->trade->getOffer()->getId();
        
        $result = $ch->resultApiRed($data, $file);
        
        $this->ut->flashMessage("message", $request, $result);
    }
    
    private function offerSubscribe($trade){
        
        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST."services/inscription/subscribe_user.php";
        
        $data = $this->formArrayData();
        $data['offer_id'] = $trade->getOffer()->getId();
        
        $result = $ch->resultApiRed($data, $file);

    }
    
    private function formArrayData(){
        
        $data['id'] = $this->session->get('id');
        $data['username'] = $this->session->get('username');
        $data['password'] = $this->session->get('password');
        
        return $data;
    }

    private function hasAddresses(Request $request){

        $file = MyConstants::PATH_APIREST.'user/data/get_info_user.php';
        $ch = new ApiRest();

        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        $data['info'] = 'addresses';

        $result = $ch->resultApiRed($data, $file);

        if(!empty($result['addresses'])):

            foreach($result['addresses'] as $key => $value):
                $address = new Address($value);
                $arrayAddress[$key] = $address;
            endforeach;

            return $arrayAddress;

        else:
            return null;
        endif;    
    }
    
    /**
     * @Route("/ajax/rating", name="ajax_rating")
     * @Method({"POST"})
     */
    
//    public function pruebaAction(Request $request){
//        $newRating = $request->get('rating');
//
//        $ch = new ApiRest();
//        $file = MyConstants::PATH_APIREST."services/inscription/rate.php";
//
//        $data = $this->formArrayData();
//
//        $response = new JsonResponse();
//        return $response;
//    }
}

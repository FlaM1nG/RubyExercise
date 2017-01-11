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
use WWW\ServiceBundle\Entity\Comment;
use WWW\ServiceBundle\Form\CommentType;
use WWW\GlobalBundle\MyConstants;
use WWW\UserBundle\Entity\Message;
use WWW\UserBundle\Form\MessageType;
use WWW\UserBundle\Entity\User;

/**
 * Description of TradeController
 *
 * @author Rocio
 */
class TradeController extends Controller{
    
    private $session;
    private $trade;
    private $ut;
    
    public function createOfferAction(Request $request){

        $this->setUpVars($request);
        $trade = new Trade();
        
        $this->denyAccessUnlessGranted('create_offer', $trade);
        
        $formTrade = $this->createForm(TradeType::class,$trade);
        $formTrade->handleRequest($request);
        
         if($formTrade->isSubmitted()):
             
             $this->saveTrade($request,$trade);
         endif;
        
        return $this->render('OthersBundle:Trade:offerTrade.html.twig',
                       array('formTrade' => $formTrade->createView(),
                             'trade' => $trade));
    }
    
    public function setUpVars(Request $request){
        $this->ut = new Utilities(); 
        $this->session = $request->getSession();
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
            $file = MyConstants::PATH_APIREST."services/offer/insert_offer.php";
            $dataOffer = array("id" => $this->session->get('id'),
                             "username" => $this->session->get('username'),
                            "password" =>$this->session->get('password'),
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
                $arrayUrls = $this->ut->uploadImage($arrayFiles, $this->session->get('id'));
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
       
        $this->setUpVars($request);
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
        
        $trade = null;
        $trade = $this->getTrade($request);
//        print_r($trade);
        $comment = new Comment();
        $message = $this->fillMessage($trade);
        
        $formComment = $this->createForm(CommentType::class, $comment);
        $formMessage = $this->createForm(MessageType::class, $message);
        
        $formComment->handleRequest($request);
        $formMessage->handleRequest($request);
        
        if($formComment->isSubmitted()):
            $this->saveComment($request, $trade->getOffer()->getId());
            $formComment = $this->createForm(CommentType::class, new Comment());
            
        elseif($formMessage->isSubmitted()):
            $this->sendMessage($request,$trade);
            echo "ENTRO";
            //($message);
        endif;
        
        return $this->render('offer/offTrade.html.twig',array(
                             'trade' => $trade,
                             'formComment' => $formComment->createView(),
                             'formMessage' => $formMessage->createView()   
        ));
    }
    
    private function fillMessage($trade){
        $message = new Message();
        
        $user = new User();
        $user->setId($this->session->get('id'));
        $user->setUsername($this->session->get('username'));
        
        $userTo = new User();
        $userTo->setId($trade->getOffer()->getUserAdmin()->getId());
        $userTo->setUsername($trade->getOffer()->getUserAdmin()->getUsername());
        
        $message->setFrom($user);
        $message->setTo($userTo);
        $message->setSubject('Oferta: '.$trade->getOffer()->getTitle());
        
        return $message;
    }
    
    private function getTrade($request){
        
        $this->setUpVars($request);
        
        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST."services/trade/get_trade.php";

        $trade = null;
       
        $data['id'] = $request->get('idOffer');
        
        $result = $ch->resultApiRed($data, $file);
        
         
        if($result['result'] == 'ok'):
            $trade = new Trade($result);
        
        else:
            $this->ut->flashMessage("general", $request);
        endif;
        
        return $trade;
    }
    
    private function listComments(){
        
    }
    
    private function saveComment(Request $request, $idOffer){
        
        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST."services/inscription/comment.php";
        
        $data['id'] = $this->session->get('id');
        $data['username'] = $this->session->get('username');
        $data['password'] = $this->session->get('password');
        $data['offer_id'] = $idOffer;
        $data['comment'] = $request->get('comment')['comment'];
        
        $result = $ch->resultApiRed($data, $file);

        $this->ut->flashMessage("comment", $request, $result);
    }
    
    private function sendMessage(Request $request, $trade){
        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST."user/messages/send_message.php";
        
        $data['id'] = $this->session->get('id');
        $data['username'] = $this->session->get('username');
        $data['password'] = $this->session->get('password');
        $data['to'] = $trade->getOffer()->getUserAdmin()->getUsername();
        $data['subject'] = $request->get('message')['subject'];
        $data['message'] = $request->get('message')['message'];
        
        print_r($data);
    }
}

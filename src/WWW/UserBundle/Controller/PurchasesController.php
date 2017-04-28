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
use WWW\ServiceBundle\Entity\Cancelation;
use WWW\ServiceBundle\Form\CancelationType;

/**
 * Description of PurchasesController
 *
 * @author Rocio
 */
class PurchasesController extends Controller{
    
    public function myPurchasesAction(Request $request){

        $service = $request->get('typeOffer');

        $cancelation = new Cancelation();
        $formCancelation = $this->createForm(CancelationType::class, $cancelation);

        $purchases = $this->getPurchases($request, $service);

        $paginator = $this->get('knp_paginator');
        $pagination = null;


        if(!empty($purchases)):
            $pagination = $paginator->paginate(
                $purchases,
                $request->query->getInt('page', 1),
                MyConstants::NUM_OFFERS_PROFILE
            );
        endif;

        return $this->render('UserBundle:Profile:offers/profileMyPurchase.html.twig',
                       array('purchases' => $purchases,
                             'pagination' => $pagination,
                             'formCancelation' => $formCancelation->createView())
        );
        
        
    }
    
    private function getPurchases(Request $request, $service = null){

        $file = MyConstants::PATH_APIREST."services/inscription/get_inscriptions.php";
        $ch = new ApiRest();

        $data['username'] = $request->getSession()->get('username');
        $data['id'] = $request->getSession()->get('id');
        $data['password'] = $request->getSession()->get('password');

        if(!empty($service) || $service == 'all'):
            $data['service'] = $service;
        endif;

        $result = $ch->resultApiRed($data, $file);

        if($result['result'] == 'ok')
            return $result['inscriptions'];
        else return null;
    }
    
    private function getOffer(Request $request){
        $file = MyConstants::PATH_APIREST."services/offer/offer_valorated.php";
        $ch = new ApiRest();
        
        
        $data['username'] = $request->getSession()->get('username');        
        $data['password'] = $request->getSession()->get('password');        
        $data['id'] = $request->getSession()->get('id');
        $data['offer_id'] = $request->get('idOffer');
        
        $result = $ch->resultApiRed($data,$file);
        return $result;
    }

    public function valorationAction(Request $request){
        
        $result = $this->getOffer($request);

        return $this->render('UserBundle:Profile:offers/profileValorationOffer.html.twig',
                        array('title' => $result[0]['title'],
                              'description' => $result[0]['description'],
                              'urlImage' => $result[0]['photo_url'],
                              'valorated_by_me'=> $result [0]['valorated_by_me']
                ));
    }

    public function offerEnjoyedAction(Request $request){

        $file = MyConstants::PATH_APIREST.'services/inscription/transition.php';
        $ch = new ApiRest();
        $response = new JsonResponse();

        $idOffer = $request->get('idOffer');

        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        $data['user_id'] = $data['id'];
        $data['offer_id'] = $idOffer;
        $data['status'] = 5;

        $result = $ch->resultApiRed($data, $file);

        if($result['result'] == 'ok'):

            $response->setData(array('result' => 'ok',
                                     'message' => 'Nos alegramos de que la haya disfrutado'));
        else:
            $response->setData(array('result' => 'ko',
                                     'message' => 'Se ha producido un error, por favor vuelva a intentarlo más tarde'));
        endif;

        return $response;

    }

    public function cancelOfferPurchaseAction(Request $request){

        $file = MyConstants::PATH_APIREST.'services/trade/cancel_trade.php';
        $ch = new ApiRest();
        $response = new JsonResponse();
        $ut = new Utilities();

        $concept = $request->get('concept');
        $offerId = $request->get('offerId');

        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        $data['user_id'] = $data['id'];
        $data['offer_id'] = $offerId;
        $data['concept'] = $concept;

        $result = $ch->resultApiRed($data,$file);

        if($result['result'] == 'ok'):
            $ut->flashMessage('Cancelación realizada con éxito', $request,$result);
            $response->setData(array('result' => 'ok'));
        else:
            $response->setData(array('result' => 'ko', 'message' => 'No se ha podido llevar a cabo la cancelación, por 
            favor inténtelo más tarde. En caso de que siga teniendo problemas póngase en contacto con nuestro servicio 
            de atención al cliente'));
        endif;

        return $response;
    }
}

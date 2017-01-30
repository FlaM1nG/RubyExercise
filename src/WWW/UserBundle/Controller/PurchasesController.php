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

/**
 * Description of PurchasesController
 *
 * @author Rocio
 */
class PurchasesController extends Controller{
    
    public function myPurchasesAction(Request $request){
        
        $purchases = $this->getPurchases($request);
        
        return $this->render('UserBundle:Profile:offers/profileMyPurchase.html.twig',
                       array('purchases' => $purchases)  
        );
        
        
    }
    
    private function getPurchases(Request $request){
        $file = MyConstants::PATH_APIREST."services/inscription/get_inscriptions.php";
        $ch = new ApiRest();
        
        $data['username'] = $request->getSession()->get('username');
        $data['id'] = $request->getSession()->get('id');
        $data['password'] = $request->getSession()->get('password');
        
        $result = $ch->resultApiRed($data, $file);
        
        return $result['inscriptions'];
    }

    public function valorationAction(Request $request){

        return $this->render('UserBundle:Profile:offers/profileValorationOffer.html.twig');
    }
}

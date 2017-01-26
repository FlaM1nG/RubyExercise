<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace WWW\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\Entity\Utilities;
use WWW\GlobalBundle\MyConstants;
use WWW\ServiceBundle\Entity\Offer;

/**
 * Description of InscriptionsController
 *
 * @author Rocio
 */
class InscriptionsController extends Controller{
    
    public function myInscriptionsAction(Request $request){
        
//        $inscriptions = $this->getInscriptios($request);
        
        return $this->render('UserBundle:Profile:offers/profileMyInscriptions.html.twig');
//        ,
//                       array('inscriptions' => $inscriptions));
    }
    
    private function getInscriptios(Request $request){
        
        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST."services/inscription/get_inscriptions.php";
        $arrayOffers = null;
        
        $data['username'] = $request->getSession()->get('username');
        $data['id'] = $request->getSession()->get('id');
        $data['password'] = $request->getSession()->get('password');
        
        $result = $ch->resultApiRed($data, $file);
        
//        foreach($result['inscriptions'] as $inscription):
//            $offer = new Offer($inscription);
//            $arrayOffers[] = $offer;
//        endforeach;
    }
}

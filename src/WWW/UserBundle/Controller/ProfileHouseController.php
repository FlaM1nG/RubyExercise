<?php
/**
 * Created by PhpStorm.
 * User: Rocio
 * Date: 24/02/2017
 * Time: 14:15
 */

namespace WWW\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use WWW\CarsBundle\Entity\Car;
use WWW\CarsBundle\Form\CarType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\Entity\Utilities;
use WWW\GlobalBundle\MyConstants;
use Symfony\Component\HttpFoundation\JsonResponse;
use WWW\HouseBundle\Entity\House;
use WWW\HouseBundle\Form\HouseType;


class ProfileHouseController extends Controller{
    
    public function createHouseAction(Request $request){

        $house = new House();

        $form = $this->createForm(HouseType::class, $house);

        $form->handleRequest($request);

        return $this->render('UserBundle:Profile/House:profileNewHouse.html.twig',
                            array('form' => $form->createView()));
        
    }

}
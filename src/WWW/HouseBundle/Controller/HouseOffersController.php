<?php
/**
 * Created by PhpStorm.
 * User: Rocio
 * Date: 07/03/2017
 * Time: 15:59
 */

namespace WWW\HouseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HouseOffersController extends Controller
{
    public function createNewOfferAction(){
        $this->render("HouseBundle::newOfferHouseRent.html.twig", array(
                      'service' => 6
        ));
    }
}
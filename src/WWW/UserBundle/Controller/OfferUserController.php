<?php

namespace WWW\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validation;
use WWW\UserBundle\Entity\User as User;
use WWW\GlobalBundle\Entity\ApiRest;

class OfferUserController extends Controller{
    
   public function showOfferAction(Request $request){
       echo "<br>ENTRO<BR>";
   }


}

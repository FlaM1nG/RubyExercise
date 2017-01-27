<?php
/**
 * Created by PhpStorm.
 * User: Rocio
 * Date: 26/01/2017
 * Time: 10:15
 */

namespace WWW\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\MyConstants;
use WWW\UserBundle\Entity\User;

class PublicProfileController extends Controller{

    public function publicProfileAction(Request $request){

        $profile = $this->getInfoPublicProfile($request);
        return $this->render('UserBundle:Profile:publicProfile.html.twig',
                       array('profile' => $profile));
    }
    
    private function getInfoPublicProfile(Request $request){

        $file = MyConstants::PATH_APIREST.'user/data/get_other_user.php';
        $ch = new ApiRest();
        
        $data['username'] = $request->get('username');

        $result = $ch->resultApiRed($data,$file);
        
        return $result;

    }

}
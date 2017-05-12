<?php
/**
 * Created by PhpStorm.
 * User: Rocio
 * Date: 09/05/2017
 * Time: 11:15
 */

namespace WWW\UserBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\Entity\Utilities;
use WWW\GlobalBundle\MyConstants;

class profilePurseController extends Controller{

    public function listPurseAction(Request $request){
        
        $result = $this->getPurseUser($request);

        return $this->render('@User/Profile/profilePurse.html.twig',
                            array('arrayLogs' => $result['logs'],
                                  'wallet' => $result['wallet']));

    }

    private function getPurseUser(Request $request){

        $file = MyConstants::PATH_APIREST.'user/data/get_wallet.php';
        $ch = new ApiRest();
        
        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');

        $result = $ch->resultApiRed($data, $file);

        if($result['result'] != 'ok'):
            $ut = new Utilities();
            $ut->flashMessage('', $request, $result,'Oops, ha ocurrido un problema');
        endif;

        return $result;
    }

}
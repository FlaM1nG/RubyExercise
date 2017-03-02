<?php
/**
 * Created by PhpStorm.
 * User: Rocio
 * Date: 24/02/2017
 * Time: 14:15
 */

namespace WWW\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Util\Inflector as Inflector;
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

        if($form->isSubmitted()):
            $result = $this->saveNewHouse($request);

            if($result == 'ok'):
                $this->redirectToRoute('user_profile_listHouse');
            endif;
        endif;

        return $this->render('UserBundle:Profile/House:profileNewHouse.html.twig',
                            array('form' => $form->createView()));
        
    }

    private function saveNewHouse(Request $request){
        $file = MyConstants::PATH_APIREST.'user/house/insert_house.php';
        $ch = new ApiRest();
        $ut = new Utilities();
        
        $arrayFields = $request->request->all()['house'];
        $auxAddress = explode('-',$arrayFields['address']['country']);

        $data['id_user'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        $data['address']['city'] = "'".$arrayFields['address']['city']."'";
        $data['address']['street'] = "'".$arrayFields['address']['street']."'";
        $data['address']['zip_code'] = $arrayFields['address']['zipCode'];
        $data['address']['country'] = "'".$auxAddress[0]."'";
        $data['address']['region'] = "'".$auxAddress[1]."'";

        foreach($arrayFields as $key => $value):
            $key = Inflector::tableize($key);

            if($key != 'address' AND $key !='save_new_house' AND $key != '_token'):
                if(is_numeric($value)):
                    $data[$key] = $value;
                else:
                    $data[$key] = "'".$value."'";
                endif;
            endif;
        endforeach;

        $info['data'] = json_encode($data);

        if(!empty($request->files->get('house')['imgHouse'])):
            $photos = $request->files->get('house')['imgHouse'];
            $count = 0;

            foreach($photos as $photo){
                $ch_photo = new \CURLFile($photo->getPathname(),$photo->getMimetype());
                $info['photos['.$count.']'] = $ch_photo;
                $count += 1;
            }
        endif;

        $result = $ch->resultApiRed($info,$file);

        $ut->flashMessage('Casa creada con éxito',$request,$result,null);

        return $result['result'];
    }
    
    public function listHousesAction(Request $request){

        $arrayHouses = $this->getHouseUser($request);

        return $this->render('UserBundle:Profile/House:profileListHouse.html.twig',array(
                             'arrayHouses' => $arrayHouses
                             ));
    }

    private function getHouseUser(Request $request){

        $file = MyConstants::PATH_APIREST.'user/house/get_houses.php';
        $ch = new ApiRest();
        $ut = new Utilities();

        $arrayHouse = array();
        
        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        
        $result = $ch->resultApiRed($data, $file);
        
        print_r($result);

        if($result['result'] == 'ok'):

            foreach($result['houses'] as $datas):
                $house = new House($datas);
                $arrayHouse[] = $house;
            endforeach;

        endif;

        return $arrayHouse;
    }

}
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
use Symfony\Component\HttpFoundation\Response;
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
                return $this->redirectToRoute('user_profile_listHouse');
            endif;
        endif;

        return $this->render('UserBundle:Profile/House:profileNewHouse.html.twig',
                            array('form' => $form->createView(),
                                  'house' => $house));
        
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

        $file = MyConstants::PATH_APIREST.'user/house/get_houseUserList.php';
        $ch = new ApiRest();

        $arrayHouse = array();
        
        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
       
        $result = $ch->resultApiRed($data, $file);

        if($result['result'] == 'ok'):

            foreach($result['houses'] as $datas):
                $house = new House($datas);
                $arrayHouse[] = $house;
            endforeach;

        endif;

        return $arrayHouse;
    }

    public function editHouseAction(Request $request){
        $house = $this->getHouse($request);

        $form = $this->createForm(HouseType::class,$house);

        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid()):
            $result = $this->updateHouse($request, $house);

            if($result == 'ok'):
                return $this->redirectToRoute('user_profile_listHouse');
            endif;
        endif;

        return $this->render('UserBundle:Profile/House:profileNewHouse.html.twig',array(
                             'form' => $form->createView(),
                             'house' => $house,
        ));
    }

    private function getHouse(Request $request){

        $file = MyConstants::PATH_APIREST.'user/house/get_house.php';
        $ch = new ApiRest();
        $house = null;

        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        $data['house_id'] = $request->get('idHouse');

        $result = $ch->resultApiRed($data,$file);

        if($result['result'] == 'ok'):
            $house = new House($result);
        endif;

        return $house;

    }

    private function updateHouse(Request $request, House $house){

        $file = MyConstants::PATH_APIREST.'/user/house/update_house_photo.php';
        $ch = new ApiRest();
        $ut = new Utilities();

        $arrayAttr = $house->getAttr();

        $data['id_user'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        $data['address']['city'] = "'".$house->getAddress()->getCity()."'";
        $data['address']['zip_code'] = $house->getAddress()->getZipCode();
        $data['address']['region'] = "'".$house->getAddress()->getRegion()."'";
        $data['address']['country'] = "'".$house->getAddress()->getCountry()->getCountry()."'";
        $data['address']['street'] = "'".$house->getAddress()->getStreet()."'";

        foreach($arrayAttr as $attr):

            $aux = Inflector::tableize($attr);
            if($attr == 'detectorCO') $aux = 'detector_co';

            $f = 'get'.ucfirst($attr);

            if(!empty($house->$f())):
                if($attr == 'description' || $attr == 'licenseNumber' || $attr == 'title'):
                    $data[$aux] = "'".$house->$f()."'";
                elseif(is_bool($house->$f())):
                    $data[$aux] = 1;
                else:
                    $data[$aux] = $house->$f();
                endif;

            else:
                $data[$aux] = 0;
            endif;    
        endforeach;

        $info['data'] = json_encode($data);

        if(!empty($request->files->get('house')['imgHouse'][0])):
            $photos = $request->files->get('house')['imgHouse'];
            $count = 0;

            foreach($photos as $photo){
                $ch_photo = new \CURLFile($photo->getPathname(),$photo->getMimetype());
                $info['photos['.$count.']'] = $ch_photo;
                $count += 1;
            }
        endif;

        $result = $ch->resultApiRed($info, $file);

        $ut->flashMessage('general',$request,null);

        return $result['result'];
    }

    public function showHouseAction(Request $request){

        $house = null;

        $house = $this->getHouse($request);

        return $this->render('UserBundle:Profile/House:profileObjectHouse.html.twig',array(
                             'house' => $house
        ));
    }

    public function deleteHouseAction(Request $request){
        $response = new JsonResponse();

        $id = $request->get('id');
        $file = MyConstants::PATH_APIREST.'user/house/delete_house.php';
        $ch = new ApiRest();

        $data['id_user'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        $data['id'] = $id;

        $result = $ch->resultApiRed($data,$file);

        if($result['result'] == 'ok'):
            $response->setData(array(
                'result' => 'ok',
                'message' => 'Datos actualizados correctamente'));
        else:
            $response->setData(array(
                'result' => 'ko',
                'message' => 'Ha ocurrido un error, por favor vuelva a intentarlo'));
        endif;

        return $response;

    }

    public function deleteImgHouseAction(Request $request){

        $response = new JsonResponse();

        $id = $request->get('id');
        $key = $request->get('key');
        $file = MyConstants::PATH_APIREST.'user/house/delete_house_photo.php';
        $ch = new ApiRest();

        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        $data['house_id'] = $id;
        $data['photos_id'] = $key;

        $result = $ch->resultApiRed($data,$file);

        if($result['result'] == 'ok'):
            $response->setData(array(
                'result' => 'ok',
                'message' => 'Datos actualizados correctamente'));
        else:
            $response->setData(array(
                'result' => 'ko',
                'message' => 'Ha ocurrido un error, por favor vuelva a intentarlo')
            );
        endif;

        return $response;
    }

}
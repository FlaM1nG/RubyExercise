<?php
/**
 * Created by PhpStorm.
 * User: Rocio
 * Date: 01/02/2017
 * Time: 12:49
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


class ProfileCarController extends Controller{

    public function newCarAction(Request $request){

        $car = new Car();

        $form = $this->createForm(CarType::class, $car);

        $form->handleRequest($request);

        if($form->isSubmitted()):
            $result = $this->saveNewCar($request, $car);

            if($result == 'ok'):
                return $this->redirectToRoute('user_profileListCars');
            endif;
        endif;

        return $this->render('UserBundle:Profile:Car/profileNewCar.html.twig',
            array('form' => $form->createView(),
                'car' => $car));
    }

    private function saveNewCar(Request $request, $car){

        $file = MyConstants::PATH_APIREST.'user/car/insert_car.php';
        $ch = new ApiRest();
        $ut = new Utilities();

        $data['username'] = $request->getSession()->get('username');
        $data['id_user'] = $request->getSession()->get('id');
        $data['password'] = $request->getSession()->get('password');
        $data['plate'] = "'".$car->getPlate()."'";
        $data['color'] = "'".$car->getColor()->getColor()."'";
        $data['description'] = "'".$car->getDescription()."'";
        $data['model_id'] = $car->getModel()->getId();
        $data['type'] = "'".$car->getType()."'";
        $data['seats'] = "'".$car->getSeats()."'";;

        if(!empty($car->getSmoke())):
            $data['smoke'] = 1;
        else:
            $data['smoke'] = 0;
        endif;

        if(!empty($car->getAnimals())):
            $data['animals'] = 1;
        else:
            $data['animals'] = 0;
        endif;

        if(!empty($car->getMusic())):
            $data['music'] = 1;
        else:
            $data['music'] = 0;
        endif;

        if(!empty($car->getTalk())):
            $data['talk'] = 1;
        else:
            $data['talk'] = 0;
        endif;

        $info['data']= json_encode($data);

        if(!empty($request->files->get('imgCar'))):
            $photos = $request->files->get('imgCar');
            $count = 0;

            foreach($photos as $photo){
                $ch_photo = new \CURLFile($photo->getPathname(),$photo->getMimetype());
                $info['photos['.$count.']'] = $ch_photo;
                $count += 1;
            }
        endif;

        $result = $ch->resultApiRed($info,$file);

        $ut->flashMessage('general',$request,$result);
        return $result['result'];
    }

    public function listCarAction(Request $request){
        $arrayCars = $this->getCarsUser($request);

        return $this->render('UserBundle:Profile:Car/profileListCar.html.twig',
            array('arrayCars' => $arrayCars));
    }

    private function getCarsUser(Request $request){

        $file = MyConstants::PATH_APIREST.'/user/car/get_cars.php';
        $ch = new ApiRest();
        $arrayCars = null;

        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');

        $result = $ch->resultApiRed($data, $file);

        foreach( $result['cars'] as $data):
            $car = new Car($data);
            $arrayCars[] = $car;
        endforeach;

        return $arrayCars;

    }

    public function editCarAction(Request $request){

        $car = $this->getCar($request);
        $car->setId((int)$car->getId());
        $form = $this->createForm(CarType::class,$car);

        $form->handleRequest($request);

        if($form->isSubmitted()):
            $result = $this->updateCar($request,$car);
            if($result == 'ok'): 
                return $this->redirectToRoute('user_profileListCars');
            endif;
        endif;

        return $this->render('UserBundle:Profile/Car:profileUpdateCar.html.twig',
            array('form' => $form->createView(),
                  'car' => $car ));

    }

    public function getCar(Request $request){
        $car = null;
        $id = $request->get('idCar');
        $file = MyConstants::PATH_APIREST.'/user/car/get_car.php';
        $ch = new ApiRest();

        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        $data['car_id'] = $id;

        $result = $ch->resultApiRed($data,$file);

        if($result['result'] == 'ok'):
            $car = new Car($result);
        endif;

        return $car;
    }

    public function updateCar(Request $request, Car $car){

        $file = MyConstants::PATH_APIREST.'/user/car/update_car_photo.php';
        $ch = new ApiRest();
        $ut = new Utilities();

        $data['id_user'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        $data['id'] = $car->getId();

        $data['plate'] = "'".$car->getPlate()."'";
        $data['color'] = "'".$car->getColor()->getColor()."'";
        $data['description'] = "'".$car->getDescription()."'";
        $data['model_id'] = $car->getModel()->getId();
        $data['type'] = "'".$car->getType()."'";
        $data['seats'] = "'".$car->getSeats()."'";;

        if(!empty($car->getSmoke())):
            $data['smoke'] = 1;
        else:
            $data['smoke'] = 0;
        endif;

        if(!empty($car->getAnimals())):
            $data['animals'] = 1;
        else:
            $data['animals'] = 0;
        endif;

        if(!empty($car->getMusic())):
            $data['music'] = 1;
        else:
            $data['music'] = 0;
        endif;

        if(!empty($car->getTalk())):
            $data['talk'] = 1;
        else:
            $data['talk'] = 0;
        endif;

        $info['data']= json_encode($data);

        if(!empty($request->files->get('imgCar')[0])):
            $photos = $request->files->get('imgCar');
            $count = 0;

            foreach($photos as $photo){
                $ch_photo = new \CURLFile($photo->getPathname(),$photo->getMimetype());
                $info['photos['.$count.']'] = $ch_photo;
                $count += 1;
            }
        endif;

        $result = $ch->resultApiRed($info,$file);

        $ut->flashMessage('general',$request,$result);
        
        return $result['result'];
    }

    public function deleteImgCarAction(Request $request){
        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST."user/car/delete_car_photo.php";

        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        $data['car_id'] = $request->get('id');
        $data['photos_id'] = $request->get('key');

        $ch->resultApiRed($data, $file);

        $response = new JsonResponse();

        return $response;
    }

    public function deleteCarAction(Request $request){

        $file = MyConstants::PATH_APIREST.'user/car/delete_car.php';
        $ch = new ApiRest();
        $id = $request->get('id');
        $response = new JsonResponse();

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

    public function showCarAction(Request $request){
        $car = $this->getCar($request);

    }
}
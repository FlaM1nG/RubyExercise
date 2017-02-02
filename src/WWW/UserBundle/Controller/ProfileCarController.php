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

        return $this->render('UserBundle:Profile/Car:profileNewCar.html.twig',
                        array('form' => $form->createView(),
                              'car' => $car));
    }

    private function saveNewCar(Request $request, $car){

        $file = MyConstants::PATH_APIREST.'services/car/insert_car.php';
        $ch = new ApiRest();
        $ut = new Utilities();

        $data['username'] = $request->getSession()->get('username');
        $data['id_user'] = $request->getSession()->get('id');
        $data['password'] = $request->getSession()->get('password');
        $data['plate'] = "'".$car->getPlate()."'";
        $data['color'] = "'".$car->getColor()."'";
        $data['description'] = "'".$car->getDescription()."'";

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
        return $this->render('UserBundle:Profile/Car:profileListCar.html.twig');
    }
}
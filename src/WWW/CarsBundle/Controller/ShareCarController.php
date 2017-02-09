<?php
/**
 * Created by PhpStorm.
 * User: Rocio
 * Date: 07/02/2017
 * Time: 9:31
 */

namespace WWW\CarsBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WWW\CarsBundle\Entity\ShareCar;
use WWW\CarsBundle\Form\ShareCarType;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\Entity\Utilities;
use WWW\GlobalBundle\MyConstants;
use WWW\CarsBundle\Entity\Car;
use WWW\UserBundle\Entity\Message;
use WWW\UserBundle\Form\MessageType;
use WWW\UserBundle\Entity\User;
use WWW\ServiceBundle\Entity\Comment;
use WWW\ServiceBundle\Form\CommentType;
use WWW\ServiceBundle\Form\OfferSuscribeType;

class ShareCarController extends Controller {
    
    public function createShareCarAction(Request $request){

        $route = $request->get('_route');

        $request->getSession()->set('_security.user.target_path',$route);

        $shareCar = new ShareCar();

        $arrayCars = $this->getCarsUser($request);

        $form = $this->createForm(ShareCarType::class, $shareCar, array('listCar' => $arrayCars));

        $form->handleRequest($request);


        if($form->isSubmitted()):
            $this->createOfferShareCar($request, $shareCar,4);
        endif;
        
        return $this->render('CarsBundle:ShareCar:newShareCarOffer.html.twig',
                       array('form' => $form->createView()
                       )
        );
    }

    private function getCarsUser(Request $request){

        $file = MyConstants::PATH_APIREST.'user/car/get_cars.php';
        $ch = new ApiRest();
        $arrayCars = null;

        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');

        $result = $ch->resultApiRed($data,$file);

        if($result['result'] == 'ok'):
            foreach($result['cars'] as $value):
                $car = new Car($value);
                $arrayCars[] = $car;
            endforeach;
        endif;
        
        return $arrayCars;

    }
    
    public function createOfferShareCar(Request $request, ShareCar $shareCar, $service){

        $file = MyConstants::PATH_APIREST.'services/offer/insert_offer.php';

        $ch = new ApiRest();
        $ut = new Utilities();

        $dataOffer = array( "id" => $request->getSession()->get('id'),
                            "username" => $request->getSession()->get('username'),
                            "password" => $request->getSession()->get('password'),
                            "title" => $shareCar->getOffer()->getTitle(),
                            "description" => $shareCar->getOffer()->getDescription(),
                            "service_id" => $service,
                            "holders" => $shareCar->getOffer()->getHolders());

        $dataExtra["from_place"] = "'".$shareCar->getFromPlace()."'";
        $dataExtra["to_place"] = "'".$shareCar->getToPlace()."'";
        $dataExtra["price"] = $shareCar->getPrice();
        $dataExtra["car_id"] = $shareCar->getCar()->getId();
        $dataExtra["back_two"] = 0;
        $dataExtra["autobooking"] = 0;
        $dataExtra["date"] = "'".$shareCar->getDate()->format("Y-m-d H:i")."'";

        if(!empty($shareCar->getBackTwo())) $dataExtra["back_two"];

        $dataOffer['data'] = json_encode($dataExtra);

        $result = $ch->resultApiRed($dataOffer, $file);

        $ut->flashMessage("general", $request, $result);

        return $result['result'];
    }

    public function listCarAction(Request $request){

        $arrayOffers = $this->getsShareCars($request);

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $arrayOffers,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('services/serShareCar.html.twig',
                       array('pagination' => $pagination)
        );
    }

    private function getsShareCars(Request $request){

        $file = MyConstants::PATH_APIREST.'services/share_car/list_share_cars.php';
        $ch = new ApiRest();
        $arrayShareCar = null;
        
        $data['service_id'] = 4;
        $data['search'] = "";
        $dataFilters['from_place'] = "";
        $dataFilters['to_place'] = "";
        $dataFilters['date'] = "";

        $data['filters'] = $dataFilters;
        $info['data'] = json_encode($data);

        $result = $ch->resultApiRed($info,$file);

        if($result['result'] == 'ok'):
            foreach($result['offers'] as $data):
                $arrayShareCar[] = new ShareCar($data);
            endforeach;
        endif;

        return $arrayShareCar;
    }

    public function offerCarAction(Request $request){

        $shareCar = $this->getOfferShareCar($request);
        $message = $this->fillMessage($request,$shareCar);
        $comment = new Comment();

        $formMessage = $this->createForm(MessageType::class, $message);
        $formComment = $this->createForm(CommentType::class, $comment);
        $formSubscribe = $this->createForm(OfferSuscribeType::class);

        $formComment->handleRequest($request);
        $formMessage->handleRequest($request);
        $formSubscribe->handleRequest($request);

        if($formComment->isSubmitted()):

            $result = $this->saveComment($request, $shareCar->getOffer()->getId(), $comment);
            $formComment = $this->createForm(CommentType::class, new Comment());

            if($result == 'ok'):
                return $this->redirectToRoute('offShareCar',array('idOffer'=> $shareCar->getOffer()->getId()));
            endif;

        elseif($formMessage->isSubmitted()):
            $this->sendMessage($request, $shareCar);

        elseif($formSubscribe->isSubmitted()):
            $this->offerSubscribe($request, $shareCar);

        endif;

        return $this->render('offer/offShareCar.html.twig',
                            array('offer' => $shareCar,
                                  'formMessage' => $formMessage->createView(),
                                  'formComment' => $formComment->createView(),
                                  'formSubscribe' => $formSubscribe->createView(),
                                  'service' => $shareCar->getOffer()->getService()->getId()  ));
        
    }

    private function getOfferShareCar(Request $request){

        $file = MyConstants::PATH_APIREST.'services/share_car/get_share_car.php';
        $ch = new ApiRest();
        $shareCar = null;
        $id = $request->get('idOffer');

        $data['id'] = $id;
        $data['option'] = "offer";

        $result = $ch->resultApiRed($data, $file);

        $shareCar = new ShareCar($result);

        return $shareCar;

    }

    private function fillMessage(Request $request, ShareCar $shareCar){

        $message = new Message();

        $user = new User();
        $user->setId($request->getSession()->get('id'));
        $user->setUsername($request->getSession()->get('username'));

        $userTo = new User();
        $userTo->setId($shareCar->getOffer()->getUserAdmin()->getId());
        $userTo->setUsername($shareCar->getOffer()->getUserAdmin()->getUsername());

        $message->setFrom($user);
        $message->setTo($userTo);
        $message->setSubject('Oferta: '.$shareCar->getOffer()->getTitle());

        return $message;
    }

    private function sendMessage(Request $request, ShareCar $shareCar){
        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST."user/messages/send_message.php";
        $ut = new Utilities();

        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        $data['to'] = $shareCar->getOffer()->getUserAdmin()->getUsername();
        $data['subject'] = $request->get('message')['subject'];
        $data['message'] = $request->get('message')['message'];
        $data['offer'] = $shareCar->getOffer()->getId();

        $result = $ch->resultApiRed($data, $file);

        $ut->flashMessage("message", $request, $result);
    }

    private function saveComment(Request $request, $idOffer, $comment){

        $ch = new ApiRest();
        $ut = new Utilities();
        $file = MyConstants::PATH_APIREST."services/inscription/comment.php";

        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        $data['offer_id'] = $idOffer;
        $data['comment'] = $comment->getComment();

        $result = $ch->resultApiRed($data, $file);

        if($result['result'] == 'ok'):
            return $result['result'];
        else:
            $ut->flashMessage("comment", $request, $result);
        endif;

    }

    private function offerSubscribe(Request $request, $shareCar){

        $ch = new ApiRest();
        $ut = new Utilities();
        $file = MyConstants::PATH_APIREST."services/inscription/subscribe_user.php";

        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        $data['offer_id'] = $shareCar->getOffer()->getId();

        $result = $ch->resultApiRed($data,$file);
print_r($result);
        $ut->flashMessage('general',$request, $result);

    }
    
}
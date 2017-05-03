<?php
/**
 * Created by PhpStorm.
 * User: Rocio
 * Date: 07/02/2017
 * Time: 9:31
 */

namespace WWW\CarsBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use WWW\CarsBundle\Entity\ShareCar;
use WWW\CarsBundle\Form\ShareCarType;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\Entity\Utilities;
use WWW\GlobalBundle\MyConstants;
use WWW\CarsBundle\Entity\Car;
use WWW\ServiceBundle\Entity\MessengerPrice;
use WWW\ServiceBundle\Form\CancelationType;
use WWW\ServiceBundle\Form\CourierPriceType;
use WWW\UserBundle\Entity\Message;
use WWW\UserBundle\Form\MessageType;
use WWW\UserBundle\Entity\User;
use WWW\ServiceBundle\Entity\Comment;
use WWW\ServiceBundle\Form\CommentType;
use WWW\ServiceBundle\Form\OfferSuscribeType;

class ShareCarController extends Controller {
    
    public function createShareCarAction(Request $request){

        $arrayCourierPrice = null;
        $fileRender = 'CarsBundle:ShareCar:newShareCarOffer.html.twig';
        $shareCar = new ShareCar();
        $service = null;

        $arrayCars = $this->getCarsUser($request);

        if(strpos($request->getPathInfo(),'share-car') !== false):
            $service = 4;
            $shareCar->getOffer()->getService()->setId($service);

        elseif(strpos($request->getPathInfo(),'courier-car') !== false):
            $service = 5;
            $shareCar->getOffer()->getService()->setId($service);
            $fileRender = 'CarsBundle:ShareCar:newCourierOffer.html.twig';

        endif;    

        $form = $this->createForm(ShareCarType::class, $shareCar, array('listCar' => $arrayCars, 'newOffer'=> true));

        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()):
            $result = $this->createOfferShareCar($request, $shareCar,$service);

            if($result == 'ok'):
                if($service == 4)
                    return $this->redirectToRoute('serShareCar');
                else
                    return $this->redirectToRoute('serCourier_list');
            endif;
        endif;
        
        return $this->render($fileRender, array('form' => $form->createView()));
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
                            "holders" => $shareCar->getOffer()->getHolders(),
                            "id_photos" => $shareCar->getCar()->getPhotos()[0]->getId());

        $dataExtra["from_place"] = "'".$shareCar->getFromPlace()."'";
        $dataExtra["to_place"] = "'".$shareCar->getToPlace()."'";
        $dataExtra["car_id"] = $shareCar->getCar()->getId();
        $dataExtra["autobooking"] = 0;
        $dataExtra["date"] = "'".$shareCar->getDate()->format("Y-m-d H:i")."'";

        if($service == 4):
            
            $dataExtra["back_two"] = 0;
            $dataExtra["price"] = $shareCar->getPrice();

            if(!empty($shareCar->getBackTwo()))
                $dataExtra["back_two"] = $shareCar->getBackTwo();

        endif;

        $dataOffer['data'] = json_encode($dataExtra);

        $result = $ch->resultApiRed($dataOffer, $file);

        $ut->flashMessage("general", $request, $result);

        return $result['result'];

    }

    public function listCarAction(Request $request){

        $service = null;
        $priceMin = null;

        if(strpos($request->getPathInfo(),'share-car') !== false):
            $service = 4;
        elseif(strpos($request->getPathInfo(),'courier-car') !== false):
            $service = 5;
            $priceMin = $this->getPriceMinCourier($request);
        endif;

        $arrayOffers = $this->getsShareCars($request, $service);

        $paginator = $this->get('knp_paginator');
        $pagination = null;

        if(!empty($arrayOffers)):
            $pagination = $paginator->paginate(
                $arrayOffers,
                $request->query->getInt('page', 1),
                MyConstants::NUM_CAR_PAGINATOR
            );
        endif;

        return $this->render('services/serShareCar.html.twig',
                       array('pagination' => $pagination,
                             'service' => $service,
                             'priceMin' => $priceMin));
    }

    private function getsShareCars(Request $request, $service){

        $file = MyConstants::PATH_APIREST.'services/share_car/list_share_cars.php';
        $ch = new ApiRest();
        $arrayShareCar = null;
        
        $data['service_id'] = $service;
        $data['search'] = "";
        $dataFilters['from_place'] = "";
        $dataFilters['to_place'] = "";
        $dataFilters['date'] = "";

        if(!empty($request->query->all())):
            $dataFilters['from_place'] = $request->query->get('fromPlace');
            $dataFilters['to_place'] = $request->query->get('toPlace');
            $dataFilters['date'] = $request->query->get('date');
        endif;

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

        //Miramos si venimos del perfil para que en ese caso si el coche se borró, igualmente me enseñe la oferta
        if( strpos(parse_url($request->headers->get('referer'),PHP_URL_PATH),'user/profile/offers')!== false):
            $profile = true;
        else:
            $profile = false;
        endif;

        $shareCar = $this->getOfferShareCar($request,$profile);

        if($shareCar == 'error_shareCar'):
            return $this->redirectToRoute('serShareCar');
        elseif($shareCar == 'error_courier'):
            return $this->redirectToRoute('serCourier_list');
        endif;

        $courierPrice = null;
        $listCourierPrice = null;
        $formCourierPrice = null;
        $priceMin = null;
        $message = $this->fillMessage($request,$shareCar);
        $comment = new Comment();
        $service = $shareCar->getOffer()->getService()->getId();

        if($service == 5):
            $listCourierPrice = $this->getDataCourier($request, $priceMin);
            $courierPrice = new MessengerPrice(null);
        endif;

        $formMessage = $this->createForm(MessageType::class, $message);
        $formComment = $this->createForm(CommentType::class, $comment);
        $formCourierPrice = $this->createForm(CourierPriceType::class, $courierPrice, array('courierPrice' => $listCourierPrice));


        $formComment->handleRequest($request);
        $formMessage->handleRequest($request);
        $formCourierPrice->handleRequest($request);

        $paginator = $this->get('knp_paginator');
        $pagination = null;

        if(!empty($shareCar->getOffer()->getComments())):

            $pagination = $paginator->paginate(
                $shareCar->getOffer()->getComments(),
                $request->query->getInt('page', 1),
                MyConstants::NUM_COMMENTS_PAGINATOR
            );
        
        endif;

        if($formComment->isSubmitted()):

            $result = $this->saveComment($request, $shareCar->getOffer()->getId(), $comment);
            $formComment = $this->createForm(CommentType::class, new Comment());

            if($result == 'ok'):
                return $this->redirectToRoute('offShareCar',array('idOffer'=> $shareCar->getOffer()->getId()));
            endif;

        elseif($formMessage->isSubmitted()):
            $this->sendMessage($request, $shareCar);

        elseif($formCourierPrice->isSubmitted()):

            $inscription = $this->offerSubscribe($request, $shareCar, $listCourierPrice);
            $nameService = "";
            
            if($service == 4):
                $nameService = 'share-car';
            
            elseif($service == 5):
                $nameService = 'courier-car';
                $request->getSession()->set('idInscription', $inscription);

            endif;    

            return $this->redirectToRoute(  'acme_payment_homepage', array(
                                            'idOffer'=> $shareCar->getOffer()->getId(),
                                            'service'=> $nameService
                                                ));
        endif;

        return $this->render('offer/offShareCar.html.twig',
                            array('offer' => $shareCar,
                                  'formMessage' => $formMessage->createView(),
                                  'formComment' => $formComment->createView(),
                                  'formSubscribe' => $formCourierPrice->createView(),
                                  'service' => $service,
                                  'pagination' => $pagination,
                                  'numComment' => MyConstants::NUM_COMMENTS_PAGINATOR,
                                  'priceMin' => 'Desde '.number_format($priceMin, 2, ',','')));
        
    }

    private function getOfferShareCar(Request $request, $profile = null){

        $file = MyConstants::PATH_APIREST.'services/share_car/get_share_car.php';
        $ch = new ApiRest();
        $shareCar = null;
        $id = $request->get('idOffer');

        $data['id'] = $id;
        $data['option'] = "offer";

        if($profile):
            $data['forceWithCar'] = true;
        endif;

        $result = $ch->resultApiRed($data, $file);
        if($result['result'] == 'ok' AND isset($result['car']['existCar'])):
            $shareCar = new ShareCar($result);

        elseif($result['result'] == 'ok' AND $result['car']['result'] == 'data_error'):
            if($result['service_id'] == '4'):
                $shareCar = 'error_shareCar';
            else:
                $shareCar = 'error_courier';
            endif;
        endif;

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
        $data['subject'] = $request->get('message')['subject'];
        $data['message'] = $request->get('message')['message'];
        $data['offer'] = $shareCar->getOffer()->getId();
        $data['to'] = $shareCar->getOffer()->getUserAdmin()->getUsername();

        if(isset($request->get('message')['to'])):
            $data['to'] = $request->get('message')['to'];
        endif;

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

    private function offerSubscribe(Request $request, ShareCar $shareCar, $listPrices = null){

        $idInscription = null;
        $ch = new ApiRest();
        $ut = new Utilities();
        $file = MyConstants::PATH_APIREST."services/inscription/subscribe_user.php";

        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        $data['offer_id'] = $shareCar->getOffer()->getId();

        if($shareCar->getOffer()->getService()->getId() == 5):
            $data['id_messengerPrice'] = $request->get('courierPrice')['courierPrice'];
            $data['newInscription'] = true;
            $shareCar->setPrice($listPrices[$data['id_messengerPrice']]->getPriceEs());
        endif;


        $result = $ch->resultApiRed($data,$file);

        if($result['result'] == 'ok'):
            if(array_key_exists('id_inscription', $result)){
                $idInscription = $result['id_inscription'];
            }
        endif;

        return $idInscription;

    }

    public function inscriptionsAction(Request $request){

        $offer = $this->getOfferShareCar($request);
        $message = $this->fillMessage($request, $offer);

        $formMessage = $this->createForm(MessageType::class, $message);
        $formMessage->handleRequest($request);

        $formCancelation = $this->createForm(CancelationType::class,null, array('inscription' => true));

        if($formMessage->isSubmitted()):
            $this->sendMessage($request, $offer);
        endif;

        return $this->render('offer/inscription.html.twig',
                        array('offer' => $offer,
                              'formMessage' => $formMessage->createView(),
                              'formCancelation' => $formCancelation->createView()));
    }

    private function getDataCourier(Request $request, &$priceMin){

        $file = MyConstants::PATH_APIREST."services/courier/get_courierPrice.php";
        $ch = new ApiRest();
        $courierPrice = null;

        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        $data['id_messengerService'] = 1;
        
        $result = $ch->resultApiRed($data,$file);

        if($result['result'] == 'ok'):

            foreach ($result['messengerPrice'] as $data):
                $courier = new MessengerPrice($data);
                $courierPrice[$data['id']] = $courier;

                if($courier->getWeightMin() == 0)
                    $priceMin = $courier->getPriceES();
            endforeach;
        endif;
        return $courierPrice;
    }

    private function getPriceMinCourier(Request $request){

        $file = MyConstants::PATH_APIREST."services/courier/get_courierPrice.php";
        $ch = new ApiRest();
        $courierPrice = null;

        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        $data['id_messengerService'] = 1;
        $data['weight'] = 0.1;
        $data['region'] = 'granada';

        $result = $ch->resultApiRed($data,$file);

        if($result['result'] == 'ok'):
            return $result['messengerPrice'][0]['price_es'];
        else:
            return null;
        endif;

    }

    public function cancelInscriptionAction(Request $request){

        $file = MyConstants::PATH_APIREST.'services/trade/cancel_trade.php';
        $ch = new ApiRest();
        $response = new JsonResponse();
        $ut = new Utilities();

        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        $data['user_id'] = $request->get('user_id');
        $data['offer_id'] = $request->get('offer_id');
        $data['concept'] = $request->get('concept');
//        $data['inscription_id'] = $request->get('inscription_id');

        $result = $ch->resultApiRed($data,$file);

        if($result['result'] == 'ok'):
            $ut->flashMessage('Cancelación realizada con éxito', $request,$result);
            $response->setData(array('result' => 'ok'));
        else:
            $response->setData(array('result' => 'ko', 'message' => 'No se ha podido llevar a cabo la cancelación, por 
            favor inténtelo más tarde. En caso de que siga teniendo problemas póngase en contacto con nuestro servicio 
            de atención al cliente'));
        endif;

        return $response;
    }
}

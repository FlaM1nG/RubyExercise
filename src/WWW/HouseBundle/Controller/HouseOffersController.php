<?php
/**
 * Created by PhpStorm.
 * User: Rocio
 * Date: 07/03/2017
 * Time: 15:59
 */

namespace WWW\HouseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\Entity\Utilities;
use WWW\GlobalBundle\MyConstants;
use Symfony\Component\HttpFoundation\Request;
use WWW\HouseBundle\Entity\ShareHouse;
use WWW\HouseBundle\Entity\ShareRoom;
use WWW\HouseBundle\Entity\House;
use WWW\HouseBundle\Form\ShareHouseType;
use WWW\HouseBundle\Form\ShareRoomType;
use WWW\ServiceBundle\Entity\Comment;
use WWW\ServiceBundle\Form\CommentType;
use WWW\ServiceBundle\Form\OfferSuscribeType;
use WWW\UserBundle\Entity\Message;
use WWW\UserBundle\Form\MessageType;
use WWW\UserBundle\Entity\User;
use WWW\HouseBundle\Form\DatepickerType;




class HouseOffersController extends Controller
{
    public function createNewOfferAction(Request $request){

        $service = $this->getIdService($request);
        $arrayHouses = null;

        if($service != 9):
            $arrayHouses = $this->getHousesUser($request);
            $offer = new ShareHouse();

            $form = $this->createForm(ShareHouseType::class,$offer,
                array('arrayHouses' => $arrayHouses,'service' =>$service,
                      'validation_groups' => $service == 6 || $service == 7 ?'licenciaObligatoria':false));
        else:
            $offer = new ShareRoom();

            $form = $this->createForm(ShareRoomType::class, $offer);
        endif;


        $form->handleRequest($request);
        
        if($form->isSubmitted() AND $form->isValid()):

            if($service == 9):
                $result = $this->saveOfferBedroom($request,$offer);
            else:
                $result = $this->saveNewOffer($request,$offer, $service);
            endif;

            if($result == 'ok'):

                if($service == 6):
                    return $this->redirectToRoute('serHouseRents');
                
                elseif($service == 7):
                    return $this->redirectToRoute('house_lisShareHouse');
                
                elseif($service == 8):
                    return  $this->redirectToRoute('house_listHouseSwap');
                
                elseif($service == 9):
                    return $this->redirectToRoute('house_listBedroomSwap');

                endif;

            endif;

        endif;

        return $this->render("HouseBundle::newOfferHouseRent.html.twig", array(
                      'service' => $service,
                      'form' => $form->createView()
        ));
    }

    private function getHousesUser(Request $request){

        $file = MyConstants::PATH_APIREST.'user/house/get_houseUserList.php';
        $ch = new ApiRest();

        $arrayHouses = array();

        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        $data['photos'] = true;

        $result = $ch->resultApiRed($data, $file);

        foreach($result['houses'] as $data):
            $house = new House($data);
            $arrayHouses[] = $house;
        endforeach;

        return $arrayHouses;

    }

    private function saveNewOffer(Request $request, $offer, $service){

        $file = MyConstants::PATH_APIREST.'services/share_house/insert_share_house.php';
        $ch = new ApiRest();
        $ut = new Utilities();

        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        $data['title'] = $offer->getOffer()->getTitle();
        $data['description'] = $offer->getOffer()->getDescription();
        $data['service_id'] = $service;
        $data['holders'] = $offer->getOffer()->getHolders();
        $data['house_id'] = $offer->getHouse()->getId();
        $dataOffer['price'] = 0;
        
        if($service == 6 || $service == 7):
            $dataOffer['entry_time'] = "'".$offer->getEntryTime()->format('H:i:s')."'";
            $dataOffer['departure_time'] = "'".$offer->getDepartureTime()->format('H:i:s')."'";
            $dataOffer['price'] = $offer->getPrice();
        endif;

        $data['data'] = json_encode($dataOffer);

        $result = $ch->resultApiRed($data, $file);

        if($result['result'] == 'data_error' AND $result['error'] == 'Offer created yet'):
            $ut->flashMessage('offer',$request,$result,'Ya existe una oferta con esta casa y solo se puede tener una oferta por casa');
        else:
            $ut->flashMessage('offer',$request,$result);
        endif;

        return $result['result'];
    }

    private function saveOfferBedroom(Request $request, $offer){

        $file = MyConstants::PATH_APIREST.'services/offer/insert_offer.php';
        $ch = new ApiRest();
        $ut = new Utilities();

        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        $data['title'] = $offer->getOffer()->getTitle();
        $data['description'] = $offer->getOffer()->getDescription();
        $data['service_id'] = 9;
        $data['holders'] = $offer->getOffer()->getHolders();

        $dataOffer['city'] = "'".$offer->getCity()."'";
        $dataOffer['region'] = "'".$offer->getCountry()->getRegion()."'";
        $dataOffer['country'] = "'".$offer->getCountry()->getCountry()."'";

        if(!empty($request->files->get('shareRoom')['imgBedroom'][0])):
            $photos = $request->files->get('shareRoom')['imgBedroom'];
            $count = 0;

            foreach($photos as $photo){
                $ch_photo = new \CURLFile($photo->getPathname(),$photo->getMimetype());
                $data['photos['.$count.']'] = $ch_photo;
                $count += 1;
            }
        endif;

        $data['data'] = json_encode($dataOffer);

        $result = $ch->resultApiRed($data, $file);

        if($result['result'] == 'data_error' AND $result['error'] == 'Offer created yet'):
            $ut->flashMessage('offer',$request,$result,'Ya existe una oferta con esta casa y solo se puede tener una oferta por casa');
        else:
            $ut->flashMessage('offer',$request,$result);
        endif;

        return $result['result'];
    }

    public function listOfferShareHouseAction(Request $request){

        $service = $this->getIdService($request);

        $arrayOffers = $this->getOffersShareHouse($request, $service);

        $paginator = $this->get('knp_paginator');
        $pagination = null;

        if(!empty($arrayOffers)):
            $pagination = $paginator->paginate(
                $arrayOffers,
                $request->query->getInt('page', 1),
                MyConstants::NUM_HOUSE_PAGINATOR
            );

        endif;

        return $this->render('services/serHouseRents.html.twig', array(
                             'arrayOffers' => $arrayOffers,
                             'service' => $service,
                             'pagination' => $pagination,
        ));
    }

    private function getOffersShareHouse(Request $request, $idService) {

        $file = MyConstants::PATH_APIREST . 'services/share_house/list_share_house.php';
        $ch = new ApiRest();
        $arrayOffers = null;

        $data['service_id'] = $idService;
        $data['search'] = "";

        if(!empty($request->query->all())):
            $dataFilters['place'] = $request->query->get('destiny');
            $dataFilters['capacity'] = $request->query->get('capacity');

            if(!empty($request->query->get('minPrice')))
                $dataFilters['min_price'] = (int)$request->query->get('minPrice');

            if(!empty($request->query->get('maxPrice')))
                $dataFilters['max_price'] = (int)$request->query->get('maxPrice');

            $data['filters'] = $dataFilters;
        endif;


        $info['data'] = json_encode($data);

        $result = $ch->resultApiRed($info, $file);
;
        if ($result['result'] == 'ok')
            $arrayOffers = $result['offers'];

        return $arrayOffers;
    }

    public function showOfferShareHouseAction(Request $request){

        $message = new Message();
        $comment = new Comment();
        $arrayAttr = null;
        $formSubscribe = null;
        $service = $this->getIdService($request);



        if($service!=8){

            $sesion = $request->getSession();

            //Guardamos el precio total en la sesion

            $precioTotal = $sesion->get('preciototal');

            $fechainicial = $sesion->get('fechainicial');

            $fechafinal = $sesion->get('fechafinal');

            $formSubscribe = $this->createForm(DatepickerType::class);

            $formSubscribe=$formSubscribe->createView();


        }

        $formComment = $this->createForm(CommentType::class, $comment);
        $formComment->handleRequest($request);
        
        if($formComment->isSubmitted() AND $formComment->isValid()):
            $this->saveComment($request, $comment);
            $formComment = $this->createForm(CommentType::class, new Comment());
        endif;

        $offerShareHouse = $this->getoffer($request, $service);


        if($service != 9):
            $arrayAttr = $offerShareHouse->getHouse()->getArrayGroupsAttrH();
        endif;

        $message = $this->fillMessage($request, $offerShareHouse);

        $formMessage = $this->createForm(MessageType::class, $message);
        $formMessage->handleRequest($request);

        if($formMessage->isSubmitted()):
            $this->sendMessage($request, $message, $offerShareHouse->getOffer()->getUserAdmin()->getUsername());
            $m = $this->fillMessage($request, $offerShareHouse);
            $formMessage = $this->createForm(MessageType::class, $m);
        endif;

        $paginator = $this->get('knp_paginator');
        $pagination = null;

        if(!empty($offerShareHouse->getOffer()->getComments())):

            $pagination = $paginator->paginate(
                $offerShareHouse->getOffer()->getComments(),
                $request->query->getInt('page', 1),
                MyConstants::NUM_COMMENTS_PAGINATOR
            );

        endif;
 

        $formSubscribe =  $this->createForm(DatepickerType::class);
        $formSubscribe->handleRequest($request);

        $calendarId = null;

        //Sacamos el calendar ID
        $calendarId = $this->getDataCalendar($offerShareHouse->getHouse()->getId());

        // Lo guardo en la sesion el calendar ID y el servicio
        $sesion->set('calendario_id', $calendarId);
        $sesion->set('service_id', $service);
        


        if($formSubscribe->isSubmitted()):
            $inscription =  $this->offerSubscribe($request,$offerShareHouse->getOffer()->getId());
                $request->getSession()->set('idInscription', $inscription);
                $nameService = "";
                if($service == 6) $nameService = 'house-rents';
                elseif($service == 7) $nameService = 'share-house';

                return $this->redirectToRoute('acme_payment_homepage', array(
                    'idOffer'=> $offerShareHouse->getOffer()->getId(),
                    'service'=> $nameService,

                ));
        endif;



        return $this->render('HouseBundle::offHouseRents.html.twig', array(
                             'offer' => $offerShareHouse,
                             'arrayAttr' => $arrayAttr,
                             'formMessage' => $formMessage->createView(),
                             'formComment' => $formComment->createView(),
                             'formSubscribe' => $formSubscribe->createView(),
                             'pagination' => $pagination,
                             'numComment' => MyConstants::NUM_COMMENTS_PAGINATOR,
                             'service' => $service,
                            'preciototal' => $precioTotal,
                            'fechainicial' => $fechainicial,
                            'fechafinal' => $fechafinal,
                            'calendarID' => $calendarId,



        ));
    }

    private function getDataCalendar($idHouse){

        $em = $this->getDoctrine()->getEntityManager();
        $db = $em->getConnection();

        $query =  "select calendar_id from house where id=".$idHouse;

        $stmt = $db->prepare($query);
        $params = array();
        $stmt->execute($params);
        $fechas = $stmt->fetchAll();

        $repository = $this->getDoctrine()->getRepository('GlobalBundle:MyCompanyEvents');

        return $fechas[0]['calendar_id'];

    }


    private function offerSubscribe(Request $request,$offerId){

        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST."services/inscription/subscribe_user.php";

        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        $data['offer_id'] = $offerId;

        $result = $ch->resultApiRed($data, $file);
        if($result['result'] == 'ok'):
            if(array_key_exists('id_inscription', $result))
                $idInscription = $result['id_inscription'];
        endif;
        return $idInscription;
    }


        private function getoffer(Request $request, $service){

        $file = MyConstants::PATH_APIREST.'services/share_house/get_share_house.php';
        $ch = new ApiRest();
        $offer = null;

        $data['id'] = $request->get('idOffer');

        $result = $ch->resultApiRed($data,$file);

        if($service == 9):
            $offer = new ShareRoom($result);
        else:
            $offer = new ShareHouse($result);
        endif;

        return $offer;

    }

    private function saveComment(Request $request, Comment $comment){

        $ch = new ApiRest();
        $ut = new Utilities();
        $file = MyConstants::PATH_APIREST."services/inscription/comment.php";

        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        $data['offer_id'] = $request->get('idOffer');
        $data['comment'] = $comment->getComment();

        $result = $ch->resultApiRed($data, $file);

        if($result['result'] == 'ok'):
            return $result['result'];
        else:
            $ut->flashMessage("comment", $request, $result);
        endif;
    }

    private function fillMessage(Request $request, $shareHouse){

        $message = new Message();

        $user = new User();
        $user->setId($request->getSession()->get('id'));
        $user->setUsername($request->getSession()->get('username'));

        $userTo = new User();
        $userTo->setId($shareHouse->getOffer()->getUserAdmin()->getId());
        $userTo->setUsername($shareHouse->getOffer()->getUserAdmin()->getUsername());

        $message->setFrom($user);
        $message->setTo($userTo);
        $message->setSubject('Oferta: '.$shareHouse->getOffer()->getTitle());

        return $message;
    }

    private function sendMessage(Request $request, Message $message, $to){

        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST."user/messages/send_message.php";
        $ut = new Utilities();

        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        $data['subject'] = $message->getSubject();
        $data['message'] = $message->getMessage();
        $data['offer'] = $request->get('idOffer');
        $data['to'] = $to;

        if(isset($request->get('message')['to'])):
            $data['to'] = $request->get('message')['to'];
        endif;

        $result = $ch->resultApiRed($data, $file);

        $ut->flashMessage("message", $request, $result);

    }

    public function getIdService(Request $request){

        if(strpos($request->getPathInfo(),'house-rents') !== false):
            $service = 6;

        elseif(strpos($request->getPathInfo(),'share-house') !== false):
            $service = 7;

        elseif(strpos($request->getPathInfo(),'house-swap') !== false):
            $service = 8;

        elseif(strpos($request->getPathInfo(),'bedroom-swap') !== false):
            $service = 9;
        
        endif;

        return $service;
    }


    
}
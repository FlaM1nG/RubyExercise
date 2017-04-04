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



class BedroomOffersController extends Controller
{
    public function createNewOfferAction(Request $request){

        $service = $this->getIdService($request);
        $arrayHouses = null;

        if($service == 9):

            $offer = new ShareRoom();

            $form = $this->createForm(ShareRoomType::class, $offer);
        endif;


        $form->handleRequest($request);

        $route = $request->get('_route');
        $request->getSession()->set('_security.user.target_path',$route);

        if($form->isSubmitted() AND $form->isValid()):

//            if($service == 9):
                $result = $this->saveNewOffer($request, $offer, $service);
//            endif;

            if($result == 'ok'):
                $request->getSession()->remove('_security.user.target_path');

//                if($service == 9):
                    return $this->redirectToRoute('house_listBedroomSwap');
//                endif;
            endif;

        endif;

        return $this->render("HouseBundle::newOfferBedroom.html.twig", array(
            'service' => $service,
            'form' => $form->createView()
        ));
    }

    private function saveNewOffer(Request $request, $offer, $service){

        $file = MyConstants::PATH_APIREST.'services/offer/insert_offer.php';
        $ch = new ApiRest();
        $ut = new Utilities();

        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        $data['title'] = $offer->getOffer()->getTitle();
        $data['description'] = $offer->getOffer()->getDescription();
        $data['service_id'] = $service;
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

    public function listOfferBedroomAction(Request $request){

        $service = $this->getIdService($request);

        $arrayOffers = $this->getOffersBedroom($service);

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

    private function getOffersBedroom($idService) {

        $file = MyConstants::PATH_APIREST . 'services/share_house/list_share_room.php';
        $ch = new ApiRest();
        $arrayOffers = null;

        $data['service_id'] = $idService;
        $data['search'] = "";

        $info['data'] = json_encode($data);

        $result = $ch->resultApiRed($info, $file);

        if ($result['result'] == 'ok')
            $arrayOffers = $result['offers'];

        return $arrayOffers;
    }

    public function showOfferBedroomAction(Request $request){

        $message = new Message();
        $comment = new Comment();
        $service = $this->getIdService($request);

        $formSubscribe = $this->createForm(OfferSuscribeType::class);

        $formComment = $this->createForm(CommentType::class, $comment);
        $formComment->handleRequest($request);

        if($formComment->isSubmitted() AND $formComment->isValid()):
            $this->saveComment($request, $comment);
            $formComment = $this->createForm(CommentType::class, new Comment());
        endif;

        $offer = $this->getoffer($request, $service);

        $message = $this->fillMessage($request, $offer);

        $formMessage = $this->createForm(MessageType::class, $message);
        $formMessage->handleRequest($request);

        if($formMessage->isSubmitted()):
            $this->sendMessage($request, $message, $offer->getOffer()->getUserAdmin()->getUsername());
            $m = $this->fillMessage($request, $offer);
            $formMessage = $this->createForm(MessageType::class, $m);
        endif;

        $paginator = $this->get('knp_paginator');
        $pagination = null;

        if(!empty($offer->getOffer()->getComments())):

            $pagination = $paginator->paginate(
                $offer->getOffer()->getComments(),
                $request->query->getInt('page', 1),
                MyConstants::NUM_COMMENTS_PAGINATOR
            );

        endif;

        return $this->render('offer/offHouseRents.html.twig', array(
            'offer' => $offer,
            'formMessage' => $formMessage->createView(),
            'formComment' => $formComment->createView(),
            'formSubscribe' => $formSubscribe->createView(),
            'pagination' => $pagination,
            'numComment' => MyConstants::NUM_COMMENTS_PAGINATOR,
            'service' => $service
        ));
    }

    private function getoffer(Request $request, $service){

        $file = MyConstants::PATH_APIREST.'services/share_house/get_share_house.php';
        $ch = new ApiRest();
        $offer = null;

        $data['id'] = $request->get('idOffer');

        $result = $ch->resultApiRed($data,$file);

        if($service == 9):
            $offer = new ShareRoom($result);
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

    private function fillMessage(Request $request, $offer){

        $message = new Message();

        $user = new User();
        $user->setId($request->getSession()->get('id'));
        $user->setUsername($request->getSession()->get('username'));

        $userTo = new User();
        $userTo->setId($offer->getOffer()->getUserAdmin()->getId());
        $userTo->setUsername($offer->getOffer()->getUserAdmin()->getUsername());

        $message->setFrom($user);
        $message->setTo($userTo);
        $message->setSubject('Oferta: '.$offer->getOffer()->getTitle());

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

        if(strpos($request->getPathInfo(),'bedroom-swap') !== false):
            $service = 9;

        endif;

        return $service;
    }
}
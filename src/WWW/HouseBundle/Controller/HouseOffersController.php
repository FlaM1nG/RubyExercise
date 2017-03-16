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
use WWW\HouseBundle\Entity\House;
use WWW\HouseBundle\Form\ShareHouseType;
use WWW\ServiceBundle\Entity\Comment;
use WWW\ServiceBundle\Form\CommentType;
use WWW\ServiceBundle\Form\OfferSuscribeType;
use WWW\UserBundle\Entity\Message;
use WWW\UserBundle\Form\MessageType;
use WWW\UserBundle\Entity\User;


class HouseOffersController extends Controller
{
    public function createNewOfferAction(Request $request){

        $arrayHouses = $this->getHousesUser($request);

        $shareHouse = new ShareHouse();

        $form = $this->createForm(ShareHouseType::class,$shareHouse, array('arrayHouses' => $arrayHouses));
        $form->handleRequest($request);

        if($form->isSubmitted()):
            $result = $this->saveNewOffer($request,$shareHouse);

            if($result == 'ok'):
               return $this->redirectToRoute('serHouseRents');
            endif;
        endif;

        return $this->render("HouseBundle::newOfferHouseRent.html.twig", array(
                      'service' => 6,
                      'form' => $form->createView()
        ));
    }

    private function getHousesUser(Request $request){

        $file = MyConstants::PATH_APIREST.'user/house/get_houseUserList.php';
        $ch = new ApiRest();

        $arrayHouses = null;

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

    private function saveNewOffer(Request $request, ShareHouse $shareHouse){
        
        $file = MyConstants::PATH_APIREST.'services/share_house/insert_share_house.php';
        $ch = new ApiRest();
        $ut = new Utilities();

        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        $data['title'] = $shareHouse->getOffer()->getTitle();
        $data['description'] = $shareHouse->getOffer()->getDescription();
        $data['service_id'] = 6;
        $data['holders'] = $shareHouse->getOffer()->getHolders();
        $data['house_id'] = $shareHouse->getHouse()->getId();
        $dataOffer['entry_time'] = "'".$shareHouse->getEntryTime()->format('H:i:s')."'";
        $dataOffer['departure_time'] = "'".$shareHouse->getDepartureTime()->format('H:i:s')."'";
        $dataOffer['price'] = $shareHouse->getPrice();

        $data['data'] = json_encode($dataOffer);

        $result = $ch->resultApiRed($data, $file);

        $ut->flashMessage('offer',$request,$result);

        return $result['result'];
    }

    public function listOfferShareHouseAction(Request $request){

        $service = null;

        if(strpos($request->getPathInfo(),'house-rents') !== false):
            $service = 6;
        elseif(strpos($request->getPathInfo(),'share-house') !== false):
            $service = 7;
        endif;

        $arrayOffers = $this->getOffersShareHouse($service);

        return $this->render('services/serHouseRents.html.twig', array(
                             'arrayOffers' => $arrayOffers
        ));
    }

    private function getOffersShareHouse($idService) {

        $file = MyConstants::PATH_APIREST . 'services/share_house/list_share_house.php';
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

    public function showOfferShareHouseAction(Request $request){

        $message = new Message();
        $comment = new Comment();

        $formSubscribe = $this->createForm(OfferSuscribeType::class);

        $formComment = $this->createForm(CommentType::class, $comment);
        $formComment->handleRequest($request);
        
        if($formComment->isSubmitted() AND $formComment->isValid()):
            $this->saveComment($request, $comment);
            $formComment = $this->createForm(CommentType::class, new Comment());
        endif;

        $offerShareHouse = $this->getoffer($request);

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

        return $this->render('offer/offHouseRents.html.twig', array(
                             'offer' => $offerShareHouse,
                             'arrayAttr' => $offerShareHouse->getHouse()->getArrayGroupsAttrH(),
                             'formMessage' => $formMessage->createView(),
                             'formComment' => $formComment->createView(),
                             'formSubscribe' => $formSubscribe->createView(),
                             'pagination' => $pagination,
                             'numComment' => MyConstants::NUM_COMMENTS_PAGINATOR,
                             'service' => 6
        ));
    }

    private function getoffer(Request $request){

        $file = MyConstants::PATH_APIREST.'services/share_house/get_share_house.php';
        $ch = new ApiRest();
        $offer = null;

        $data['id'] = $request->get('idOffer');

        $result = $ch->resultApiRed($data,$file);


//        print_r($result);

        $offer = new ShareHouse($result);
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
}
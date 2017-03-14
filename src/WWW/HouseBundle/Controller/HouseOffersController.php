<?php
/**
 * Created by PhpStorm.
 * User: Rocio
 * Date: 07/03/2017
 * Time: 15:59
 */

namespace WWW\HouseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\Entity\Utilities;
use WWW\GlobalBundle\MyConstants;
use Symfony\Component\HttpFoundation\Request;
use WWW\HouseBundle\Entity\ShareHouse;
use WWW\HouseBundle\Entity\House;
use WWW\HouseBundle\Form\ShareHouseType;
use WWW\GlobalBundle\Entity\MyCompanyEvents;
use Doctrine\ORM\EntityManager;
use Sonata\CoreBundle\Date;
use WWW\ServiceBundle\Entity\Service;


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
                echo "hay que redireccionar al listado cuando esté hecho";
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
        $dataOffer['price'] = $shareHouse->getPrice();

        $data['data'] = json_encode($dataOffer);

        $result = $ch->resultApiRed($data, $file);
//        $result['result'] = 'ok';

        $ut->flashMessage('offer',$request,$result);

//        if($result['result'] == 'ok'):
//
//            $em = $this->getDoctrine()->getManager();
//            $dateNow = new \DateTime('now');
//            $dateEnd =  new \DateTime('now');
//            $dateEnd->add(new \DateInterval('P10Y'));
//
//            $mce = new MyCompanyEvents(5,'€',$shareHouse->getPrice(),'','',$dateNow, $dateEnd);
//            $mce->setServiceID(6);
//            $mce->setCalendarID(10);
//
//            $em->persist($mce);
//
//            $em->flush();
//
//        endif;

        return $result['result'];
    }

    public function listOfferShareHouseAction(Request $request){

        return $this->render('services/serHouseRents.html.twig');
    }

    private function getOffersShareHouse(Request $request){
        
    }
}
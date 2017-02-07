<?php

namespace WWW\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WWW\OthersBundle\Entity\Trade;
use WWW\OthersBundle\Form\TradeType;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\Entity\Utilities;
use WWW\GlobalBundle\Entity\Photo;
use WWW\GlobalBundle\MyConstants;
use Symfony\Component\HttpFoundation\JsonResponse;

class OfferUserController extends Controller{
    
    private $service = null;
    private $offer = null;
    private $session = null;
    private $ut = null;
    
    
//   public function showOfferAction(Request $request){
//
//        $this->session = $request->getSession();
//        $this->ut = new Utilities();
//
//        $formulario = $this->searchOffer($request,$request->get('idOffer'));
//
//        $typeService = $this->nameService($this->service);
//
//        $formulario->handleRequest($request);
//
//        if($formulario->isSubmitted() && $formulario->isValid()):
//            //echo $typeService;
//
//                switch($typeService):
//                    case 'trade':   $this->offerTypeTrade($request,$formulario);
//                                    break;
//                endswitch;
//        endif;
//
//       $formulario = $this->createForm(TradeType::class,$this->offer);
//
//       return $this->render('UserBundle:Offers:'.$typeService.'.html.twig',
//                       array('formulario' => $formulario->createView(),
//                             'offer' => $this->offer));
//   }
//
//   private function offerTypeTrade(Request $request, $formulario){
//
//        if($formulario->get('saveTrade')->isClicked()):
//           $this->saveTrade($request);
//
//        elseif($formulario->get('deletePhotos')->isClicked()):
//            $this->deleteImages($request);
//
//        endif;
//   }
//
//   private function nameService($idService){
//
//       $nameService = "";
//
//       switch($idService):
//
//           case 1: $nameService = "trade";
//                   break;
//       endswitch;
//
//       return $nameService;
//   }
//
//   private function searchOffer(Request $request, $id){
//
//       $file = MyConstants::PATH_APIREST."services/offer/get_offer.php";
//       $ch = new ApiRest();
//
//       $data['id'] = $id;
//       $result = $ch->resultApiRed($data, $file);
//       $formulario = null;
//
//        if($result['result'] == 'ok'):
//
//            $this->service = $result['service_id'];
//
//             if($result['service_id'] == 1):
//                 $this->createTrade($result);
//                 $formulario = $this->createForm(TradeType::class,$this->offer);
//             endif;
//        else:
//            $this->ut->flashMessage("offer", $request, $result);
//        endif;
//
//        return $formulario;
//   }
//
//   private function createTrade($result){
//
//        $offer = new Trade($result,true);
//
//        $arrayCategory = $this->ut->getArrayCategoryTrade();
//        $offer->setCategory($arrayCategory[$result['category_id']]);
//
//        $this->offer = $offer;
//
//   }
//
//   private function saveOffer(Request $request){
//
//       switch ($this->service):
//           case 1: $this->saveTrade($request);
//                   break;
//       endswitch;
//
//   }
//
//    private function saveTrade(Request $request){
//
//        $arrayImage = $request->files->get('trade')['offer']['fileImage'];
//        if(!empty($arrayImage[0])):
//            //Guardar imágenes
//        endif;
//
//        $ch = new ApiRest();
//        $file = MyConstants::PATH_APIREST."services/offer/update_offer.php";
//
//        $info['id'] = $this->session->get('id');
//        $info['username'] = $this->session->get('username');
//        $info['password'] = $this->session->get('password');
//        $info['offer_id'] = $this->offer->getId();
//
//        $data['values']['title'] = "'".$this->offer->getOffer()->getTitle()."'";
//        $data['values']['description'] = "'".$this->offer->getOffer()->getDescription()."'";
//        $data['sub_values']['price'] = $this->offer->getPrice();
//        $data['sub_values']['dimensions'] = "'".$this->offer->getDimensions()."'";
//        $data['sub_values']['weight'] = $this->offer->getWeight();
//        $data['sub_values']['region'] = "'".$this->offer->getRegion()."'";
//        $data['sub_values']['category_id'] = $this->offer->getCategory()->getId();
//
//        $info['data']= json_encode($data);
//
//
//        $result = $ch->resultApiRed($info, $file);
//
//        $this->ut->flashMessage("general", $request, $result);
//
//    }
//
//    private function deleteImages(Request $request){
//        $arrayPhotos = $request->get('trade')['offer']['photos'];
//
//        $idsPhotos = array();
//        $flashMessage['result'] = 'ok';
//
//        foreach($arrayPhotos as $key => $photo):
//            if(key_exists('checkPhoto', $photo)):
//                $idsPhotos[] = array('id'=> $photo['id'], 'pos' => $key);
//            endif;
//        endforeach;
//
//        if(!empty($idsPhotos)):
//
//            $file = MyConstants::PATH_APIREST."services/photos/delete_offer_photo.php";
//            $data['id'] = $this->session->get('id');
//            $data['username'] = $this->session->get('username');
//            $data['password'] = $this->session->get('password');
//            $data['offer_id'] = $this->offer->getId();
//
//            foreach($idsPhotos as $photo):
//
//                $data['photos_id'] = $photo['id'];
//
//                $ch = new ApiRest();
//                $result = $ch->resultApiRed($data, $file);
//                $result['result'] = 'ok';
//                if($result['result'] == 'ok'):
//
//                    $this->offer->getOffer()->removePhotoByPos($photo['pos']);
//                else:
//                    $flashMessage['result'] = 'ko';
//                endif;
//            endforeach;
//
//            $this->ut->flashMessage("general", $request, $result);
//        endif;
//
//    }
//
//    private function uploadImage($arrayImage){
//        $arrayPhotos = null;
//        $ut = new Utilities();
//        $arrayPhotos = $ut->uploadImage($arrayImage, $this->session->get('id'));
//
//        $filePhotos = MyConstants::PATH_APIREST."global/photo/add_photos.php";
//
//        $ch = new ApiRest();
//
//        $data['url'] = $arrayPhotos;
//        $informacion['data'] = json_encode($data);
//        $result = $ch->resultApiRed($informacion, $filePhotos);
//
//        if($result['result'] == 'ok'):
//            $idsPhotos = '';
//
//            foreach($result['photos'] as $photo):
//               $objectPhoto = new Photo($photo);
//               $this->offer->getOffer()->addPhoto($objectPhoto);
//               $idsPhotos .= $photo['id'].",";
//            endforeach;
//
//            $idsPhotos = substr($idsPhotos, 0, -1);
//
//            return $idsPhotos;
//        else:
//            $this->flashMessageErrorSearch($result['result']);
//        endif;
//
//    }
//
//    public function deleteOfferAction(Request $request){
//
//        $id = $request->get('id');
//        $session = $request->getSession();
//
//        $response = new JsonResponse();
//
//        $file = MyConstants::PATH_APIREST."services/offer/delete_offer.php";
//        $ch = new ApiRest();
//
//        $data['username'] = $session->get('username');
//        $data['id'] = $session->get('id');
//        $data['password'] = $session->get('password');
//        $data['offer_id'] = $id;
//
//        $result = $ch->resultApiRed($data, $file);
//
//        if($result['result'] == 'ok'):
//            $response->setData(array(
//                'result' => 'ok',
//                'message' => 'Oferta eliminada correctamente'));
//        else:
//             $response->setData(array(
//                'result' => 'ko',
//                'message' => 'Ha ocurrido un error, por favor vuelva a intentarlo'));
//        endif;
//
//        return $response;
//
//    }
    
}

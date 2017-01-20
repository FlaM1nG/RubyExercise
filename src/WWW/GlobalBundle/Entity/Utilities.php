<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace WWW\GlobalBundle\Entity;

use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\MyConstants;
use WWW\OthersBundle\Entity\TradeCategory;
use Symfony\Component\HttpFoundation\Request;


/**
 * Description of Utilities
 *
 * @author Rocio
 */
class Utilities{
    
    public function getArrayCategoryTrade(){

        $arrayCategory = array();

        $fileCategory = MyConstants::PATH_APIREST."services/trade/get_categories.php";

        $ch = new ApiRest();

        $result = $ch->sendInformationWihoutParameters($fileCategory);

        if(!empty($result)):
            foreach($result as $category):
                $arrayCategory[$category['id']] = new TradeCategory($category);
            endforeach;
        endif;  

        return $arrayCategory;
    }
    
    public function uploadImage($files,$id){
        
        $arrayPhotos = null;
        $photo = null;
        $i = 1;
        
        $directorio = 'C:/xampp/htdocs/img/user_'.$id;
        //$directorio = 'http://www.whatwantweb.com/img/user_'.$id;
        
        if(!file_exists($directorio)):
            mkdir($directorio, 0777, true);
        
        else:    
            $i = count(scandir($directorio))+1;
        
        endif;

        if(gettype($files) != 'array'):
            $tmpName = $files->getPathname();
            $extension = $files->getClientoriginalExtension();
            $nameImg = 'image_'.$i.".".$extension;
            $photo = $directorio.'/'.$nameImg;
            move_uploaded_file($tmpName,$directorio.'/'.$nameImg);
            return $photo;
        else:
            foreach($files as $file):
                $tmpName = $file->getPathname();
                $extension = $file->getClientoriginalExtension();
                $nameImg = 'image_'.$i.".".$extension;
                $arrayPhotos[] = $directorio.'/'.$nameImg;
                move_uploaded_file($tmpName,$directorio.'/'.$nameImg);

                $i++;
            endforeach;
            return $arrayPhotos;
        endif;
        
    }
    
    public function saveFoto($arrayImage){

        $filePhotos = MyConstants::PATH_APIREST."global/photo/add_photos.php";
        
        $ch = new ApiRest();
        
        $data['url'] = $arrayImage; 
        $informacion['data'] = json_encode($data);
        
        $result = $ch->resultApiRed($informacion, $filePhotos);
        
        return $result;

    }
    
    public function flashMessage($type, Request $request, $result = null,$messageError = null){

        $success = "";
        $error = "Se ha producido un error, por favor vuelva a intentarlo";
        
        if(!empty($messageError)) $error = $messageError;
        
        switch($type):
            case 'general':     $success = "Datos actualizados";
                                break;
            case 'offer':       $success = "Oferta creada";  
                                break;   
            case 'register':    $success = "Usuario creado";
                                if($result['result'] == 'username_exists')
                                    $error = "El usuario ya existe";
                                elseif($result['result'] =='email_exists')
                                    $error = "El email ya existe";
                                break;
            case 'confirmTlfn': $success = "Se le ha enviado un código al teléfono";
            case 'tradeImageN': $error = "Debe introducir de 1 a 5 fotos";
                                break;
            case 'message':     $success = "Mensaje enviado";
                                break;
            case 'comment':     $success = "Comentario enviado";  
                                break;
            default:
                                $success = $type;
                                break;    
                                        
        endswitch;
        
        if($result['result'] == 'ok' || $result === null):
            $request->getSession()->getFlashBag()->add('messageSuccess', $success);
        else:
            $request->getSession()->getFlashBag()->add('messageFail', $error);
        endif;
    }
    
    public function messageNoRead(Request $request){
        
        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST."user/messages/get_num_messages.php";
        $numMessage = 0;
        
        $data['id'] =  $request->getSession()->get('id');
        $data['username'] =  $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        
        $result = $ch->resultApiRed($data, $file);
        
        if($result['result'] == 'ok')
            $numMessage = $result['num_messages'];
        
        return $numMessage;
    }
}


<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace WWW\GlobalBundle\Entity;

use WWW\GlobalBundle\Entity\ApiRest;
use WWW\OthersBundle\Entity\TradeCategory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Description of Utilities
 *
 * @author Rocio
 */
class Utilities{
    
    public function getArrayCategoryTrade(){

        $arrayCategory = array();

        $fileCategory = "http://www.whatwantweb.com/api_rest/services/trade/get_categories.php";

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
        $i = 1;
        
        $directorio = 'C:/xampp/htdocs/img/user_'.$id;
        //$directorio = 'http://www.whatwantweb.com/img/user_'.$this->usuario->getId();
        
        if(!file_exists($directorio)):
            mkdir($directorio, 0777, true);
        
        else:    
            $i = count(scandir($directorio))+1;
        
        endif;

        foreach($files as $file):
            $tmpName = $file->getPathname();
            $extension = $file->getClientoriginalExtension();
            $nameImg = 'image_'.$i.$extension;
            $arrayPhotos[] = $directorio.'/'.$nameImg;
            move_uploaded_file($tmpName,$directorio.'/'.$nameImg);
            
            $i++;
        endforeach;
        
        return $arrayPhotos;
    }
    
    public function flashMessage($type, Request $request, $result = null){
        $session = $request->getSession();
        print_r($session);
        $success = "";
        $error = "Se ha producido un error, por favor vuelva a intentarlo";
        
        switch($type):
            case 'general':     $success = "Datos actualizados correctamente";
                                break;
            case 'offer':       $success = "Oferta creada";  
                                break;   
            case 'register':    $success = "Usuario creado";
                                if($result['result'] == 'username_exists')
                                    $error = "El usuario ya existe";
                                break;
        endswitch;
        
        if($result['result'] == 'ok' || empty($result)):
            $request->getSession()->getFlashBag()->add('messageSuccess', $success);
        else:
            $request->getSession()->getFlashBag()->add('messageFail', $error);
        endif;
    }
}


<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace WWW\GlobalBundle\Entity;

use WWW\GlobalBundle\Entity\ApiRest;
use WWW\OthersBundle\Entity\TradeCategory;

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
}


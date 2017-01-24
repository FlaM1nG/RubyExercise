<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace WWW\GlobalBundle\Entity;

/**
 * Description of ApiRed
 *
 * @author Rocio
 */
class ApiRest {
    //put your code here
    private $ch;
    
    function __construct() {
        $this->ch = curl_init();
    }
    
    public function sendInformation($data, $file,$type){
        
        $information = null;
        if($type == "parameters"):
            $information = "";
            $firstItem = true;
        
            foreach($data as $key => $value):

                if($firstItem):
                    $firstItem = false;
                    $information .= $key."=".$value;
                else:
                    $information .= "&".$key."=".$value;
                endif;

            endforeach;
        elseif($type == "json"):
            $information['data'] = json_encode($data);
        
        endif;
        
        //echo  $information;
        return $this->resultApiRed($information, $file);
    }
    
    public function sendSeveralInformation($dataParameter, $dataJSON, $file){
        $information = null;

        foreach($dataParameter as $key => $value):
            $information[$key] = $value;

        endforeach;
        
        $information['data'] = json_encode($dataJSON);        
        
        return $this->resultApiRed($information, $file);
    }
    public function resultApiRed($data, $file){
        
        // definimos la URL a la que hacemos la petición
        curl_setopt($this->ch, CURLOPT_URL, $file);
        // indicamos el tipo de petición: POST
        curl_setopt($this->ch, CURLOPT_POST, TRUE);
        
        // definimos cada uno de los parámetros
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);
        // recibimos la respuesta y la guardamos en una variable
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
            
        $remote_server_output = curl_exec ($this->ch);
        
        $result = json_decode($remote_server_output, true);
        
        curl_close ($this->ch);
           
        return $result;
         
    }
    
    public function sendInformationWihoutParameters($file){
        
        // definimos la URL a la que hacemos la petición
        curl_setopt($this->ch, CURLOPT_URL, $file);
        // recibimos la respuesta y la guardamos en una variable
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        
        $remote_server_output = curl_exec ($this->ch);
        
        $result = json_decode($remote_server_output, true);
        
        curl_close ($this->ch);
           
        return $result;
    }
    
    public function closeConection(){
        curl_close($this->ch);
    }
}

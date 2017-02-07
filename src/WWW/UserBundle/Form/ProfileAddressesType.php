<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace WWW\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use WWW\GlobalBundle\Form\AdressType;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\MyConstants;

/**
 * Description of ProfileAddressesType
 *
 * @author Rocio
 */
class ProfileAddressesType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){

        $arrayPrefix = $this->getPrefixes();
        
        $builder
                ->add('addresses', CollectionType::class, array('entry_type' => AdressType::class,
                                                                'allow_add' => true,    
                                                                'by_reference' => false,
                                                            ))
                
                ->add('deleteAddresses',SubmitType::class,array('label' => 'Borrar',
                                                                'validation_groups' => false))
                
                ->add('addAddress',SubmitType::class,array('label' => 'Añadir',
                                                            'validation_groups' => false ));
                
                                                            
    }
    
     private function getPrefixes(){
        $arrayPrefix = array();
        $filePrefix = MyConstants::PATH_APIREST."global/prefix/get_prefixes.php";
       
        $ch = new ApiRest();
        
        $result = $ch->sendInformationWihoutParameters($filePrefix);

        if(!empty($result)):
            foreach($result as $prefix):
                $arrayPrefix[$prefix['prefix']] =  $prefix['prefix'];
            endforeach;
        endif;
        
        return $arrayPrefix;
    }

    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data_class'=>'WWW\UserBundle\Entity\User'
            ));
    }
    
    public function getBlockPrefix(){
        return 'profileAddress';
    }
}

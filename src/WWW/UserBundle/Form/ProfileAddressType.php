<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProfileType
 *
 * @author Rocio
 */

namespace WWW\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use WWW\UserBundle\Form\AdressType;
      
class ProfileAddressType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        
        $builder
               
            ->add('addresses', CollectionType::class,array(
                                                    'entry_type' => AdressType::class,
                                                    'label' => ' ' ,
                                                    'allow_add' => true,
                                                    'prototype' => true,
                                                    'by_reference' => false,
                                                    ))
                
            ->add('section','hidden' ,array('data'=>'address',
                                            'mapped' => false))    

            ->add('saveAddress','submit',array('label'=>'Guardar'));        
    }
    
    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data-class'=>'WWW\UserBundle\Entity\User'));
    }

    public function getBlockPrefix(){
        return 'profileUser';
    }

}
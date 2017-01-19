<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace WWW\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Description of ProfilePhoneType
 *
 * @author Rocio
 */
class ConfirmCodePhoneType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        
        $builder
                
                ->add('codConfirmation', 'text', array('label' => 'Código de confirmación',
                                                        'mapped' => false,
                                                        'required' => false))

                ->add('confirmPhone',SubmitType::class, array('label' => 'Confirmar',
                                                      'validation_groups' => false)) ;
                

    }
    
    public function getBlockPrefix(){
        return 'profilePhone';
    }
}



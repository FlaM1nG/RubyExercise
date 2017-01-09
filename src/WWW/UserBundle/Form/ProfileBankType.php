<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace WWW\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Description of ProfileBankType
 *
 * @author Rocio
 */
class ProfileBankType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){

        $builder
                ->add('numAccount',TextType::class, array('label' => 'Número de cuenta',
                                                          'required' => false))
                ->add('saveBank','submit',array('label' => 'Guardar',
                                                'validation_groups' => array('bank')));
                                                             
    }
    
    public function getBlockPrefix(){
        return 'profileBank';
    }
}

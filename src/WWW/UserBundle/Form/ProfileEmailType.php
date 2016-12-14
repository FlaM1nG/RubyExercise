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
      
class ProfileEmailType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        
        $builder
                
            ->add('email','repeated',array('type'=>'email',
                                           'first_options' => array('label' => 'Nuevo email',
                                                                    'data' => '' ),
                                           'second_options' => array('label' => 'Repite email',
                                                                      'data' => ''),
                                           'invalid_message' => 'Los emails deben coincidir' ))

            ->add('password', 'password', array('label' => 'Contraseña'))

            ->add('section','hidden' ,array('data'=>'email',
                                            'mapped' => false))    

            ->add('saveEmail','submit',array('label'=>'Guardar'));
    }
    
    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data-class'=>'WWW\UserBundle\Entity\User'));
    }

    public function getBlockPrefix(){
        return 'profileUser';
    }

}
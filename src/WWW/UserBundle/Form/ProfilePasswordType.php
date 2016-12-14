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
      
class ProfilePasswordType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        
        $builder
                
            ->add('oldPassword', 'password', array('label' => 'Contraseña actual',
                                                   'mapped' => false))

            ->add('password', 'repeated', array(
                                            'type' => 'password',
                                            'invalid_message' => 'Las dos contraseñas deben coincidir',
                                            'first_options' => array('label' => 'Nueva Contraseña'),
                                            'second_options' => array('label' => 'Repite Contraseña'),
                                          ))
                
            ->add('section','hidden' ,array('data'=>'password',
                                            'mapped' => false))    

            ->add('savePassword','submit',array('label'=>'Guardar'));
    }
    
    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data-class'=>'WWW\UserBundle\Entity\User'));
    }

    
    public function getBlockPrefix(){
        return 'profileUser';
    }

}
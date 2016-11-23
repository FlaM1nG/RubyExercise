<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ChangePassType
 *
 * @author Julio
 */


namespace WWW\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePassType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        
        $builder
                
                ->add('password', 'repeated', array(
                                                'type' => 'password',
                                                'invalid_message' => 'Las dos contraseñas deben coincidir',
                                                'first_options' => array('label' => 'Contraseña'),
                                                'second_options' => array('label' => 'Repite Contraseña'),
                                                'required' => false
                                              )
                        )
                ->add('guardar','submit',array('label'=>'Guardar'));
    }
        
    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data-class'=>'WWW\UserBundle\Entity\User'));
    }
    
    public function getBlockPrefix(){
        return 'cambiarPass';
    }
}

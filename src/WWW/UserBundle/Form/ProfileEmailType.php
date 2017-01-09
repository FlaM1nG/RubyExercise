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

/**
 * Description of ProfileEmailType
 *
 * @author Rocio
 */
class ProfileEmailType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        
        $builder
                ->add('email','repeated',array('type'=>'email',
                                                'first_options' => array('label' => 'Nuevo email',
                                                                    'data' => '' ),
                                                'second_options' => array('label' => 'Repite email',
                                                                      'data' => ''),
                                                'invalid_message' => 'Los emails deben coincidir',
                                                'required'=>false,
                                                'validation_groups' => 'email'))

                ->add('passwordEnClaro', 'password', array('label' => 'Contraseña',
                                                            'required'=>false,
                                                            'validation_groups' => array('email','password')))
                
                ->add('saveEmail',SubmitType::class,array('label' => 'Guardar',
                                                          'validation_groups' => array('email')));
    }

    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data_class'=>'WWW\UserBundle\Entity\User',
                                     'validation_groups' => array('email','password')
            ));
    }
    
    public function getBlockPrefix(){
        return 'profileEmail';
    }
}

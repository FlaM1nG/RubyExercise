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
 * Description of ProfilePasswordType
 *
 * @author Rocio
 */
class ProfilePasswordType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        
        $builder

                ->add('passwordEnClaro', 'password', array('label' => 'Contraseña actual',
                                                            'required'=>false,
                                                            'validation_groups' => array('password')))
                
                ->add('password','repeated',array('type'=>'password',
                                                'first_options' => array('label' => 'Nueva Contraseña',
                                                                    'data' => '' ),
                                                'second_options' => array('label' => 'Repita contraseña',
                                                                      'data' => ''),
                                                'invalid_message' => 'Las contraseñas deben coincidir',
                                                'required'=>false,
                                                'validation_groups' => 'password'
                    ))
                
                ->add('savePassword',SubmitType::class,array('label' => 'Guardar',
                                                             'validation_groups' => array('password')));
                                                            
    }

    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data_class'=>'WWW\UserBundle\Entity\User',
                                     'validation_groups' => array('password')
            ));
    }
    
    public function getBlockPrefix(){
        return 'profilePassword';
    }
}

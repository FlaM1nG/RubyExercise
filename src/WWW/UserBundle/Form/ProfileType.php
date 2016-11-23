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
      
class ProfileType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        
        $builder
                ->add('username','text', array('label'=>'Nombre de usuario',
                                               'read_only' => true))
                
                ->add('email','email',array('label'=>'Email'))
                
                ->add('birthdate','birthday', array(
                                    'label' =>'Fecha de nacimiento',
                                    'format' =>'dd-MM-yyyy',
                                    'required'=>false))
                
                ->add('oldPassword', 'password', array('label' => 'Contraseña',
                                                       'mapped' => false))
                
                ->add('password', 'repeated', array(
                                                'type' => 'password',
                                                'invalid_message' => 'Las dos contraseñas deben coincidir',
                                                'first_options' => array('label' => 'Nueva Contraseña'),
                                                'second_options' => array('label' => 'Repite Contraseña'),
                                                
                                              ))
                
                ->add('name','text', array('label'=>'Nombre'))
                ->add('surname','text',array('label'=>'Apellidos'))
                ->add('phone','number',array('label'=>' '))
                ->add('prefix','text',array('label' => 'Teléfono'))
                ->add('codConfirmation', 'text', array('label' => 'Código de confirmación',
                                                        'mapped' => false))
                ->add('confirmPhone', 'submit', array('label' => 'Confirmar'))
                ->add('photo','file',array('label'=>'foto'))
                ->add('sex','choice',array(
                                    'choices'=>array('m'=>'Mujer','h'=>'hombre'),
                                    'label'=>'Sexo'))
                ->add('linkInvitation','text',array('label'=>'Invitación'))
                ->add('addresses', CollectionType::class,array(
                                                        'entry_type' => AdressType::class,
                                                        'label' => ' ' ,
                                                        'allow_add' => true,
                                                        'prototype' => true,
                                                        'by_reference' => false,
                                                        ))
                ->add('num_account','text', array('label' => 'Número de cuenta'))
                ->add('registrar','submit',array('label'=>'Guardar'));
    }
    
    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data-class'=>'WWW\UserBundle\Entity\User'));
    }
    
     /*public function getDefaultOptions(array $options)
    {
        return array('data_class' => 'WWW\UserBundle\Entity\User');
    }*/
    
    public function getBlockPrefix(){
        return 'profileUser';
    }

}
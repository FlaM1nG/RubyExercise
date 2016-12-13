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
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use WWW\UserBundle\Form\AdressType;
use WWW\GlobalBundle\Entity\ApiRest;
      
class ProfileType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        
        $arrayPrefix = array();
        $filePrefix = "http://www.whatwantweb.com/api_rest/global/prefix/get_prefixes.php";
       
        $ch = new ApiRest();
        
        $result = $ch->sendInformationWihoutParameters($filePrefix);
        
        foreach($result as $prefix):
            $arrayPrefix[$prefix['prefix']] =  $prefix['prefix'];
        endforeach;
        
        $builder
                ->add('username','text', array('label'=>'Nombre de usuario',
                                               'read_only' => true,
                                               'required' => false))
                
                ->add('email','email',array('label'=>'Email',
                                            'required' => false))
                
                ->add('birthdate','birthday', array(
                                    'label' =>'Fecha de nacimiento',
                                    'format' =>'dd-MM-yyyy',
                                    'required'=>false))
                
                ->add('oldPassword', 'password', array('label' => 'Contraseña',
                                                       'mapped' => false,
                                                       'required' => false))
                
                ->add('password', 'repeated', array(
                                                'type' => 'password',
                                                'invalid_message' => 'Las dos contraseñas deben coincidir',
                                                'first_options' => array('label' => 'Nueva Contraseña'),
                                                'second_options' => array('label' => 'Repite Contraseña'),
                                                'required' => false
                                                
                                              ))
                
                ->add('name','text', array('label'=>'Nombre',
                                           'required' => false))
                ->add('surname','text',array('label'=>'Apellidos',
                                             'required' => false))
                ->add('phone','number',array('label'=>' ',
                                             'required' => false))
                ->add('prefix',ChoiceType::class, array('label' => 'Teléfono',
                                                        'required' => false,
                                                        'empty_value' => false,
                                                        'choices' => $arrayPrefix,
                                                        ))
                
                ->add('codConfirmation', 'text', array('label' => 'Código de confirmación',
                                                        'mapped' => false,
                                                        'required' => false))
                ->add('confirmPhone', 'submit', array('label' => 'Confirmar'))
                ->add('photo','file',array('label'=>'foto',
                                           'required' => false))
                ->add('sex','choice',array(
                                    'choices'=>array('m'=>'Mujer','h'=>'hombre'),
                                    'label'=>'Sexo'))
                ->add('linkInvitation','text',array('label'=>'Invitación'))
                ->add('phone','number',array('label'=>'Teléfono'))
                ->add('addresses', CollectionType::class,array(
                                                        'entry_type' => AdressType::class,
                                                        'label' => ' ' ,
                                                        'allow_add' => true,
                                                        'prototype' => true,
                                                        'by_reference' => false,
                                                        ))
                ->add('num_account','text', array('label' => 'Número de cuenta'))
                ->add('deleteUser', 'submit', array('label' => 'Darse de baja'))
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

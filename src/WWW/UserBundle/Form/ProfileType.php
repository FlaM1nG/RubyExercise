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
                ->add('username','text', array('label'=>'Nombre de usuario'))
                ->add('email','email',array('label'=>'Email'))
                ->add('birthdate','birthday', array(
                                    'label' =>'Fecha de nacimiento',
                                    'format' =>'dd-MM-yyyy',
                                    'required'=>false))
                ->add('password', 'repeated', array(
                                                'type' => 'password',
                                                'invalid_message' => 'Las dos contraseñas deben coincidir',
                                                'first_options' => array('label' => 'Contraseña'),
                                                'second_options' => array('label' => 'Repite Contraseña'),
                                                
                                              )
                        )
                ->add('name','text', array('label'=>'Nombre'))
                ->add('surname','text',array('label'=>'Apellidos'))
                ->add('photo','file',array('label'=>'foto'))
                ->add('sex','choice',array(
                                    'choices'=>array('m'=>'Mujer','h'=>'hombre'),
                                    'label'=>'Sexo'))
                ->add('linkInvitation','text',array('label'=>'Invitación'))
                ->add('phone','integer',array('label'=>'Teléfono'))
                ->add('addresses',CollectionType::class,array(
                                                        'type'=>new AdressType(),
                                                        'label' => ' '    
                                                        ))
                ->add('registrar','submit',array('label'=>'Guardar'));
    }
    
    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data-class'=>'WWW\UserBundle\Entity\User'));
    }
    
    public function getBlockPrefix(){
        return 'profileUser';
    }
}

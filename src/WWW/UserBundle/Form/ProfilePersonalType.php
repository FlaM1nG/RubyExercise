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
      
class ProfilePersonalType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        
        $builder
                ->add('username','text', array('label'=>'Nombre de usuario',
                                               'read_only' => true,
                                               'required' => false))
                
                ->add('birthdate','birthday', array(
                                    'label' =>'Fecha de nacimiento',
                                    'format' =>'dd-MM-yyyy',
                                    'required'=>false))
                
                ->add('name','text', array('label'=>'Nombre',
                                           'required' => false))
                ->add('surname','text',array('label'=>'Apellidos',
                                             'required' => false))

                ->add('sex','choice',array(
                                    'choices'=>array('m'=>'Mujer','h'=>'hombre'),
                                    'label'=>'Sexo',
                                    'required' => false))
                
                ->add('section','hidden' ,array('data'=>'personal',
                                                'mapped' => false))
                
                ->add('linkInvitation','text',array('label'=>'Invitación',
                                                    'required' => false,
                                                    'read_only' => true))
               
                ->add('saveData','submit',array('label'=>'Guardar'));
    }
    
    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array(
            'data-class'=>'WWW\UserBundle\Entity\User',
            'error_mapping' => array('adult' => 'birthdate')));
    }

    public function getBlockPrefix(){
        return 'profileUser';
    }

}
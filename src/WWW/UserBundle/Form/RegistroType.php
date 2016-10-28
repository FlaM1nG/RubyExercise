<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RegistroType
 *
 * @author Rocio
 */


namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistroType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        
        $builder ->add('username','text', array('label'=>'Nombre de usuario'));
        $builder
                ->add('username','text', array('label'=>'Nombre de usuario'))
                ->add('email','email',array('label'=>'Email'))
                ->add('password', 'repeated', array(
                                                'type' => 'password',
                                                'invalid_message' => 'Las dos contraseñas deben coincidir',
                                                'first_options' => array('label' => 'Contraseña'),
                                                'second_options' => array('label' => 'Repite Contraseña'),
                                                'required' => false
                                              )
                        )
                ->add('guardar','submit',array('label'=>'Registrarse'));
    }
        
    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefault(array('data-class'=>UserBundle\Entity\User));
    }
    
    public function getBlockPrefix(){
        return 'registroUsuario';
    }
}

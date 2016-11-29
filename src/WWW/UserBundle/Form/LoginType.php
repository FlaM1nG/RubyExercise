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
use Symfony\Component\HttpFoundation\Session\Session;


/**
 * Description of LoginType
 *
 * @author Rocio
 */
class LoginType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){

        $builder
                ->add('username','text', array('label'=>'Usuario', 'required'=>false))
                ->add('password','password', array('label' => 'Contraseña'))
                ->add('enviar','submit',array('label'=>'Enviar'))
                ->add('password2','password', array('label' => 'Contraseña','mapped'=>false))
                ->add('captcha', 'captcha', array( 'as_url' => true, 
                                                   'reload' => true,
                                                   'label' => " "));
    }
    
    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data-class'=>'WWW\UserBundle\Entity\User'));
    }
    
    public function getBlockPrefix(){
        return 'loginUser';
    }
}

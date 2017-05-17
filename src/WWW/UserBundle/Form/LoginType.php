<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace WWW\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


/**
 * Description of LoginType
 *
 * @author Rocio
 */
class LoginType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){

        $builder
                ->add('_username',TextType::class, array('label'=>'Usuario'))
                ->add('_password',PasswordType::class, array('label' => 'Contraseña'))
                ->add('enviar',SubmitType::class, array('label'=>'Enviar'));
//                ->add('captcha', 'captcha', array( 'as_url' => true, 
//                                                   'reload' => true,
//                                                   'label' => " "));
    }
    
    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data-class'=>'WWW\UserBundle\Entity\User'));
    }
    
    public function getBlockPrefix(){
        return 'loginUser';
    }
}

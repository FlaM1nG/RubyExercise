<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ForgotPassType
 *
 * @author Julio
 */


namespace WWW\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForgotPassType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        
        $builder
                ->add('email',EmailType::class, array('label'=>'Email',
                                                        'validation_groups' => false))

                ->add('guardar','submit',array('label'=>'Enviar'));
    }
        
    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data-class'=>'WWW\UserBundle\Entity\User', 'validation_groups' => false));
    }
    
    public function getBlockPrefix(){
        return 'passOlvidado';
    }
}

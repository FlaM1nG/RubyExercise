<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace WWW\UserBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of UserType
 *
 * @author Rocio
 */
class UserType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){

        $builder
                
                ->add('username',TextType::class,array('label' => ' '));
                
                
    }
    
    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data_class' => 'WWW\UserBundle\Entity\User'));
    }
    
    public function getBlockPrefix(){
        return 'userMessage';
    }
}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MessageType
 *
 * @author Julio
 */

namespace WWW\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

      
class ProfileType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        
        $builder
                ->add('id_from',TextType::class,array('attr'=>array('class'=>'form-control')))
                ->add('subject',TextType::class,array('attr'=>array('class'=>'form-control')))
                ->add('message',TextareaType::class,array('attr'=>array('class'=>'form-control')))
                
                ->add('enviar', 'submit', array('label' => 'Guardar'));
    }

    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data-class'=>'WWW\UserBundle\Entity\User'));
    }
    
   
    
    public function getBlockPrefix(){
        return 'message';
    }

}

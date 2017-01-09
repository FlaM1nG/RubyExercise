<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProfileMessageType
 *
 * 
 */

namespace WWW\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
      
class ProfileMessageType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        
        $builder
               ->add('sent', CollectionType::class, array('entry_type' => MessageType::class,   
                                                          'by_reference' => false, 
                                                          'allow_delete' => true,
                                                          'allow_add' => true,
                                                            ))
               ->add('received', CollectionType::class, array('entry_type' => MessageType::class,   
                                                              'by_reference' => false,
                                                              'allow_delete' => true,
                                                              'allow_add' => true,
                                                            ))
               ->add('idRemove', HiddenType::class, array('mapped' => false))
               ->add('fromTo', HiddenType::class, array('mapped' => false)) 
               ->add('newMessageButton', SubmitType::class, 
                       array('label' => 'Nuevo',
                       'attr' => array('class' => 'newMessageButton btn btn-default'))); 
    }

    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('validation_groups' => false));
    }
        
    public function getBlockPrefix(){
        return 'profileMessage';
    }

}

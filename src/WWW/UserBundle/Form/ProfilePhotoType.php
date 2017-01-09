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
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use WWW\GlobalBundle\Form\PhotoType;

/**
 * Description of ProfilePhotoType
 *
 * @author Rocio
 */
class ProfilePhotoType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        
        $builder
                ->add('photo',PhotoType::class)
                
                ->add('fileImage',FileType::class, array('label' =>' ',
                                                         'mapped' => false,
                                                         'attr' => array('accept'=>'image/*'),
                                                         'required' => false))
                
                ->add('savePhoto',SubmitType::class,array('label' => 'Guardar',
                                                          'validation_groups' => false  ));
                                                            
    }

    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data_class'=>'WWW\UserBundle\Entity\User'
            ));
    }
    
    public function getBlockPrefix(){
        return 'profilePhoto';
    }
}

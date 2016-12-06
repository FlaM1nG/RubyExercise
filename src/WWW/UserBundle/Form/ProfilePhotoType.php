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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use WWW\UserBundle\Form\AdressType;
use WWW\GlobalBundle\Entity\ApiRest;
      
class ProfilePhotoType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){

        $builder
               
            ->add('photo','file',array('label'=>'foto',
                                       'required' => false))
            
            ->add('section','hidden' ,array('data'=>'photo',
                                            'mapped' => false))    

            ->add('savePhoto','submit',array('label'=>'Guardar'));    
                
    }
    
    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data-class'=>'WWW\UserBundle\Entity\User'));
    }

    public function getBlockPrefix(){
        return 'profileUser';
    }

}
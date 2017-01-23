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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Description of ProfilePersonalDataType
 *
 * @author Rocio
 */
class ProfilePersonalDataType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){

       $builder
                

                ->add('unsubscribe',SubmitType::class,array('label' => 'Guardar',
                                                                 'validation_groups' => 'personalData'));
                
               
    }

    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data_class'=>'WWW\UserBundle\Entity\User',
                                     'validation_groups' => array('personalData'),
            ));
    }
    
    public function getBlockPrefix(){
        return 'profileUnsubscribe';
    }
}

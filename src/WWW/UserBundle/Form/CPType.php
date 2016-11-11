<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace WWW\UserBundle\Form;

use WWW\UserBundle\Form\EventListener\AddFieldSubscriber;

/**
 * Description of CPType
 *
 * @author Rocio
 */

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CPType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
                ->add('zip_code','text', array('label'=>'CP'))
                ->add('city','text', array('label'=>'Ciudad'))
                ->add('region','text', array('label' => 'Región'))
                ->add('country', 'text', array('label' => 'País'))
                ->add('id','hidden');       
    }
    
    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data-class'=>'WWW\UserBundle\Entity\ZipCode'));
    }
    
    public function getBlockPrefix(){
        return 'cpAddress';
    }
}

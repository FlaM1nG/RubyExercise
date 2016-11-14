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

/**
 * Description of AdressType
 *
 * @author Rocio
 */
class AdressType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
                ->add('street','text', array('label'=>'Calle',
                                             'read_only' => true))
                ->add('name','text', array('label'=>'Nombre dirección',
                                             'read_only' => true))
                ->add('isDefault','checkbox', array('label' => 'Dirección principal',
                                                    'disabled' => true))
                //->add('cp', new CPType(),array('label' => ' '))
                ->add('id','hidden', array('label' => ' '));        
    }
    
    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data-class'=>'WWW\UserBundle\Entity\Address'));
    }
    
    public function getBlockPrefix(){
        return 'adressUser';
    }
    
    function getName()
    {
        return 'address';
    }
     function getIdentifier()
    {
        return 'address';
    }

    
}
 
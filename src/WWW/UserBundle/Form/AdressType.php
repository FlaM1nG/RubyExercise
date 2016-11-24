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
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use WWW\GlobalBundle\Entity\ZipCode;

/**
 * Description of AdressType
 *
 * @author Rocio
 */
class AdressType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
                ->add('street','text', array('label'=>'Calle',
                                             ))
                ->add('name','text', array('label'=>'Nombre dirección',
                                             'read_only' => true))
                ->add('isDefault','checkbox', array('label' => 'Dirección principal',
                                                    'disabled' => true))
                ->add('zipCode','text', array('label'=>'CP',
                                              'attr' => array('class' => 'zipCode')  ))
                ->add('city','text', array('label'=>'Ciudad'))
                ->add('region','text', array('label' => 'Región'))
                ->add('country', 'text', array('label' => 'País'))
                ->add('idZipCode','hidden')       
                ->add('id','hidden', array('label' => ' '));        
    }
    
    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data-class'=>'WWW\GlobalBundle\Entity\Address'));
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
 
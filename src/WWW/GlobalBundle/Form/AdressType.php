<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace WWW\GlobalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

/**
 * Description of AdressType
 *
 * @author Rocio
 */
class AdressType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
                
                ->add('name','text', array('label'=>'Nombre dirección',
                                           'validation_groups' => array('address') ))
                
                ->add('isDefault','checkbox', array('label' => 'Dirección principal',
                                                    'required' => false,
                                                    ))
                
                ->add('country', CountryType::class , array('label' => 'País',
                                                            'validation_groups' => array('address'),))
                
                ->add('region','text', array('label' => 'Región',
                                             'validation_groups' => array('address') ))
                
                ->add('city','text', array('label'=>'Ciudad',
                                           'validation_groups' => array('address')))
                
                ->add('street','text', array('label'=>'Dirección',
                                             'validation_groups' => array('address')))
                
                ->add('zipCode','text', array('label'=>'CP',
                                              'attr' => array('class' => 'zipCode'),
                                              'validation_groups' => array('address')))
                
                
                     
                ->add('id','hidden', array('label' => ' '))
                ->add('editAddress','submit',array('label' => 'Guardar',
                                                   'validation_groups' => false,
                                                    'attr' => array('class' => 'editAddressButton')))
                ->add('checkDeleteAddress','checkbox', array('label' => '',
                                                             'required' => false,
                                                             'mapped' => false,
                                                             'attr' => array('class' => 'checkDeleteAddress' )));
    }
    
    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data_class'=>'WWW\GlobalBundle\Entity\Address',
                                     'validation_groups' => array('address')));
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
 
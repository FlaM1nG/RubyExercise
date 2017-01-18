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
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

use WWW\GlobalBundle\Entity\Photo;

/**
 * Description of PohoType
 *
 * @author Rocio
 */
class PhotoType extends AbstractType{
    
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        
        $builder
                
                ->add('id',HiddenType::class)
                ->add('url',UrlType::class, array('label'=>' ',
                                                  'read_only' =>true,
                                                ));
//                ->add('checkPhoto',CheckboxType::class,array('label' => ' ',
//                                                             'mapped' => false,
//                                                             'required' => false ));
                
    }
    
    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data_class'=>Photo::class));
    }



    
}
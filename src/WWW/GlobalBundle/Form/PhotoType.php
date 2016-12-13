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
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

use WWW\GlobalBundle\Entity\Photo;

/**
 * Description of OfferType
 *
 * @author Rocio
 */
class PhotoType extends AbstractType{
    
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
                
                ->add('id',HiddenType::class)
                ->add('url',UrlType::class, array('label'=>'Imagen',
                                                  'read_only' =>true,
                                             ))
                ->add('fileImage',FileType::class, array('label' =>' ',
                                                         'mapped' => false,
                                                         'multiple' => true,
                                                         'attr' => array('accept'=>'image/*')));
                
    }
    
    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data-class'=>'WWW\GlobalBundle\Entity\Photo'));
    }



    
}
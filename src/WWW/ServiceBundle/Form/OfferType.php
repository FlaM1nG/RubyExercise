<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace WWW\ServiceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use WWW\GlobalBundle\Form\PhotoType;

/**
 * Description of OfferType
 *
 * @author Rocio
 */
class OfferType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){

        $builder
                
                ->add('photos',CollectionType::class, array('entry_type' => PhotoType::class,
                                                            'allow_add' => true,
                                                            'allow_delete' => true,    
                                                            'by_reference' => false))

                ->add('fileImage',FileType::class, array('label' =>' ',
                                                         'mapped' => false,
                                                         'multiple' => true,
                                                         'required' => false,
                                                         'attr' => array('accept'=>'image/*')))
                ->add('title','text', array('label'=>'Título',
                                            'attr' => array('placeholder' => 'Titulo')))

                ->add('expired',HiddenType::class)

                ->add('id',HiddenType::class, array('attr' => array('class' => 'idOffer') ))

                ->add('holders', IntegerType::class, array('label' => '',
                                                           'empty_data' => '1',
                                                           'attr' => array('min' =>1)))

                ->add('description','textarea', array('label'=>'Descripción',
                                                    'required' => false,
                                                    'attr' => array('placeholder' => 'Introduzca la descripción que desea que se muestre con su oferta.'),

                ));
                
    }
    
    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data_class' => 'WWW\ServiceBundle\Entity\Offer'));
    }



    
}

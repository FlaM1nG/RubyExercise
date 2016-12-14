<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace WWW\ServiceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use WWW\ServiceBundle\Entity\Offer;
use WWW\GlobalBundle\Form\PhotoType;

/**
 * Description of OfferType
 *
 * @author Rocio
 */
class OfferType extends AbstractType{
    
    private $typeService;
    
    /*public function __construct($servicio = null) {
        
        //Tipo de servicio para añadir unos campo u otros a la oferta
        $this->typeService = $servicio; 
    }*/
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
                
                ->add('photos',CollectionType::class, array('entry_type' => PhotoType::class,
                                                            'allow_add' => true,
                                                            'allow_delete' => true,    
                                                            'by_reference' => false,
                                                            ))
                ->add('title','text', array('label'=>'Título',
                                             ))
                ->add('description','textarea', array('label'=>'Descripción',
                                                  'required' => false ));
                
    }
    
    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data-class'=>'WWW\ServiceBundle\Entity\Offer'));
    }



    
}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace WWW\OthersBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

/**
 * Description of TradeType
 *
 * @author Rocio
 */
class TradeType extends AbstractType{
    
    private $typeService;
    
    /*public function __construct($servicio = null) {
        
        //Tipo de servicio para añadir unos campo u otros a la oferta
        $this->typeService = $servicio; 
    }*/
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        
        $builder
            ->add('priceUser',MoneyType::class, array('label' => 'Precio',
                                                      'attr' => array('placeholder' => '2.5'),
                                                      'precision' => 2,
                                                      'grouping' => true))
            ->add('dimensions','text', array('label' => 'Dimensiones'))
            ->add('weight','number', array('label' => 'Peso'));
        
    }
    
    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data-class'=>'WWW\OthersBundle\Entity\Trade'));
    }
    
    public function getBlockPrefix(){
        return 'trade';
    }
    
}
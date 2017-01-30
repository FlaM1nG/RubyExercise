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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use WWW\GlobalBundle\Entity\Utilities;
use WWW\ServiceBundle\Form\OfferType;
use WWW\OthersBundle\Entity\Trade;
use WWW\OthersBundle\Entity\TradeCategory;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\MyConstants;

/**
 * Description of TradeType
 *
 * @author Rocio
 */
class TradeType extends AbstractType{

    
    public function buildForm(FormBuilderInterface $builder, array $options){

        $arrayCategory = $this->arrayCategories($options['data']->getCategory()->getId());
        
        $builder
            ->add('offer',OfferType::class)    
            ->add('price',MoneyType::class, array('label' => 'Precio',
                                                      'attr' => array('placeholder' => 'Introduzca la cantidad por la que desea vender el objeto'),
                                                      'precision' => 2,
                                                      'grouping' => true))
            ->add('width',NumberType::class, array('label' => 'Ancho',
                                                    'mapped' => false,
                                                    'attr' => array('placeholder' => 'Ancho en cm')
                ))
            ->add('height',NumberType::class, array('label' => 'Alto',
                                           'mapped' => false,
                                            'attr' => array('placeholder' => 'Alto en cm')
                ))
            ->add('long',NumberType::class, array('label' => 'Largo',
                                                    'mapped' => false,
                                                    'attr' => array('placeholder' => 'Largo en cm')
                ))

            ->add('weight',NumberType::class, array('label' => 'Peso',
                                                    'attr' => array('placeholder' => 'Peso en Kg')
                ))
            ->add('category',ChoiceType::class, array('label' => 'Categoria',
                                                         'required' => false,
                                                         'empty_value' => false,
                                                         'choices' => $arrayCategory,
                                                         'choices_as_values' => true,
                                                         'choice_label' => function($category) {
                                                                /** @var Category $category */
                                                                return ucfirst($category->getName());
                                                            },
                                                         'choice_value' => 'id'
                                                         ))
            
            ->add('region',TextType::class, array('label' => 'Provincia',
                                                    'attr' => array('placeholder' => 'Provincia en la que se encuentra el objeto')

            ))
            ->add('saveTrade',SubmitType::class,array('label'=>'Guardar'));
            
        
    }

    
    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data_class'=>Trade::class,
                                     'allow_extra_fields' => true,));
    }

    private function arrayCategories($id){

        $ut = new Utilities();
        return $ut->getArrayCategoryTrade($id);
        
    }
}

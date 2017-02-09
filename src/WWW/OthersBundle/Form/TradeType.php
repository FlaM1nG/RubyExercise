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
        $service = $options['data']->getCategory()->getId();
        $arrayCategory = $this->arrayCategories($service);

        $builder
            ->add('offer',OfferType::class, array('label' => ' '))
            ->add('price',MoneyType::class, array('label' => 'Precio',
                                                      'attr' => array('placeholder' => 'Introduzca la cantidad por la que desea vender el objeto'),
                                                      'precision' => 2,
                                                      'grouping' => true))

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

        if($service != 3):

            $builder
//                ->add('width',NumberType::class, array('label' => 'Ancho',
//                                                        'mapped' => false ))
//
//                ->add('height',NumberType::class, array('label' => 'Alto',
//                                                        'mapped' => false ))
//
//                ->add('long',NumberType::class, array('label' => 'Profundidad',
//                                                        'mapped' => false ))

                ->add('weight',NumberType::class, array('label' => 'Peso'));
        endif;
            
        
    }

    
    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data_class'=>Trade::class,
                                     'allow_extra_fields' => true,));
    }

    private function arrayCategories($id){

        $ut = new Utilities();
        $array = $ut->getArrayCategoryTrade($id);

        return $array;
    }
}

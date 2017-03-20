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
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use WWW\GlobalBundle\Entity\Utilities;
use WWW\ServiceBundle\Form\OfferType;
use WWW\OthersBundle\Entity\Trade;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\MyConstants;
use WWW\GlobalBundle\Entity\Region;

/**
 * Description of TradeType
 *
 * @author Rocio
 */
class TradeType extends AbstractType{

    
    public function buildForm(FormBuilderInterface $builder, array $options){
//print_r($options['data']);
        $service = $options['data']->getOffer()->getService()->getId();
        $arrayCategory = $this->arrayCategories($service);
        $arrayRegion =$this->arrayRegion();

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
            
            ->add('region',ChoiceType::class, array('label' => 'Provincia',
                                                    'attr' => array('placeholder' => 'Provincia en la que se encuentra el objeto'),
                                                    'choices' =>$arrayRegion,
                                                    'choice_value' => 'countryRegion',
                                                    'choice_label' => 'region',
                                                    'choices_as_values'=>true,
                                                    'group_by' => 'country'

            ))
            ->add('saveTrade',SubmitType::class, array('label'=>'Guardar',
                                                        'attr' => array('class' => 'btn btn-default btn-normal-derecha')));

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

    private function arrayRegion(){

        $file = MyConstants::PATH_APIREST.'global/prefix/get_regions.php';
        $ch = new ApiRest();
        $arrayRegion = null;
        $arrayCountry = null;

        $result = $ch->resultApiRed(null,$file);

        if(!empty($result)):
            foreach($result as $value):
                $arrayRegion[] = new Region($value['id'], $value['region'], $value['country']);

            endforeach;
        endif;

        return $arrayRegion;
    }
}

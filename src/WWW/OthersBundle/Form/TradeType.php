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
use WWW\ServiceBundle\Form\OfferType;
use WWW\OthersBundle\Entity\Trade;
use WWW\OthersBundle\Entity\TradeCategory;
use WWW\GlobalBundle\Entity\ApiRest;

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
        
        $arrayCategory = $this->arrayCategories();
        $builder
            ->add('offer',OfferType::class)    
            ->add('price',MoneyType::class, array('label' => 'Precio',
                                                      'attr' => array('placeholder' => '2.5'),
                                                      'precision' => 2,
                                                      'grouping' => true))
            ->add('dimensions','text', array('label' => 'Dimensiones'))
            ->add('weight','number', array('label' => 'Peso'))
            ->add('category',ChoiceType::class, array('label' => 'Categoria',
                                                         'data_class' => TradeCategory::class,
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
            
            ->add('region',TextType::class, array('label' => 'Provincia'))                                                        
            ->add('guardar','submit',array('label'=>'Guardar'));
            
        
    }

    
    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data-class'=>Trade::class));
    }

    private function arrayCategories(){
        
        $arrayCategory = array();
        
        $fileCategory = "http://www.whatwantweb.com/api_rest/services/trade/get_categories.php";
       
        $ch = new ApiRest();
        
        $result = $ch->sendInformationWihoutParameters($fileCategory);

        if(!empty($result)):
            foreach($result as $category):
                $arrayCategory[$category['id']] = new TradeCategory($category);
            endforeach;
        endif;  
        
        return $arrayCategory;
        
    }
}

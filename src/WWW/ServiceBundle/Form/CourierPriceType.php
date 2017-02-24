<?php
/**
 * Created by PhpStorm.
 * User: Rocio
 * Date: 07/02/2017
 * Time: 9:07
 */

namespace WWW\ServiceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CourierPriceType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $courierPrice = $options['courierPrice'];
        
        if(!empty($courierPrice)):
            
             $builder    
                ->add('courierPrice', ChoiceType::class, array( 'label' => 'Peso del paquete',
                                                                'choices' => $courierPrice,
                                                                'choice_value' => 'id',
                                                                'choice_label' => 'intervalWeightPrice',
                                                                'choices_as_values' => true, 'mapped'=>false));
        endif;   
        
        $builder
            ->add('subscribeButton', SubmitType::class, array('label' => 'Inscribirse'));

    }

    public function configureOptions(OptionsResolver $resolver){

        $resolver->setDefaults(array('data_class'=>'WWW\ServiceBundle\Entity\MessengerPrice',
//                                     'courierPrice' => null,
        ));
        $resolver->setRequired('courierPrice');
    }

    public function getBlockPrefix(){
        return 'courierPrice';
    }


}
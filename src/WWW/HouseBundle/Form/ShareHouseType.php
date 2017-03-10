<?php
/**
 * Created by PhpStorm.
 * User: Rocio
 * Date: 07/03/2017
 * Time: 16:35
 */

namespace WWW\HouseBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WWW\ServiceBundle\Form\OfferType;

class ShareHouseType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        
        $arrayHouses = $options['arrayHouses'];

        $builder
            ->add('house', ChoiceType::class, array('label' => 'Seleccione una casa',
                                                    'choices' => $arrayHouses,
                                                    'choice_label' => 'title',
                                                    'choice_value' => 'id',
                                                    'choices_as_values' => true,
                                                    'data' => $options['data']->getHouse() ))
            ->add('offer', OfferType::class, array('label' => ''))

            ->add('price', MoneyType::class, array('label' => 'Precio base'))

            ->add('houseId', HiddenType::class, array('data' => $options['data']->getHouse()->getId(),
                                                      'mapped'=>false  ))

            ->add('newShareHouse', SubmitType::class, array('label' => 'Guardar'));
    }

    public function configureOptions(OptionsResolver $resolver){

        $resolver->setDefaults(array('data_class' => 'WWW\HouseBundle\Entity\ShareHouse',
                                     'arrayHouses' => null));
    }

    public function getBlockPrefix(){
        return 'shareHouse';
    }

}
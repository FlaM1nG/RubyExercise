<?php
/**
 * Created by PhpStorm.
 * User: Rocio
 * Date: 07/02/2017
 * Time: 9:07
 */

namespace WWW\CarsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use WWW\ServiceBundle\Form\OfferType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ShareCarType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $listCar = $options['listCar'];
        
        $year = new \DateTime("now");
        $year = $year->format("Y");

        $defaultDate = new \DateTime("now");

        if(!empty($options['data']->getDate())):
            $defaultDate = $options['data']->getDate();
        endif;

        $arrayReadOnly = array();

        if(!empty($options['data']->getOffer()->getInscriptions()))
            $arrayReadOnly['readonly'] = true;

        $builder

            ->add('offer', OfferType::class, array( 'label' => '',
                                                    'attr' => $arrayReadOnly))

            ->add('fromPlace',TextType::class, array('label' => 'Salida',
                                                     'attr' => $arrayReadOnly))

            ->add('toPlace', TextType::class, array('label' => 'Llegada',
                                                    'attr' => $arrayReadOnly))

            ->add('date', DateTimeType::class, array('label' => 'Día y hora',
                                                     'html5' => true,
                                                     'data' => $defaultDate,
                                                     'years' => array($year,$year+1,$year+2,$year+3,$year+4),
                                                     'attr' => $arrayReadOnly))

            ->add('car', ChoiceType::class, array('label' => 'Elija el coche',
                                                  'choices' => $listCar,
                                                  'choice_value' => 'id',
                                                  'choice_label' => 'plate',
                                                  'choices_as_values' => true,
                                                  'data' => $options['data']->getCar(),
                                                  'attr' => $arrayReadOnly))

            ->add('id', HiddenType::class)

            ->add('newShareCar', SubmitType::class, array('label' => 'Guardar',
                                                            'attr' => array('class' => 'btn btn-default btn-normal-derecha')));

        if($options['data']->getOffer()->getService()->getId() == 4):

            $builder ->add('price', MoneyType::class, array('label' => 'Precio',
                                                            'attr' => $arrayReadOnly))

                     ->add('backTwo', CheckboxType::class, array('label' => 'Solo dos atrás',
                                                                 'required' => false));
        endif;

    }

    public function configureOptions(OptionsResolver $resolver){

        $resolver->setDefaults(array('data_class'=>'WWW\CarsBundle\Entity\ShareCar',
                                ));

        $resolver->setRequired('listCar');
    }

    public function getBlockPrefix(){
        return 'shareCar';
    }

    
}
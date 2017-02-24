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


class PagoType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $listDir = $options['listDirec'];

        $builder

            ->add('dirEnvio', ChoiceType::class, array(
                'label' => 'Dirección envio',
                'choices' => $listDir,
                'choice_value' => 'id',
                'choice_label' => 'title',
                'choices_as_values' => true,
//                'data' => $options['data']->getCar() // OBTENER DIRECCION
            ))

            ->add('facture', CheckboxType::class, array(
                'label' => 'Factura'
            ))

            ->add('dirFac', ChoiceType::class, array(
                'label' => 'Dirección facturación',
                'choices' => $listDir,
                'choice_value' => 'id',
                'choice_label' => 'title',
                'choices_as_values' => true,
//                'data' => $options['data']->getCar() // OBTENER DIRECCION
            ))

            ->add('PMPaypal', CheckboxType::class, array(
                'label' => 'Paypal'
            ))

            ->add('PMCard', CheckboxType::class, array(
                'label' => 'Tarjeta'
            ))

            ->add('SMCorreos', CheckboxType::class, array(
                'label' => 'Correos'
            ))

            ->add('SMDHL', CheckboxType::class, array(
                'label' => 'DHL'
            ))

            ->add('SMOtros', CheckboxType::class, array(
                'label' => 'Otros'
            ))

            ->add('newShareCar', SubmitType::class, array(
                'label' => 'Pagar'
            ));

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
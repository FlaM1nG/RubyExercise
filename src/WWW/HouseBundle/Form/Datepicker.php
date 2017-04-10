<?php
/**
 * Created by PhpStorm.
 * User: Carlos
 * Date: 10/04/2017
 * Time: 10:54
 */

namespace WWW\HouseBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Datepicker extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        {
            $builder
                ->add('DatePicker', TextType::class)

                ->add('DatePickerto', TextType::class)

                ->add('startDate', HiddenType::class)

                ->add('endDate', HiddenType::class)

                ->add('fechaInicial', IntegerType::class, array('label' => 'Fecha Inicial'))

                ->add('fechaFinal', IntegerType::class, array('label' => 'Fecha Final'))

                ->add('precioTotal', IntegerType::class, array('label' => 'Precio Total'));

        }


    }



}


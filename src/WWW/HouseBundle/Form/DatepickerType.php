<?php
/**
 * Created by PhpStorm.
 * User: Carlos
 * Date: 10/04/2017
 * Time: 10:54
 */

namespace WWW\HouseBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class DatepickerType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        {
            $builder
                ->add('DatePicker', TextType::class)

                ->add('DatePickerto', TextType::class)

                ->add('startDate', HiddenType::class)

                ->add('endDate', HiddenType::class)

                ->add('fechaInicial', FormType::class, array('label' => 'Fecha Inicial'))

                ->add('fechaFinal', FormType::class, array('label' => 'Fecha Final'))

                ->add('precioTotal', FormType::class, array('label' => 'Precio Total'))

                ->add('subscribeButton',SubmitType::class, array('label' => 'Comprar'));



        }


    }

}


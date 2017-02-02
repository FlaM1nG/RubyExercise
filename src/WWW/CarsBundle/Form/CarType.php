<?php
/**
 * Created by PhpStorm.
 * User: Rocio
 * Date: 01/02/2017
 * Time: 12:19
 */

namespace WWW\CarsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){

        $builder
            ->add('plate', TextType::class, array('label' => 'Matrícula'))
            ->add('color', TextType::class, array('label' => 'Color'))
            ->add('description', TextareaType::class, array('label' => 'Descripción' ))
            ->add('smoke', CheckboxType::class, array('label' => 'Se permite fumar',
                                                      'required' => false))
            ->add('animals', CheckboxType::class, array('label' => 'Se permiten animales',
                                                        'required' => false ))
            ->add('music', CheckboxType::class, array('label' => 'Me gusta la música e iré con ella to el viaje jajajaja',
                                                      'required' => false  ))
            ->add('talk', CheckboxType::class, array('label' => 'Me encanta hablar',
                                                     'required' => false))
            ->add('file', FileType::class, array('mapped' => false))
            ->add('saveNewCar', SubmitType::class, array('label' => 'Guardar'));
            
    }

    public function configureOptions(OptionsResolver $resolver){

        $resolver->setDefaults(array('data-class'=>'WWW\CarsBundle\Entity\Car',
                                     'validation_groups' => array('newCar')));
    }

    public function getBlockPrefix(){
        return 'newCar';
    }

}
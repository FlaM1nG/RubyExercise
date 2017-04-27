<?php
/**
 * Created by PhpStorm.
 * User: Rocio
 * Date: 27/04/2017
 * Time: 13:08
 */

namespace WWW\ServiceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CancelationType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){

        $builder
            ->add('concept', TextareaType::class, array('label' => 'Motivo'))
            ->add('sendForm', SubmitType::class, array('label' => 'Enviar'));
    }

    public function configureOptions(OptionsResolver $resolver){
        $resolver->setDefaults(array('data_class' => 'WWW\ServiceBundle\Entity\Cancelation'));
    }

}

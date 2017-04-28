<?php
/**
 * Created by PhpStorm.
 * User: Rocio
 * Date: 27/04/2017
 * Time: 13:08
 */

namespace WWW\ServiceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CancelationType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){

        $arrayAttr = array();

        if($options['inscription'] == true):
            $arrayAttr['disabled'] = true;
        endif;

        $builder
            ->add('concept', TextareaType::class, array('label' => 'Motivo'))
            ->add('cancelSend', SubmitType::class, array('label' => 'Cancelar'))
            ->add('sendForm', SubmitType::class, array('label' => 'Enviar',
                                                       'attr' => $arrayAttr));
    }

    public function configureOptions(OptionsResolver $resolver){
        $resolver->setDefaults(array('data_class' => 'WWW\ServiceBundle\Entity\Cancelation',
                                     'inscription' => null));
    }

}

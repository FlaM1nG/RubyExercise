<?php
/**
 * Created by PhpStorm.
 * User: Carlos
 * Date: 22/05/2017
 * Time: 15:47
 */

namespace WWW\GlobalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;


class CVitaeType extends AbstractType{


    public function buildForm(FormBuilderInterface $builder, array $options){

        $builder

            ->add('name', TextType::class, array('label' => 'Nombre'))

            ->add('email', EmailType::class, array('label' => 'Email'))

            ->add('subject', ChoiceType::class,array('label' =>'Puesto',
                'choices'   => array(
                    'diseñador'   => 'Diseñador Gráfico',
                    'programadormovil' => 'Programador Aplicaciones Móviles',
                    'programador'   => 'Programador Web',
                    'atencioncliente'   => 'Atención al Cliente',
                    'administrativo'   => 'Administrativo',
                    'otros'   => 'Otros',
                ),
            ))
            

            ->add('file', FileType::class, array('label' => 'Adjuntar CV'))

            ->add('message', TextareaType::class, array('label' => 'Mensaje',
                'attr' => array('row' =>'20')))

            ->add('send', SubmitType::class, array('label' => 'Enviar'));

    }

}
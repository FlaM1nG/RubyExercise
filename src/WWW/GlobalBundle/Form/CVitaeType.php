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
                    'administrativo'   => 'Administrativo',
                    'atencion_cliente'   => 'Atención al Cliente',
                    'community_manager'   => 'Community Manager',
                    'diseñador'   => 'Diseñador Gráfico',
                    'programador_movil' => 'Programador Aplicaciones Móviles',
                    'programador_seguridad'   => 'Programador Seguridad',
                    'programador_web'   => 'Programador Web',
                    'bigdata'   => 'Big Data',
                    'otros'   => 'Otros',
                ),
            ))
            

            ->add('file', FileType::class, array('label' => 'Adjuntar CV.pdf'))

            ->add('message', TextareaType::class, array('label' => 'Mensaje',
                'attr' => array('row' =>'20')))

            ->add('send', SubmitType::class, array('label' => 'Enviar'));

    }

}
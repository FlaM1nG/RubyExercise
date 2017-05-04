<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace WWW\GlobalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WWW\GlobalBundle\Entity\Photo;

/**
 * Description of ContactType
 *
 * @author Rocio
 */
class ContactType extends AbstractType{


    public function buildForm(FormBuilderInterface $builder, array $options){

        $builder

            ->add('name', TextType::class, array('label' => 'Nombre'))

            ->add('email', EmailType::class, array('label' => 'Email'))

            ->add('subject', TextType::class, array('label' => 'Asunto'))

            ->add('message', TextareaType::class, array('label' => 'Mensaje',
                                                        'attr' => array('row' =>'20')))

            ->add('send', SubmitType::class, array('label' => 'Enviar'));

    }

}
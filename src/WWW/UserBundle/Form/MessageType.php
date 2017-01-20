<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MessageType
 *
 * @author Rocio
 */

namespace WWW\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use WWW\UserBundle\Form\UserType;

      
class MessageType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        
        $builder
                ->add('id',HiddenType::class)
                ->add('from',UserType::class, array('label' => 'De','required' => false, ))
                ->add('to',UserType::class, array('label' => 'Para',
                                                  'required' => false,
                                                ))
                ->add('subject',TextType::class,array('label' => 'Asunto',
                                                      'required' => false  ))
                ->add('message',TextareaType::class,array('label' => '',
                                                          'required' => false))
                
                ->add('enviar', 'submit', array('label' => 'Enviar'))
                ->add('cancelar','submit', array('label' => 'Cancelar',
                                               'attr' => array('class' => 'btn-default buttonCancel') ));
    }

    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data_class'=>'WWW\UserBundle\Entity\Message'
                                ));
    }
        
    public function getBlockPrefix(){
        return 'message';
    }

}

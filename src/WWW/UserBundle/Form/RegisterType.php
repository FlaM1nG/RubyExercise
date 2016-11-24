<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RegistroType
 *
 * @author Rocio
 */


namespace WWW\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use WWW\GlobalBundle\Entity\ApiRest;

class RegisterType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        
        $arrayPrefix = array();
        $filePrefix = "http://www.whatwantweb.com/api_rest/global/prefix/get_prefixes";
       
        $ch = new ApiRest();
        
        $result = $ch->sendInformationWihoutParameters($filePrefix);
        
        foreach($result as $prefix):
            $arrayPrefix[$prefix['prefix']] =  $prefix['prefix'];
        endforeach;
        
        $builder
                ->add('username','text', array('label'=>'Nombre de usuario', 'required'=>false))
                ->add('email','email',array('label'=>'Email', 'required'=>false))
                ->add('birthdate','birthday', array(
                                    'label' =>'Fecha de nacimiento',
                                    'format' =>'dd-MM-yyyy',
                                    'required'=>false))
               ->add('prefix',ChoiceType::class, array('label' => 'Teléfono',
                                                        'required' => false,
                                                        'empty_value' => false,
                                                        'choices' => $arrayPrefix,
                                                        'data'=>'+34' ))
                ->add('phone','number', array('label' => ' '))
                ->add('password', 'repeated', array(
                                                'type' => 'password',
                                                'invalid_message' => 'Las dos contraseñas deben coincidir',
                                                'first_options' => array('label' => 'Contraseña'),
                                                'second_options' => array('label' => 'Repite Contraseña'),
                                                'required' => false
                                              ))
                
                ->add('guardar','submit',array('label'=>'Registrarse'));
    }
        
    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data-class'=>'WWW\UserBundle\Entity\User'));
    }
    
    public function getBlockPrefix(){
        return 'registroUsuario';
    }
}

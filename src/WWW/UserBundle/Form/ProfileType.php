<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace WWW\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use WWW\GlobalBundle\Form\PhotoType;
use WWW\GlobalBundle\Form\AdressType;
use WWW\GlobalBundle\Entity\ApiRest;

/**
 * Description of ProfileType
 *
 * @author Rocio
 */
class ProfileType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){

        $arrayPrefix = $this->getPrefixes();
        
        $builder
                ->add('username',TextType::class, array('label'=>'Usuario'))
                
                ->add('email','repeated',array('type'=>'email',
                                                'first_options' => array('label' => 'Nuevo email',
                                                                    'data' => '' ),
                                                'second_options' => array('label' => 'Repite email',
                                                                      'data' => ''),
                                                'invalid_message' => 'Los emails deben coincidir',
                                                'required'=>false,
                                                'validation_groups' => 'email'))

                ->add('passwordEnClaro', 'password', array('label' => 'Contraseña',
                                                            'required'=>false,
                                                            'validation_groups' => array('email','password')))
                
                ->add('password','repeated',array('type'=>'password',
                                                'first_options' => array('label' => 'Nueva Contraseña',
                                                                    'data' => '' ),
                                                'second_options' => array('label' => 'Repita contraseña',
                                                                      'data' => ''),
                                                'invalid_message' => 'Las contraseñas deben coincidir',
                                                'required'=>false,
                                                'validation_groups' => 'password'
                    ))
                
                ->add('name', TextType::class, array('label' => 'Nombre',
                                                     'required' => false))
                ->add('surname',TextType::class, array('label' => 'Apellidos',
                                                       'required' => false))
                ->add('sex',ChoiceType::class,array(
                                    'choices'=>array('m'=>'Mujer','h'=>'hombre'),
                                    'label'=>'Sexo',
                                    'required' => false,
                                    'empty_value' => false))
                
                ->add('birthdate',BirthdayType::class, array(
                                                            'label' =>'Fecha de nacimiento',
                                                            'format' =>'dd-MM-yyyy',
                                                            'required'=>false,
                                                            'validation_groups' => 'personalData'))
                
                ->add('nif',TextType::class,array('label' => "CIF",
                                                  'required' => false))
                
                ->add('photo',PhotoType::class)
                
                ->add('fileImage',FileType::class, array('label' =>' ',
                                                         'mapped' => false,
                                                         'attr' => array('accept'=>'image/*'),
                                                         'required' => false))
                
                ->add('numAccount',TextType::class, array('label' => 'Número de cuenta',
                                                          'required' => false))
                
//                ->add('linkInvitation',TextType::class,array('label'=>'Invitación',
//                                                    'required' => false,
//                                                    'read_only' => true))
                ->add('phone','number',array('label'=>' ',
                                         'required' => false))

                ->add('prefix',ChoiceType::class, array('label' => 'Teléfono',
                                                        'required' => false,
                                                        'empty_value' => false,
                                                        'choices' => $arrayPrefix,
                                                        ))

                ->add('codConfirmation', 'text', array('label' => 'Código de confirmación',
                                                        'mapped' => false,
                                                        'required' => false))

                ->add('confirmPhone', 'submit', array('label' => 'Confirmar',
                                                      'validation_groups' => false)) 
                ->add('addresses', CollectionType::class, array('entry_type' => AdressType::class,
                                                                'allow_add' => true,    
                                                                'by_reference' => false,
                                                            ))
                
                ->add('savePersonalData',SubmitType::class,array('label' => 'Guardar',
                                                                 'validation_groups' => 'personalData'))
                
                ->add('saveEmail',SubmitType::class,array('label' => 'Guardar',
                                                          'validation_groups' => array('email')))
                
                ->add('savePassword',SubmitType::class,array('label' => 'Guardar',
                                                             'validation_groups' => array('password')))
                
                ->add('savePhone',SubmitType::class,array('label' => 'Guardar',
                                                          'validation_groups' => false ))
                
                ->add('savePhoto',SubmitType::class,array('label' => 'Guardar',
                                                          'validation_groups' => false  ))
                
                ->add('saveBank','submit',array('label' => 'Guardar',
                                                'validation_groups' => array('bank')))
                
                ->add('deleteAddresses',SubmitType::class,array('label' => 'Borrar',
                                                                'validation_groups' => false))
                
                ->add('idDeletesAddresses',HiddenType::class, array('label' => ' ',
                                                                    'mapped' => false))
                
                ->add('addAddress',SubmitType::class,array('label' => 'Añadir',
                                                            'validation_groups' => false ));
                                                            
    }
         
    private function getPrefixes(){
        $arrayPrefix = array();
        $filePrefix = "http://www.whatwantweb.com/api_rest/global/prefix/get_prefixes.php";
       
        $ch = new ApiRest();
        
        $result = $ch->sendInformationWihoutParameters($filePrefix);

        if(!empty($result)):
            foreach($result as $prefix):
                $arrayPrefix[$prefix['prefix']] =  $prefix['prefix'];
            endforeach;
        endif;
        
        return $arrayPrefix;
    }

    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data_class'=>'WWW\UserBundle\Entity\User',
                                     'validation_groups' => array('bank','email','personalData','password')
            ));
    }
    
    public function getBlockPrefix(){
        return 'profileUser';
    }
}

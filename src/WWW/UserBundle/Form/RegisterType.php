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
use Symfony\Component\Validator\Constraints\IsTrue;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\MyConstants;

class RegisterType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        
        $arrayPrefix = $this->getPrefixes();
        
        $builder
                ->add('username','text', array('label'=>'Nombre de usuario'))
                ->add('email','repeated',array( 'type' => 'email',
                                                'first_options' => array('label' => 'Email'),
                                                'second_options' => array('label' => 'Repite email'),))
                ->add('birthdate','birthday', array(
                                    'label' =>'Fecha de nacimiento',
                                    'format' =>'dd-MM-yyyy'))
                ->add('prefix',ChoiceType::class, array('label' => 'Teléfono',
                                                        'empty_value' => false,
                                                        'choices' => $arrayPrefix,
                                                        'data'=>'+34' ))
                ->add('phone','number', array('label' => ' '))
                ->add('password', 'repeated', array(
                                                'type' => 'password',
                                                'invalid_message' => 'Las dos contraseñas deben coincidir',
                                                'first_options' => array('label' => 'Contraseña'),
                                                'second_options' => array('label' => 'Repite Contraseña'),
                                              ))
                ->add('isEnterprise','checkbox',array('label' => "Soy una empresa",
                                                      'mapped' => false,
                                                      'required' => false))
                ->add('nif','text',array('label' => 'CIF',
                                         'required' => false,
                                         'attr' => array('style' => 'display:none',
                                                         'class' => 'registroUsuario_nif'),
                                         'label_attr' => array('style' => 'display:none',
                                                               'class' => 'registroUsuario_nif' )))
                ->add('captcha', 'captcha', array( 'as_url' => true, 
                                                   'reload' => true,
                                                   'label' => " "))
                ->add('acepto', 'checkbox', array('label' => ' ',
                                                  'mapped' => false,
                                                  'constraints' => new IsTrue(array(
                                                                   'message' => 'Debes aceptar las condiciones legales 
                                                                    antes de añadir una oferta',
                                                                   'groups' => 'register'))
                                                ))
                
                ->add('guardar','submit',array('label'=>'Registrarse'));
    }
        
    private function getPrefixes(){
        
        $arrayPrefix = array();
        $filePrefix = MyConstants::PATH_APIREST."global/prefix/get_prefixes.php";
       
        $ch = new ApiRest();
        
        $result = $ch->sendInformationWihoutParameters($filePrefix);
        
        foreach($result as $prefix):
            $arrayPrefix[$prefix['prefix']] =  $prefix['prefix'];
        endforeach;
        
        return $arrayPrefix;
    }
    
    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data_class'=>'WWW\UserBundle\Entity\User',
                                     'validation_groups' => array('register')
            ));
    }
    
    public function getBlockPrefix(){
        return 'registroUsuario';
    }
}

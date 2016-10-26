<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace WWW\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Util\LegacyFormHelper;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class ProfileFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //$this->buildUserForm($builder, $options);

        $builder->add('plainPassword', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\RepeatedType'), 
                array(
                    'type' => LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'),
                    'options' => array('translation_domain' => 'FOSUserBundle'),
                    'first_options' => array('label' => 'Nueva contraseña'),
                    'second_options' => array('label' => 'Repita la contraseña'),
                    'required'=>false
                    )
                );
        
        $builder->add('nombre','text',array(
                                      'label'=>'Nombre',
                                      'required'=>false
        ));
        
        $builder->add('apellidos','text',array(
                                      'label'=>'Apellidos',
                                      'required'=>false
        ));
        
        $builder->add('email','email',array(
                                      'label'=>'Email',
                                      'required'=>true,
        ));
        
        $builder->add('username','text',array(
                                      'label'=>'Nombre de usuario',
                                      'required'=>true,
        ));
        
        $builder->add('fecha_nacimiento','birthday',array(
                                      'label'=>'Fecha de nacimiento',
                                      'required'=>false
        ));
        
        $builder->add('link_invitacion','text',array(
                                      'label'=>'Invitación'
        ));
        
        $builder->add('sexo','choice',array(
                                      'label'=>'Sexo',
                                      'choices'   => array('h' => 'Hombre', 'm' => 'Mujer'),
        ));
        
        $builder->add('tlfn','number',array(
                                      'label'=>'Teléfono',
                                      'required'=>false,
        ));
    }

    public function getName()
    {
        return 'www_user_profile';
    }
}
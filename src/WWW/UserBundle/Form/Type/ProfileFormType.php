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

        $builder->add('current_password', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'), array(
            'label' => 'Contraseña',
            'mapped' => false,
            'constraints' => new UserPassword(!empty($options['validation_groups']) ? array('groups' => array(reset($options['validation_groups']))) : null),
        ));
        
        $builder->add('nombre','text',array(
                                      'label'=>'Nombre',
                                      'required'=>true,
        ));
        
        $builder->add('apellidos','email',array(
                                      'label'=>'Apellidos',
                                      'required'=>true,
        ));
        
        $builder->add('email','email',array(
                                      'label'=>'Email',
                                      'required'=>true,
        ));
        
        $builder->add('username','text',array(
                                      'label'=>'Nombre de usuario',
                                      'required'=>true,
        ));
        
        $builder->add('fecha_nacimiento','text',array(
                                      'label'=>'Fecha de nacimiento',
                                      'required'=>true,
        ));
        
        $builder->add('link_invitacion','email',array(
                                      'label'=>'Invitación',
                                      'required'=>true,
        ));
        
        $builder->add('sexo','email',array(
                                      'label'=>'Sexo',
                                      'required'=>true,
        ));
    }

    public function getName()
    {
        return 'www_user_profile';
    }
}
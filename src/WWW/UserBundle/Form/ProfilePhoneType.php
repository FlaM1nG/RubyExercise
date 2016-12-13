<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProfileType
 *
 * @author Rocio
 */

namespace WWW\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use WWW\GlobalBundle\Entity\ApiRest;
      
class ProfilePhoneType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        
        $arrayPrefix = array();
        $filePrefix = "http://www.whatwantweb.com/api_rest/global/prefix/get_prefixes.php";
       
        $ch = new ApiRest();
        
        $result = $ch->sendInformationWihoutParameters($filePrefix);

        if(!empty($result)):
            foreach($result as $prefix):
                $arrayPrefix[$prefix['prefix']] =  $prefix['prefix'];
            endforeach;
        endif;    
        
        $builder
               
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

            ->add('confirmPhone', 'submit', array('label' => 'Confirmar'))
                
            ->add('section','hidden' ,array('data'=>'phone',
                                            'mapped' => false))    

            ->add('savePhone','submit',array('label'=>'Guardar'));
    }
    
    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data-class'=>'WWW\UserBundle\Entity\User'));
    }

    public function getBlockPrefix(){
        return 'profileUser';
    }

}
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace WWW\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\MyConstants;

/**
 * Description of ProfilePhoneType
 *
 * @author Rocio
 */
class ProfilePhoneType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){

        $arrayPrefix = $this->getPrefixes();
        $disabled = false;

        if($options['sendSMS'] != null) $disabled = true;
        
        $builder
                ->add('prefix',ChoiceType::class, array('label' => 'Teléfono',
                                                        'required' => false,
                                                        'empty_value' => false,
                                                        'choices' => $arrayPrefix,'preferred_choices'=>array('+34')
                                                        ))
                
                ->add('phone',NumberType::class,array('label'=>' ',
                                             'required' => false))
                
                ->add('savePhone',SubmitType::class,array('label' => 'Guardar',
                                                          'disabled' => $disabled,
                                                          'validation_groups' => false ));

    }
         
    private function getPrefixes(){
        $arrayPrefix = array();
        $filePrefix = MyConstants::PATH_APIREST."global/prefix/get_prefixes.php";
       
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
                                     'validation_groups' => false,
                                     'sendSMS' => false)
            );
    }
    
    public function getBlockPrefix(){
        return 'profileNewCodePhone';
    }
}

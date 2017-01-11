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
        
        $builder
                ->add('prefix',ChoiceType::class, array('label' => 'Teléfono',
                                                        'required' => false,
                                                        'empty_value' => false,
                                                        'choices' => $arrayPrefix,
                                                        ))
                
                ->add('phone','number',array('label'=>' ',
                                             'required' => false))
                
                ->add('codConfirmation', 'text', array('label' => 'Código de confirmación',
                                                        'mapped' => false,
                                                        'required' => false))

                ->add('confirmPhone', 'submit', array('label' => 'Confirmar',
                                                      'validation_groups' => false)) 
                
                ->add('savePhone',SubmitType::class,array('label' => 'Guardar',
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
        
        $resolver->setDefaults(array('data_class'=>'WWW\UserBundle\Entity\User')
            );
    }
    
    public function getBlockPrefix(){
        return 'profilePhone';
    }
}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace WWW\GlobalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\MyConstants;

/**
 * Description of AdressType
 *
 * @author Rocio
 */
class AdressType extends AbstractType{
    
    private $arrayPrefix;
    private $arrayCountry;
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        
        $this->arrayPrefixCountry();
        
        $builder
                
                ->add('name','text', array('label'=>'Nombre dirección',
                                           'validation_groups' => array('address') ))
                
                ->add('isDefault','checkbox', array('label' => 'Dirección principal',
                                                    'required' => false
                                                    ))
                
                ->add('country', ChoiceType::class, array('label' => 'Pais',
                                                        'required' => false,
                                                        'empty_value' => false,
                                                        'choices' => $this->arrayCountry,
                                                        'preferred_choices' => array('Spain')
                                                        ))
                
                ->add('region','text', array('label' => 'Región',
                                             'validation_groups' => array('address') ))
                
                ->add('city','text', array('label'=>'Ciudad',
                                           'validation_groups' => array('address')))
                
                ->add('street','text', array('label'=>'Dirección',
                                             'validation_groups' => array('address')))
                
                ->add('zipCode','text', array('label'=>'CP',
                                              'attr' => array('class' => 'zipCode'),
                                              'validation_groups' => array('address')))
                
                ->add('prefix',ChoiceType::class, array('label' => 'Teléfono',
                                                        'required' => false,
                                                        'empty_value' => false,
                                                        'choices' => $this->arrayPrefix,
                                                        'preferred_choices' => array('+34')
                                                        ))
                
                ->add('phone','number',array('label'=>' ',
                                             'required' => false))
                     
                ->add('id','hidden', array('label' => ' '))
                ->add('editAddress','submit',array('label' => 'Guardar',
                                                   'validation_groups' => false,
                                                    'attr' => array('class' => 'editAddressButton')));
    }
    
    private function arrayPrefixCountry(){
        
        $filePrefix = MyConstants::PATH_APIREST."global/prefix/get_prefixes.php";
       
        $ch = new ApiRest();
        
        $result = $ch->sendInformationWihoutParameters($filePrefix);

        if(!empty($result)):
            foreach($result as $prefix):
                $this->arrayPrefix[$prefix['prefix']] =  $prefix['prefix'];
                $this->arrayCountry[$prefix['country']] = $prefix['country'];
            endforeach;
        endif;
    }
    
    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data_class'=>'WWW\GlobalBundle\Entity\Address',
                                     'validation_groups' => array('address')));
    }
    
    public function getBlockPrefix(){
        return 'adressUser';
    }

}
 
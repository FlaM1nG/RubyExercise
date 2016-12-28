<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace WWW\OthersBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use WWW\UserBundle\Entity\User;

/**
 * Description of TradeType
 *
 * @author Rocio
 */
class UserTradeType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options){
       
        $builder
            ->add('trades',CollectionType::class, array('entry_type' => TradeType::class,  
                                                       ))    
                                                                  
            ->add('editar','submit',array('label'=>'Editar'));
            
        
    }

    
    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data-class'=>User::class));
    }

}

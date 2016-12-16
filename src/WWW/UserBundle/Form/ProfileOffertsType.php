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
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use WWW\OthersBundle\Form\TradeType;
use WWW\UserBundle\Entity\User;


/**
 * Description of ProfileOffertsType
 *
 * @author Rocio
 */
class ProfileOffertsType extends AbstractType{   
    
    public function buildForm(FormBuilderInterface $builder, array $options){
        
        $builder
                
                ->add('trades',CollectionType::class, array('entry_type' => TradeType::class,
                                                            ))
                ->add('idsDeleteOffers',HiddenType::class, array('mapped' => false))
                ->add('deleteOffers', 'submit', array('label' => 'Eliminar ofertas'));  
    }
    
    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data_class' => User::class));
    }



    
}
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace WWW\ServiceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Description of CommentType
 *
 * @author Rocio
 */
class CommentType extends AbstractType{
    

    
    public function buildForm(FormBuilderInterface $builder, array $options){

        $builder
                
//                ->add('user',UserType::class, array('label' => 'Usuario'))
                ->add('comment',TextareaType::class, array('label' =>'Comentario'))
//                ->add('id',HiddenType::class)
                ->add('newComment',SubmitType::class, array('label'=>'Nuevo' ));
                
    }
    
    public function configureOptions(OptionsResolver $resolver){
        
        $resolver->setDefaults(array('data_class' => 'WWW\ServiceBundle\Entity\Comment'));
    }



    
}

<?php
/**
 * Created by PhpStorm.
 * User: Rocio
 * Date: 07/02/2017
 * Time: 9:07
 */

namespace Acme\PaymentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WWW\GlobalBundle\Entity\Address;


class PagoType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $listDir = $options['data']->getAddresses();
        $defaultDir = $options['data']->getDefaultAddress();
        $arrayAddress= [] ;
        array_unshift($arrayAddress,$defaultDir);
        
        if($listDir[0]!= null):
            foreach($listDir[0] as $value):
                array_push($arrayAddress,$value);
            endforeach;
        endif;

         
        
        $builder

            ->add('addressPay', ChoiceType::class, array(
                'data_class' => 'WWW\GlobalBundle\Entity\Address',
                'label' => 'Dirección envio',
                'choices' => $arrayAddress,
                'choice_value' => 'id',
                'choice_label' => 'name',
                'choices_as_values' => true,
//                'data' => $options['data']->getAddressPay() // OBTENER DIRECCION
            ))
            
            ->add('newAddress', SubmitType::class, array(
                'attr' => array('class' => 'btn btn-default btn-normal'),
                'label' => 'NUEVA DIRECCIÓN',
                
            ))    
                
            ->add('facture', CheckboxType::class, array(
                'attr' => array('class' => 'check-facturacion'),
                'label' => 'Marque la casilla si desea factura.',
                'mapped' => false,
                'required' => false
            ))

            ->add('dirFac', ChoiceType::class, array(
                'label' => 'Dirección facturación',
                'choices' => $arrayAddress,
                'choice_value' => 'id',
                'choice_label' => 'name',
                'choices_as_values' => true,
                'mapped' =>false
//                'data' => $options['data']->getCar() // OBTENER DIRECCION
            ))
            ->add('dni', TextType::class, array(
                'label' => 'DNI',
                'mapped' =>false,
                'required' => false
            ))
            ->add('paypal', CheckboxType::class, array(
                'attr' => array('class' => 'check-payment-method center-block'),
                'label' => ' ',
                'mapped' =>false,
                'required' => false
            ))

            ->add('card', CheckboxType::class, array(
                'attr' => array('class' => 'check-payment-method center-block'),
                'label' => ' ',
                'mapped' =>false,
                'required' => false
            ))

            ->add('correos', CheckboxType::class, array(
                'attr' => array('class' => 'check-send-method center-block'),
                'label' => ' ',
                'mapped' =>false,
                'required' => false
            ))

//            ->add('dhl', CheckboxType::class, array(
//                'attr' => array('class' => 'check-send-method center-block'),
//                'label' => ' ',
//                'mapped' =>false,
//                'required' => false
//            ))

            ->add('otros', CheckboxType::class, array(
                'attr' => array('class' => 'check-send-method center-block'),
                'label' => ' ',
                'mapped' =>false,
                'required' => false
            ))

            ->add('submit', SubmitType::class, array(
                'attr' => array('class' => 'btn btn-default btn-float-none'),
                'label' => 'Pagar',
                
            ));

    }

    public function configureOptions(OptionsResolver $resolver){

       $resolver->setDefaults(array(
           'data_class'=> 'WWW\UserBundle\Entity\User',
           'validation_groups' => false
           ));
    }

    public function getBlockPrefix(){
        return 'previoPago';
    }
}
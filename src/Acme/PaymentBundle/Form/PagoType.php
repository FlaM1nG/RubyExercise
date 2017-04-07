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
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WWW\GlobalBundle\Entity\Address;


class PagoType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $amount= $options['amount'];
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

            ->add('payMethod', ChoiceType::class, array('choices' => array('paypal' =>' ', 'card' => ' '),
                                                        'expanded' => true,
                                                        'multiple' => false,
                                                        'mapped' => false))

            ->add('sendMethod', ChoiceType::class, array('choices' => array('correos' => ' ', 'otros' =>' '),
                                                         'expanded' => true,
                                                         'multiple' => false,
                                                         'mapped' => false))

            ->add('totalAmount', HiddenType::class, array(  'attr' => array('class' => 'check-send-method center-block'),
                                                            'data' => $amount,
                                                            'mapped' =>false,
                                                        ))
            ->add('shippingCost', HiddenType::class, array( 'attr' => array('class' => 'shippingCost'),
                                                            'mapped' => false,
                                                            'data' => 0))

            ->add('managementPayFee', HiddenType::class, array('attr' => array('class' => 'managementPayFee'),
                                                               'mapped' => false,
                                                               'data' => 0))
            
            ->add('submit', SubmitType::class, array(
                                                    'attr' => array('class' => 'btn btn-default btn-float-none'),
                                                    'label' => 'Pagar',
                
            ));

    }

    public function configureOptions(OptionsResolver $resolver){

       $resolver->setDefaults(array(
           'data_class'=> 'WWW\UserBundle\Entity\User',
           'validation_groups' => false,
           'amount' => null,
           ));
    }

    public function getBlockPrefix(){
        return 'previoPago';
    }
}
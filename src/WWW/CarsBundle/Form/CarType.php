<?php
/**
 * Created by PhpStorm.
 * User: Rocio
 * Date: 01/02/2017
 * Time: 12:19
 */

namespace WWW\CarsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WWW\CarsBundle\Entity\ColorCar;
use WWW\CarsBundle\Entity\Model;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\MyConstants;



class CarType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){

        $arrayBrand = $arrayModel = $arrayColor = $arrayType = array();

        $this->getDataCar($arrayBrand,$arrayModel, $arrayColor, $arrayType);

        $builder
            ->add('plate', TextType::class, array('label' => 'Matrícula'))
            ->add('color', ChoiceType::class, array('label' => 'Color',
                                                    'choices' => $arrayColor,
                                                    'choice_value' => 'color',
                                                    'choice_label' => 'color',
                                                    'choices_as_values' => true,))

            ->add('description', TextareaType::class, array('label' => 'Descripción',
                                                            'required' => false ))

            ->add('seats', IntegerType::class,array('label'=>'Número de plazas',
                                                    'attr' => array('min' => 2)))

            ->add('model', ChoiceType::class, array('label' => 'Modelo',
                                                    'choices' => $arrayModel,
                                                    'choice_value' => 'id',
                                                    'choice_label' => 'name',
                                                    'choices_as_values' => true,
                                                ))
            ->add('type', ChoiceType::class, array('label' => 'Tipo de coche',
                                                    'choices' => $arrayType,
                                                ))
            ->add('smoke', CheckboxType::class, array('label' => 'Se permite fumar',
                                                      'required' => false))
            ->add('animals', CheckboxType::class, array('label' => 'Se permiten animales',
                                                        'required' => false ))
            ->add('music', CheckboxType::class, array('label' => 'Me gusta escuchar música',
                                                      'required' => false  ))
            ->add('talk', CheckboxType::class, array('label' => 'Me gusta hablar',
                                                     'required' => false))
            ->add('imgCar', FileType::class, array( 'label' => 'Imágenes',
                                                    'mapped' => false,
                                                    'multiple' => true,
                                                    'required' => true,
                                                    'attr' => array('accept' => 'image/*', 'class' => 'file-loading')))

            ->add('saveNewCar', SubmitType::class, array('label' => 'Guardar'));

        if(!empty($options['data']->getModel())):

            $builder
                 ->add('brand', ChoiceType::class, array('label' => 'Marca',
                                                        'required' => false,
                                                        'empty_value' => false,
                                                        'choices' => $arrayBrand,
                                                        'mapped' => false,
                                                        'data' => $options['data']->getModel()->getBrand()->getId()
                                                         ));
        else:

            $builder
                ->add('brand', ChoiceType::class, array('label' => 'Marca',
                                                        'required' => false,
                                                        'empty_value' => false,
                                                        'choices' => $arrayBrand,
                                                        'mapped' => false,
                ));
        endif;
            
    }

    public function configureOptions(OptionsResolver $resolver){

        $resolver->setDefaults(array('data_class'=>'WWW\CarsBundle\Entity\Car',
                                     'validation_groups' => array('newCar')));
    }

    public function getBlockPrefix(){
        return 'newCar';
    }

    private function getDataCar(&$arrayBrand, &$arrayModel, &$arrayColor, &$arrayType){

        $file = MyConstants::PATH_APIREST.'user/car/get_cars_data.php';
        $ch = new ApiRest();
        $data = null;
        $result = $ch->resultApiRed($data,$file);

        foreach($result['brands'] as $brand):

            $arrayBrand[$brand['id']] = $brand['name'];
            $arrayModel[$brand['name']] = array();

            foreach($brand['models'] as $key => $value):
                $arrayModel[$brand['name']][$value['id']] = new Model($value['id'],$value['name'],$brand['id'], $brand['name']);
            endforeach;
        endforeach;


        foreach($result['types'] as $key => $value):
            $arrayType[$value] = $value;
        endforeach;

        foreach($result['colors'] as $key => $value):

            $arrayColor[] = new ColorCar($value);
        endforeach;



    }


}
<?php

/**
 * Created by PhpStorm.
 * User: Rocio
 * Date: 01/03/2017
 * Time: 9:29
 */

namespace WWW\HouseBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use WWW\GlobalBundle\Form\AddressType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class HouseType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){

        $builder
            ->add('address', AddressType::class, array('label' => '', 'validation_groups' => 'house'))

            ->add('licenseNumber', TextType::class, array('label' => 'Número de licencia', 'required' => false))

            ->add('title', TextType::class, array('label' => 'Título'))

            ->add('description', TextareaType::class, array('label' => 'Descripción'))

            ->add('capacity', IntegerType::class, array('label' => 'Capacidad',
                                                        'attr' => array('min' => 1)))

            ->add('beds', IntegerType::class, array('label' => 'Camas',
                                                    'attr' => array('min' => 0)))

            ->add('bedrooms', IntegerType::class, array('label' => 'Habitaciones',
                                                        'attr' => array('min' => 0)))

            ->add('bathrooms', IntegerType::class, array('label' => 'Cuartos de baño',
                                                         'attr' => array('min' => 1)))

            ->add('aireAcondicionado', CheckboxType::class, array('label' => 'Aire acondicionado', 'required' => false))

            ->add('calefaccion', CheckboxType::class, array('label' => 'Calefacción', 'required' => false))

            ->add('ascensor', CheckboxType::class, array('label' => 'Ascensor', 'required' => false))
            
            ->add('portero', CheckboxType::class, array('label' => 'Portero', 'required' => false))
            
            ->add('timbre', CheckboxType::class, array('label' => 'Timbre', 'required' => false))
            
            ->add('apartamentoEdificio', CheckboxType::class, array('label' => 'Apartamento privado en edificio', 'required' => false))
            
            ->add('accesoDiscapacitados', CheckboxType::class, array('label' => 'Acceso para discapacitados', 'required' => false))
            
            ->add('piscina', CheckboxType::class, array('label' => 'Piscina', 'required' => false))
            
            ->add('gimnasio', CheckboxType::class, array('label' => 'Gimnasio', 'required' => false))
            
            ->add('papelHigienico', CheckboxType::class, array('label' => 'Papel higiénico', 'required' => false))
            
            ->add('bidet', CheckboxType::class, array('label' => 'Bidé', 'required' => false))
            
            ->add('banera', CheckboxType::class, array('label' => 'Bañera', 'required' => false))
            
            ->add('secadorPelo', CheckboxType::class, array('label' => 'Secador de pelo', 'required' => false))
            
            ->add('jacuzzi', CheckboxType::class, array('label' => 'Jacuzzi', 'required' => false))
            
            ->add('champu', CheckboxType::class, array('label' => 'Champú y gel', 'required' => false))
            
            ->add('mesaComedor', CheckboxType::class, array('label' => 'Mesa de comedor', 'required' => false))
            
            ->add('cafetera', CheckboxType::class, array('label' => 'Cafetera', 'required' => false))
            
            ->add('productosLimpieza', CheckboxType::class, array('label' => 'Productos de limpieza', 'required' => false))
            
            ->add('fogones', CheckboxType::class, array('label' => 'Fogones', 'required' => false))
            
            ->add('horno', CheckboxType::class, array('label' => 'Horno', 'required' => false))
            
            ->add('utensiliosCocina', CheckboxType::class, array('label' => 'Utensilios de cocina', 'required' => false))
            
            ->add('lavadora', CheckboxType::class, array('label' => 'Lavadora', 'required' => false))
            
            ->add('microondas', CheckboxType::class, array('label' => 'Microondas', 'required' => false))
            
            ->add('nevera', CheckboxType::class, array('label' => 'Nevera', 'required' => false))
            
            ->add('secadora', CheckboxType::class, array('label' => 'Secadora', 'required' => false))
            
            ->add('desayuno', CheckboxType::class, array('label' => 'Desayuno', 'required' => false))
            
            ->add('armario', CheckboxType::class, array('label' => 'Armario', 'required' => false))
            
            ->add('sabanas', CheckboxType::class, array('label' => 'Sábanas', 'required' => false))
            
            ->add('sofaCama', CheckboxType::class, array('label' => 'Sofá cama', 'required' => false))
            
            ->add('tendedero', CheckboxType::class, array('label' => 'Tendedero', 'required' => false))
            
            ->add('perchero', CheckboxType::class, array('label' => 'Perchero', 'required' => false))
            
            ->add('perchas', CheckboxType::class, array('label' => 'Perchas', 'required' => false))
            
            ->add('sueloBaldosa', CheckboxType::class, array('label' => 'Suelo de baldosa/marmol', 'required' => false))
            
            ->add('insonorizacion', CheckboxType::class, array('label' => 'Insonorización', 'required' => false))
            
            ->add('entradaPrivada', CheckboxType::class, array('label' => 'Entrada privada', 'required' => false))
            
            ->add('ventilador', CheckboxType::class, array('label' => 'Ventilador', 'required' => false))
            
            ->add('plancha', CheckboxType::class, array('label' => 'Plancha', 'required' => false))
            
            ->add('vistasCiudad', CheckboxType::class, array('label' => 'Vistas de la ciudad', 'required' => false))
            
            ->add('vistasInteres', CheckboxType::class, array('label' => 'Vistas de interés', 'required' => false))
            
            ->add('comedor', CheckboxType::class, array('label' => 'Comedor', 'required' => false))
            
            ->add('sofa', CheckboxType::class, array('label' => 'Sofá', 'required' => false))
            
            ->add('zonaEstar', CheckboxType::class, array('label' => 'Zona de estar', 'required' => false))
            
            ->add('escritorio', CheckboxType::class, array('label' => 'Escritorio', 'required' => false))
            
            ->add('chimenea', CheckboxType::class, array('label' => 'Chimenea', 'required' => false))
            
            ->add('zonaPortatiles', CheckboxType::class, array('label' => 'Zona para portátiles', 'required' => false))
            
            ->add('tv', CheckboxType::class, array('label' => 'Televisión', 'required' => false))
            
            ->add('tvPlana', CheckboxType::class, array('label' => 'Televisión plana', 'required' => false))
            
            ->add('tvSatelite', CheckboxType::class, array('label' => 'Televisión por satélite', 'required' => false))
            
            ->add('wifi', CheckboxType::class, array('label' => 'Wifi', 'required' => false))
            
            ->add('parkingPublico', CheckboxType::class, array('label' => 'Parking público', 'required' => false))
            
            ->add('parkingGratuito', CheckboxType::class, array('label' => 'Parking gratuito', 'required' => false))
            
            ->add('libros', CheckboxType::class, array('label' => 'Libros', 'required' => false))
            
            ->add('puzzles', CheckboxType::class, array('label' => 'Juegos de mesa', 'required' => false))
            
            ->add('eventos', CheckboxType::class, array('label' => 'Eventos', 'required' => false))
            
            ->add('dvd', CheckboxType::class, array('label' => 'DVD', 'required' => false))
            
            ->add('fiestas', CheckboxType::class, array('label' => 'Fiestas', 'required' => false))
            
            ->add('fumar', CheckboxType::class, array('label' => 'Se permite fumar', 'required' => false))
            
            ->add('mascotas', CheckboxType::class, array('label' => 'Se permiten mascotas', 'required' => false))
            
            ->add('botiquin', CheckboxType::class, array('label' => 'Botiquín', 'required' => false))
            
            ->add('detectorHumo', CheckboxType::class, array('label' => 'Detector de humos', 'required' => false))
            
            ->add('detectorCO', CheckboxType::class, array('label' => 'Detector de CO2', 'required' => false))
            
            ->add('extintor', CheckboxType::class, array('label' => 'Extintor', 'required' => false))
            
            ->add('fichaInstrucciones', CheckboxType::class, array('label' => 'Ficha de instrucciones', 'required' => false))
            
            ->add('protectorEnchufes', CheckboxType::class, array('label' => 'Protectores de enchufes', 'required' => false))

            ->add('pestillo', CheckboxType::class, array('label' => 'Pestillo en la habitación', 'required' => false))

            ->add('imgHouse', FileType::class, array('label' => 'Imágenes',
                                               'multiple' => true,
                                               'required' => false,
                                               'mapped' => false,
                                               'attr' => array('accept' => 'image/*', 'class' => 'file-loading',)))
            ->add('saveNewHouse', SubmitType::class, array('label' => 'Guardar'));


    }

    public function configureOptions(OptionsResolver $resolver){

        $resolver->setDefaults(array('data_class' => 'WWW\HouseBundle\Entity\House','validation_groups' => 'house'));
    }

    public function getBlockPrefix(){
        return 'house';
    }
}
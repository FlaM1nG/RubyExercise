<?php
/**
 * Created by PhpStorm.
 * User: Rocio
 * Date: 03/04/2017
 * Time: 15:19
 */

namespace WWW\HouseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WWW\GlobalBundle\MyConstants;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\Entity\Region;
use WWW\ServiceBundle\Form\OfferType;

class ShareRoomType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options){

        $arrayRegion = $this->arrayRregion();

        $builder
            
            ->add('offer', OfferType::class, array('label' => ''))

            ->add('saveOffer', SubmitType::class, array('label' => 'Guardar'))

            ->add('city', TextType::class, array('label' => 'Localidad'))

            ->add('country', ChoiceType::class, array('label' => 'Provincia',
                                                     'choices_as_values' => true,
                                                     'choices' => $arrayRegion,
                                                     'choice_value' => 'countryRegion',
                                                     'choice_label' => 'region',
                                                     'empty_value' => false,
                                                     'group_by' => 'country'))

            ->add('imgBedroom', FileType::class, array( 'label' => ' ',
                                                        'mapped' => false,
                                                        'multiple' => true,
                                                        'required' => false,
                                                        'attr' => array('accept' => 'image/*', 'class' => 'file-loading')));
    }

    public function configureOptions(OptionsResolver $resolver){

        $resolver->setDefaults(array('data_class' => 'WWW\HouseBundle\Entity\ShareRoom'));
    }

    private function arrayRregion(){

        $file = MyConstants::PATH_APIREST.'global/prefix/get_regions.php';
        $ch = new ApiRest();
        $arrayRegion = null;
        $arrayCountry = null;

        $result = $ch->resultApiRed(null,$file);

        if(!empty($result)):
            foreach($result as $value):
                $arrayRegion[] = new Region($value['id'], $value['region'], $value['country']);

            endforeach;
        endif;

        return $arrayRegion;
    }

    public function getBlockPrefix(){
        return 'shareRoom';
    }

}
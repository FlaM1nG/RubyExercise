<?php

namespace WWW\CarsBundle\Entity;

use WWW\ServiceBundle\Entity\Offer;
use WWW\CarsBundle\Entity\Car;
use WWW\GlobalBundle\Entity\Photo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ShareCar
 */
class ShareCar
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $fromPlace;

    /**
     * @var string
     */
    private $toPlace;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var int
     */
    private $price;

    /**
     * @var \WWW\CarsBundle\Entity\Car
     */
    private $car;

    /**
     * @var boolean
     */
    private $backTwo;

    /**
     * @var boolean
     */
    private $autobooking;

    /**
     * @var \WWW\ServiceBundle\Entity\Offer
     */
    private $offer;

    public function __construct($array = null) {

        if($array != null): 
            $this->id = $array['id'];
            $this->fromPlace = $array['from_place'];
            $this->toPlace = $array['to_place'];
            $this->date = \DateTime::createFromFormat('Y-m-d H:i:s', $array['date']);
            $this->price = $array['price'];
            $this->backTwo = (bool)$array['back_two'];
            $this->autobooking = $array['autobooking'];
            $this->offer = new Offer($array);

            $this->createCar($array);
        else:
            $this->offer = new Offer();
        endif;
    }

    private function createCar($array){

        if(!empty($array['car'])):
            $this->car = new Car($array['car']);

        elseif(array_key_exists('car_photo', $array)):
            $this->car = $this->setPhotoCar($array);

        elseif(array_key_exists('car_id', $array)):
            $this->car = new Car();
            $this->car->setId($array['car_id']);

        endif;

    }

    private function setPhotoCar($array){

        $car = new Car();
        $photo = new Photo();
        $photo->setUrl($array['car_photo']);

        if(array_key_exists('car_photo_id', $array)):
            $photo->setId($array['car_photo_id']);
        endif;

        $car->addPhoto($photo);
        
        return $car;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    /**
     * Set fromPlace
     *
     * @param string $fromPlace
     *
     * @return ShareCar
     */
    public function setFromPlace($fromPlace)
    {
        $this->fromPlace = $fromPlace;

        return $this;
    }

    /**
     * Get fromPlace
     *
     * @return string
     */
    public function getFromPlace()
    {
        return $this->fromPlace;
    }

    /**
     * Set toPlace
     *
     * @param string $toPlace
     *
     * @return ShareCar
     */
    public function setToPlace($toPlace)
    {
        $this->toPlace = $toPlace;

        return $this;
    }

    /**
     * Get toPlace
     *
     * @return string
     */
    public function getToPlace()
    {
        return $this->toPlace;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return ShareCar
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return ShareCar
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set car
     *
     * @param \WWW\CarsBundle\Entity\Car $car
     *
     * @return ShareCar
     */
    public function setCar(\WWW\CarsBundle\Entity\Car $car = null)
    {
        $this->car = $car;

        return $this;
    }

    /**
     * Get car
     *
     * @return \WWW\CarsBundle\Entity\Car
     */
    public function getCar()
    {
        return $this->car;
    }

    /**
     * Set backTwo
     *
     * @param boolean $backTwo
     *
     * @return ShareCar
     */
    public function setBackTwo($backTwo)
    {
        $this->backTwo = $backTwo;

        return $this;
    }

    /**
     * Get backTwo
     *
     * @return boolean
     */
    public function getBackTwo()
    {
        return $this->backTwo;
    }

    /**
     * Set autobooking
     *
     * @param boolean $autobooking
     *
     * @return ShareCar
     */
    public function setAutobooking($autobooking)
    {
        $this->autobooking = $autobooking;

        return $this;
    }

    /**
     * Get autobooking
     *
     * @return boolean
     */
    public function getAutobooking()
    {
        return $this->autobooking;
    }

    /**
     * Set offer
     *
     * @param \WWW\ServiceBundle\Entity\Offer $offer
     *
     * @return ShareCar
     */
    public function setOffer(\WWW\ServiceBundle\Entity\Offer $offer = null)
    {
        $this->offer = $offer;

        return $this;
    }

    /**
     * Get offer
     *
     * @return \WWW\ServiceBundle\Entity\Offer
     */
    public function getOffer()
    {
        return $this->offer;
    }

    /**
     * Validación para que los usuarios sean mayores de 18
     *
     * @Assert\True(message = "Fecha no válida")
     */
    public function isDateValid(){

        return $this->date > new\DateTime('now');
    }
}

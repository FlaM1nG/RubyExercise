<?php

namespace WWW\HouseBundle\Entity;

use Doctrine\Common\Util\Inflector as Inflector;
use WWW\GlobalBundle\Entity\Address;
use WWW\GlobalBundle\Entity\Photo;

/**
 * House
 */
class House
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \WWW\GlobalBundle\Entity\Address
     */
    private $address;

    /**
     * @var \WWW\UserBundle\Entity\User
     */
    private $user;

    /**
     * @var \WWW\GlobalBundle\Entity\Calendar
     */
    private $calendar;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $photos;

    /**
     * @var \DateTime
     */
    private $createdDate;

    /**
     * @var \DateTime
     */
    private $modifiedDate;

    /**
     * @var \DateTime
     */
    private $deletedDate;

    /**
     * @var boolean
     */
    private $isDeleted;

    /**
     * @var string
     */
    private $licenseNumber;

    /**
     * @var integer
     */
    private $capacity;

    /**
     * @var integer
     */
    private $bathrooms;

    /**
     * @var string
     */
    private $bedrooms;

    /**
     * @var integer
     */
    private $beds;

    /**
     * @var boolean
     */
    private $aireAcondicionado;

    /**
     * @var boolean
     */
    private $calefaccion;

    /**
     * @var boolean
     */
    private $ascensor;

    /**
     * @var boolean
     */
    private $portero;

    /**
     * @var boolean
     */
    private $timbre;

    /**
     * @var boolean
     */
    private $apartamentoEdificio;

    /**
     * @var boolean
     */
    private $accesoDiscapacitados;

    /**
     * @var boolean
     */
    private $piscina;

    /**
     * @var boolean
     */
    private $gimnasio;

    /**
     * @var boolean
     */
    private $fogones;

    /**
     * @var boolean
     */
    private $papelHigienico;

    /**
     * @var boolean
     */
    private $bidet;

    /**
     * @var boolean
     */
    private $banera;

    /**
     * @var boolean
     */
    private $secadorPelo;

    /**
     * @var boolean
     */
    private $jacuzzi;

    /**
     * @var boolean
     */
    private $champu;

    /**
     * @var boolean
     */
    private $mesaComedor;

    /**
     * @var boolean
     */
    private $cafetera;

    /**
     * @var boolean
     */
    private $productosLimpieza;

    /**
     * @var boolean
     */
    private $horno;

    /**
     * @var boolean
     */
    private $utensiliosCocina;

    /**
     * @var boolean
     */
    private $lavadora;

    /**
     * @var boolean
     */
    private $microondas;

    /**
     * @var boolean
     */
    private $nevera;

    /**
     * @var boolean
     */
    private $secadora;

    /**
     * @var boolean
     */
    private $desayuno;

    /**
     * @var boolean
     */
    private $armario;

    /**
     * @var boolean
     */
    private $sabanas;

    /**
     * @var boolean
     */
    private $sofaCama;

    /**
     * @var boolean
     */
    private $tendedero;

    /**
     * @var boolean
     */
    private $perchero;

    /**
     * @var boolean
     */
    private $perchas;

    /**
     * @var boolean
     */
    private $sueloBaldosa;

    /**
     * @var boolean
     */
    private $insonorizacion;

    /**
     * @var boolean
     */
    private $entradaPrivada;

    /**
     * @var boolean
     */
    private $ventilador;

    /**
     * @var boolean
     */
    private $plancha;

    /**
     * @var boolean
     */
    private $pestillo;

    /**
     * @var boolean
     */
    private $vistasCiudad;

    /**
     * @var boolean
     */
    private $vistasInteres;

    /**
     * @var boolean
     */
    private $comedor;

    /**
     * @var boolean
     */
    private $sofa;

    /**
     * @var boolean
     */
    private $zonaEstar;

    /**
     * @var boolean
     */
    private $escritorio;

    /**
     * @var boolean
     */
    private $chimenea;

    /**
     * @var boolean
     */
    private $zonaPortatiles;

    /**
     * @var boolean
     */
    private $tv;

    /**
     * @var boolean
     */
    private $tvPlana;

    /**
     * @var boolean
     */
    private $tvSatelite;

    /**
     * @var boolean
     */
    private $wifi;

    /**
     * @var boolean
     */
    private $parkingPublico;

    /**
     * @var boolean
     */
    private $parkingGratuito;

    /**
     * @var boolean
     */
    private $libros;

    /**
     * @var boolean
     */
    private $dvd;

    /**
     * @var boolean
     */
    private $puzzles;

    /**
     * @var boolean
     */
    private $eventos;

    /**
     * @var boolean
     */
    private $fiestas;

    /**
     * @var boolean
     */
    private $fumar;

    /**
     * @var boolean
     */
    private $mascotas;

    /**
     * @var boolean
     */
    private $botiquin;

    /**
     * @var boolean
     */
    private $detectorHumo;

    /**
     * @var boolean
     */
    private $detectorCO;

    /**
     * @var boolean
     */
    private $extintor;

    /**
     * @var boolean
     */
    private $fichaInstrucciones;

    /**
     * @var boolean
     */
    private $protectorEnchufes;

    /**
     * Constructor
     */
    public function __construct($arrayData = null)
    {
        $this->photos = new \Doctrine\Common\Collections\ArrayCollection();

        if($arrayData != null AND gettype($arrayData) == 'array'):

            foreach($arrayData as $key => $value ):
                $key = Inflector::camelize($key);

                if(property_exists('WWW\HouseBundle\Entity\House',$key)):

                    if($key != 'id' AND $key !='capacity' AND $key !='bathrooms' AND $key != 'bedrooms'
                        AND $key != 'beds' AND is_numeric($value) ):

                        $this->$key = (bool)$value;

                    elseif($key == 'address'):
                        $this->createAddress($arrayData['address']);

                    else:

                        $this->$key = $value;

                    endif;
                endif;

            endforeach;

            if(array_key_exists('photo', $arrayData)):
                $photo = new Photo();
                $photo->setUrl($arrayData['photo']);
                $this->photos->add($photo);
            endif;

        endif;
    }

    private function createAddress($array){
        $address = new Address($array);

        $this->address = $address;
    }

    public function setId($id){
        $this->id = $id;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return House
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set licenseNumber
     *
     * @param string $licenseNumber
     *
     * @return House
     */
    public function setLicenseNumber($licenseNumber)
    {
        $this->licenseNumber = $licenseNumber;

        return $this;
    }

    /**
     * Get licenseNumber
     *
     * @return string
     */
    public function getLicenseNumber()
    {
        return $this->licenseNumber;
    }

    /**
     * Set capacity
     *
     * @param integer $capacity
     *
     * @return House
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;

        return $this;
    }

    /**
     * Get capacity
     *
     * @return integer
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * Set bathrooms
     *
     * @param integer $bathrooms
     *
     * @return House
     */
    public function setBathrooms($bathrooms)
    {
        $this->bathrooms = $bathrooms;

        return $this;
    }

    /**
     * Get bathrooms
     *
     * @return integer
     */
    public function getBathrooms()
    {
        return $this->bathrooms;
    }

    /**
     * Set bedrooms
     *
     * @param string $bedrooms
     *
     * @return House
     */
    public function setBedrooms($bedrooms)
    {
        $this->bedrooms = $bedrooms;

        return $this;
    }

    /**
     * Get bedrooms
     *
     * @return string
     */
    public function getBedrooms()
    {
        return $this->bedrooms;
    }

    /**
     * Set beds
     *
     * @param integer $beds
     *
     * @return House
     */
    public function setBeds($beds)
    {
        $this->beds = $beds;

        return $this;
    }

    /**
     * Get beds
     *
     * @return integer
     */
    public function getBeds()
    {
        return $this->beds;
    }

    /**
     * Set aireAcondicionado
     *
     * @param boolean $aireAcondicionado
     *
     * @return House
     */
    public function setAireAcondicionado($aireAcondicionado)
    {
        $this->aireAcondicionado = $aireAcondicionado;

        return $this;
    }

    /**
     * Get aireAcondicionado
     *
     * @return boolean
     */
    public function getAireAcondicionado()
    {
        return $this->aireAcondicionado;
    }

    /**
     * Set calefaccion
     *
     * @param boolean $calefaccion
     *
     * @return House
     */
    public function setCalefaccion($calefaccion)
    {
        $this->calefaccion = $calefaccion;

        return $this;
    }

    /**
     * Get calefaccion
     *
     * @return boolean
     */
    public function getCalefaccion()
    {
        return $this->calefaccion;
    }

    /**
     * Set ascensor
     *
     * @param boolean $ascensor
     *
     * @return House
     */
    public function setAscensor($ascensor)
    {
        $this->ascensor = $ascensor;

        return $this;
    }

    /**
     * Get ascensor
     *
     * @return boolean
     */
    public function getAscensor()
    {
        return $this->ascensor;
    }

    /**
     * Set portero
     *
     * @param boolean $portero
     *
     * @return House
     */
    public function setPortero($portero)
    {
        $this->portero = $portero;

        return $this;
    }

    /**
     * Get portero
     *
     * @return boolean
     */
    public function getPortero()
    {
        return $this->portero;
    }

    /**
     * Set timbre
     *
     * @param boolean $timbre
     *
     * @return House
     */
    public function setTimbre($timbre)
    {
        $this->timbre = $timbre;

        return $this;
    }

    /**
     * Get timbre
     *
     * @return boolean
     */
    public function getTimbre()
    {
        return $this->timbre;
    }

    /**
     * Set apartamentoEdificio
     *
     * @param boolean $apartamentoEdificio
     *
     * @return House
     */
    public function setApartamentoEdificio($apartamentoEdificio)
    {
        $this->apartamentoEdificio = $apartamentoEdificio;

        return $this;
    }

    /**
     * Get apartamentoEdificio
     *
     * @return boolean
     */
    public function getApartamentoEdificio()
    {
        return $this->apartamentoEdificio;
    }

    /**
     * Set accesoDiscapacitados
     *
     * @param boolean $accesoDiscapacitados
     *
     * @return House
     */
    public function setAccesoDiscapacitados($accesoDiscapacitados)
    {
        $this->accesoDiscapacitados = $accesoDiscapacitados;

        return $this;
    }

    /**
     * Get accesoDiscapacitados
     *
     * @return boolean
     */
    public function getAccesoDiscapacitados()
    {
        return $this->accesoDiscapacitados;
    }

    /**
     * Set piscina
     *
     * @param boolean $piscina
     *
     * @return House
     */
    public function setPiscina($piscina)
    {
        $this->piscina = $piscina;

        return $this;
    }

    /**
     * Get piscina
     *
     * @return boolean
     */
    public function getPiscina()
    {
        return $this->piscina;
    }

    /**
     * Set gimnasio
     *
     * @param boolean $gimnasio
     *
     * @return House
     */
    public function setGimnasio($gimnasio)
    {
        $this->gimnasio = $gimnasio;

        return $this;
    }

    /**
     * Get gimnasio
     *
     * @return boolean
     */
    public function getGimnasio()
    {
        return $this->gimnasio;
    }

    /**
     * Set papelHigienico
     *
     * @param boolean $papelHigienico
     *
     * @return House
     */
    public function setPapelHigienico($papelHigienico)
    {
        $this->papelHigienico = $papelHigienico;

        return $this;
    }

    /**
     * Get papelHigienico
     *
     * @return boolean
     */
    public function getPapelHigienico()
    {
        return $this->papelHigienico;
    }

    /**
     * Set bidet
     *
     * @param boolean $bidet
     *
     * @return House
     */
    public function setBidet($bidet)
    {
        $this->bidet = $bidet;

        return $this;
    }

    /**
     * Get bidet
     *
     * @return boolean
     */
    public function getBidet()
    {
        return $this->bidet;
    }

    /**
     * Set banera
     *
     * @param boolean $banera
     *
     * @return House
     */
    public function setBanera($banera)
    {
        $this->banera = $banera;

        return $this;
    }

    /**
     * Get banera
     *
     * @return boolean
     */
    public function getBanera()
    {
        return $this->banera;
    }

    /**
     * Set secadorPelo
     *
     * @param boolean $secadorPelo
     *
     * @return House
     */
    public function setSecadorPelo($secadorPelo)
    {
        $this->secadorPelo = $secadorPelo;

        return $this;
    }

    /**
     * Get secadorPelo
     *
     * @return boolean
     */
    public function getSecadorPelo()
    {
        return $this->secadorPelo;
    }

    /**
     * Set jacuzzi
     *
     * @param boolean $jacuzzi
     *
     * @return House
     */
    public function setJacuzzi($jacuzzi)
    {
        $this->jacuzzi = $jacuzzi;

        return $this;
    }

    /**
     * Get jacuzzi
     *
     * @return boolean
     */
    public function getJacuzzi()
    {
        return $this->jacuzzi;
    }

    /**
     * Set champu
     *
     * @param boolean $champu
     *
     * @return House
     */
    public function setChampu($champu)
    {
        $this->champu = $champu;

        return $this;
    }

    /**
     * Get champu
     *
     * @return boolean
     */
    public function getChampu()
    {
        return $this->champu;
    }

    /**
     * Set mesaComedor
     *
     * @param boolean $mesaComedor
     *
     * @return House
     */
    public function setMesaComedor($mesaComedor)
    {
        $this->mesaComedor = $mesaComedor;

        return $this;
    }

    /**
     * Get mesaComedor
     *
     * @return boolean
     */
    public function getMesaComedor()
    {
        return $this->mesaComedor;
    }

    /**
     * Set cafetera
     *
     * @param boolean $cafetera
     *
     * @return House
     */
    public function setCafetera($cafetera)
    {
        $this->cafetera = $cafetera;

        return $this;
    }

    /**
     * Get cafetera
     *
     * @return boolean
     */
    public function getCafetera()
    {
        return $this->cafetera;
    }

    /**
     * Set productosLimpieza
     *
     * @param boolean $productosLimpieza
     *
     * @return House
     */
    public function setProductosLimpieza($productosLimpieza)
    {
        $this->productosLimpieza = $productosLimpieza;

        return $this;
    }

    /**
     * Get productosLimpieza
     *
     * @return boolean
     */
    public function getProductosLimpieza()
    {
        return $this->productosLimpieza;
    }

    /**
     * Set horno
     *
     * @param boolean $horno
     *
     * @return House
     */
    public function setHorno($horno)
    {
        $this->horno = $horno;

        return $this;
    }

    /**
     * Get horno
     *
     * @return boolean
     */
    public function getHorno()
    {
        return $this->horno;
    }

    /**
     * Set utensiliosCocina
     *
     * @param boolean $utensiliosCocina
     *
     * @return House
     */
    public function setUtensiliosCocina($utensiliosCocina)
    {
        $this->utensiliosCocina = $utensiliosCocina;

        return $this;
    }

    /**
     * Get utensiliosCocina
     *
     * @return boolean
     */
    public function getUtensiliosCocina()
    {
        return $this->utensiliosCocina;
    }

    /**
     * Set lavadora
     *
     * @param boolean $lavadora
     *
     * @return House
     */
    public function setLavadora($lavadora)
    {
        $this->lavadora = $lavadora;

        return $this;
    }

    /**
     * Get lavadora
     *
     * @return boolean
     */
    public function getLavadora()
    {
        return $this->lavadora;
    }

    /**
     * Set microondas
     *
     * @param boolean $microondas
     *
     * @return House
     */
    public function setMicroondas($microondas)
    {
        $this->microondas = $microondas;

        return $this;
    }

    /**
     * Get microondas
     *
     * @return boolean
     */
    public function getMicroondas()
    {
        return $this->microondas;
    }

    /**
     * Set nevera
     *
     * @param boolean $nevera
     *
     * @return House
     */
    public function setNevera($nevera)
    {
        $this->nevera = $nevera;

        return $this;
    }

    /**
     * Get nevera
     *
     * @return boolean
     */
    public function getNevera()
    {
        return $this->nevera;
    }

    /**
     * Set secadora
     *
     * @param boolean $secadora
     *
     * @return House
     */
    public function setSecadora($secadora)
    {
        $this->secadora = $secadora;

        return $this;
    }

    /**
     * Get secadora
     *
     * @return boolean
     */
    public function getSecadora()
    {
        return $this->secadora;
    }

    /**
     * Set desayuno
     *
     * @param boolean $desayuno
     *
     * @return House
     */
    public function setDesayuno($desayuno)
    {
        $this->desayuno = $desayuno;

        return $this;
    }

    /**
     * Get desayuno
     *
     * @return boolean
     */
    public function getDesayuno()
    {
        return $this->desayuno;
    }

    /**
     * Set armario
     *
     * @param boolean $armario
     *
     * @return House
     */
    public function setArmario($armario)
    {
        $this->armario = $armario;

        return $this;
    }

    /**
     * Get armario
     *
     * @return boolean
     */
    public function getArmario()
    {
        return $this->armario;
    }

    /**
     * Set sabanas
     *
     * @param boolean $sabanas
     *
     * @return House
     */
    public function setSabanas($sabanas)
    {
        $this->sabanas = $sabanas;

        return $this;
    }

    /**
     * Get sabanas
     *
     * @return boolean
     */
    public function getSabanas()
    {
        return $this->sabanas;
    }

    /**
     * Set sofaCama
     *
     * @param boolean $sofaCama
     *
     * @return House
     */
    public function setSofaCama($sofaCama)
    {
        $this->sofaCama = $sofaCama;

        return $this;
    }

    /**
     * Get sofaCama
     *
     * @return boolean
     */
    public function getSofaCama()
    {
        return $this->sofaCama;
    }

    /**
     * Set tendedero
     *
     * @param boolean $tendedero
     *
     * @return House
     */
    public function setTendedero($tendedero)
    {
        $this->tendedero = $tendedero;

        return $this;
    }

    /**
     * Get tendedero
     *
     * @return boolean
     */
    public function getTendedero()
    {
        return $this->tendedero;
    }

    /**
     * Set perchero
     *
     * @param boolean $perchero
     *
     * @return House
     */
    public function setPerchero($perchero)
    {
        $this->perchero = $perchero;

        return $this;
    }

    /**
     * Get perchero
     *
     * @return boolean
     */
    public function getPerchero()
    {
        return $this->perchero;
    }

    /**
     * Set perchas
     *
     * @param boolean $perchas
     *
     * @return House
     */
    public function setPerchas($perchas)
    {
        $this->perchas = $perchas;

        return $this;
    }

    /**
     * Get perchas
     *
     * @return boolean
     */
    public function getPerchas()
    {
        return $this->perchas;
    }

    /**
     * Set sueloBaldosa
     *
     * @param boolean $sueloBaldosa
     *
     * @return House
     */
    public function setSueloBaldosa($sueloBaldosa)
    {
        $this->sueloBaldosa = $sueloBaldosa;

        return $this;
    }

    /**
     * Get sueloBaldosa
     *
     * @return boolean
     */
    public function getSueloBaldosa()
    {
        return $this->sueloBaldosa;
    }

    /**
     * Set insonorizacion
     *
     * @param boolean $insonorizacion
     *
     * @return House
     */
    public function setInsonorizacion($insonorizacion)
    {
        $this->insonorizacion = $insonorizacion;

        return $this;
    }

    /**
     * Get insonorizacion
     *
     * @return boolean
     */
    public function getInsonorizacion()
    {
        return $this->insonorizacion;
    }

    /**
     * Set entradaPrivada
     *
     * @param boolean $entradaPrivada
     *
     * @return House
     */
    public function setEntradaPrivada($entradaPrivada)
    {
        $this->entradaPrivada = $entradaPrivada;

        return $this;
    }

    /**
     * Get entradaPrivada
     *
     * @return boolean
     */
    public function getEntradaPrivada()
    {
        return $this->entradaPrivada;
    }

    /**
     * Set ventilador
     *
     * @param boolean $ventilador
     *
     * @return House
     */
    public function setVentilador($ventilador)
    {
        $this->ventilador = $ventilador;

        return $this;
    }

    /**
     * Get ventilador
     *
     * @return boolean
     */
    public function getVentilador()
    {
        return $this->ventilador;
    }

    /**
     * Set plancha
     *
     * @param boolean $plancha
     *
     * @return House
     */
    public function setPlancha($plancha)
    {
        $this->plancha = $plancha;

        return $this;
    }

    /**
     * Get plancha
     *
     * @return boolean
     */
    public function getPlancha()
    {
        return $this->plancha;
    }

    /**
     * Set pestillo
     *
     * @param boolean $pestillo
     *
     * @return House
     */
    public function setPestillo($pestillo)
    {
        $this->pestillo = $pestillo;

        return $this;
    }

    /**
     * Get pestillo
     *
     * @return boolean
     */
    public function getPestillo()
    {
        return $this->pestillo;
    }

    /**
     * Set vistasCiudad
     *
     * @param boolean $vistasCiudad
     *
     * @return House
     */
    public function setVistasCiudad($vistasCiudad)
    {
        $this->vistasCiudad = $vistasCiudad;

        return $this;
    }

    /**
     * Get vistasCiudad
     *
     * @return boolean
     */
    public function getVistasCiudad()
    {
        return $this->vistasCiudad;
    }

    /**
     * Set vistasInteres
     *
     * @param boolean $vistasInteres
     *
     * @return House
     */
    public function setVistasInteres($vistasInteres)
    {
        $this->vistasInteres = $vistasInteres;

        return $this;
    }

    /**
     * Get vistasInteres
     *
     * @return boolean
     */
    public function getVistasInteres()
    {
        return $this->vistasInteres;
    }

    /**
     * Set comedor
     *
     * @param boolean $comedor
     *
     * @return House
     */
    public function setComedor($comedor)
    {
        $this->comedor = $comedor;

        return $this;
    }

    /**
     * Get comedor
     *
     * @return boolean
     */
    public function getComedor()
    {
        return $this->comedor;
    }

    /**
     * Set sofa
     *
     * @param boolean $sofa
     *
     * @return House
     */
    public function setSofa($sofa)
    {
        $this->sofa = $sofa;

        return $this;
    }

    /**
     * Get sofa
     *
     * @return boolean
     */
    public function getSofa()
    {
        return $this->sofa;
    }

    /**
     * Set zonaEstar
     *
     * @param boolean $zonaEstar
     *
     * @return House
     */
    public function setZonaEstar($zonaEstar)
    {
        $this->zonaEstar = $zonaEstar;

        return $this;
    }

    /**
     * Get zonaEstar
     *
     * @return boolean
     */
    public function getZonaEstar()
    {
        return $this->zonaEstar;
    }

    /**
     * Set escritorio
     *
     * @param boolean $escritorio
     *
     * @return House
     */
    public function setEscritorio($escritorio)
    {
        $this->escritorio = $escritorio;

        return $this;
    }

    /**
     * Get escritorio
     *
     * @return boolean
     */
    public function getEscritorio()
    {
        return $this->escritorio;
    }

    /**
     * Set chimenea
     *
     * @param boolean $chimenea
     *
     * @return House
     */
    public function setChimenea($chimenea)
    {
        $this->chimenea = $chimenea;

        return $this;
    }

    /**
     * Get chimenea
     *
     * @return boolean
     */
    public function getChimenea()
    {
        return $this->chimenea;
    }

    /**
     * Set zonaPortatiles
     *
     * @param boolean $zonaPortatiles
     *
     * @return House
     */
    public function setZonaPortatiles($zonaPortatiles)
    {
        $this->zonaPortatiles = $zonaPortatiles;

        return $this;
    }

    /**
     * Get zonaPortatiles
     *
     * @return boolean
     */
    public function getZonaPortatiles()
    {
        return $this->zonaPortatiles;
    }

    /**
     * Set tv
     *
     * @param boolean $tv
     *
     * @return House
     */
    public function setTv($tv)
    {
        $this->tv = $tv;

        return $this;
    }

    /**
     * Get tv
     *
     * @return boolean
     */
    public function getTv()
    {
        return $this->tv;
    }

    /**
     * Set tvPlana
     *
     * @param boolean $tvPlana
     *
     * @return House
     */
    public function setTvPlana($tvPlana)
    {
        $this->tvPlana = $tvPlana;

        return $this;
    }

    /**
     * Get tvPlana
     *
     * @return boolean
     */
    public function getTvPlana()
    {
        return $this->tvPlana;
    }

    /**
     * Set tvSatelite
     *
     * @param boolean $tvSatelite
     *
     * @return House
     */
    public function setTvSatelite($tvSatelite)
    {
        $this->tvSatelite = $tvSatelite;

        return $this;
    }

    /**
     * Get tvSatelite
     *
     * @return boolean
     */
    public function getTvSatelite()
    {
        return $this->tvSatelite;
    }

    /**
     * Set wifi
     *
     * @param boolean $wifi
     *
     * @return House
     */
    public function setWifi($wifi)
    {
        $this->wifi = $wifi;

        return $this;
    }

    /**
     * Get wifi
     *
     * @return boolean
     */
    public function getWifi()
    {
        return $this->wifi;
    }

    /**
     * Set parkingPublico
     *
     * @param boolean $parkingPublico
     *
     * @return House
     */
    public function setParkingPublico($parkingPublico)
    {
        $this->parkingPublico = $parkingPublico;

        return $this;
    }

    /**
     * Get parkingPublico
     *
     * @return boolean
     */
    public function getParkingPublico()
    {
        return $this->parkingPublico;
    }

    /**
     * Set parkingGratuito
     *
     * @param boolean $parkingGratuito
     *
     * @return House
     */
    public function setParkingGratuito($parkingGratuito)
    {
        $this->parkingGratuito = $parkingGratuito;

        return $this;
    }

    /**
     * Get parkingGratuito
     *
     * @return boolean
     */
    public function getParkingGratuito()
    {
        return $this->parkingGratuito;
    }

    /**
     * Set libros
     *
     * @param boolean $libros
     *
     * @return House
     */
    public function setLibros($libros)
    {
        $this->libros = $libros;

        return $this;
    }

    /**
     * Get libros
     *
     * @return boolean
     */
    public function getLibros()
    {
        return $this->libros;
    }

    /**
     * Set dvd
     *
     * @param boolean $dvd
     *
     * @return House
     */
    public function setDvd($dvd)
    {
        $this->dvd = $dvd;

        return $this;
    }

    /**
     * Get dvd
     *
     * @return boolean
     */
    public function getDvd()
    {
        return $this->dvd;
    }

    /**
     * Set puzzles
     *
     * @param boolean $puzzles
     *
     * @return House
     */
    public function setPuzzles($puzzles)
    {
        $this->puzzles = $puzzles;

        return $this;
    }

    /**
     * Get puzzles
     *
     * @return boolean
     */
    public function getPuzzles()
    {
        return $this->puzzles;
    }

    /**
     * Set eventos
     *
     * @param boolean $eventos
     *
     * @return House
     */
    public function setEventos($eventos)
    {
        $this->eventos = $eventos;

        return $this;
    }

    /**
     * Get eventos
     *
     * @return boolean
     */
    public function getEventos()
    {
        return $this->eventos;
    }

    /**
     * Set fiestas
     *
     * @param boolean $fiestas
     *
     * @return House
     */
    public function setFiestas($fiestas)
    {
        $this->fiestas = $fiestas;

        return $this;
    }

    /**
     * Get fiestas
     *
     * @return boolean
     */
    public function getFiestas()
    {
        return $this->fiestas;
    }

    /**
     * Set fumar
     *
     * @param boolean $fumar
     *
     * @return House
     */
    public function setFumar($fumar)
    {
        $this->fumar = $fumar;

        return $this;
    }

    /**
     * Get fumar
     *
     * @return boolean
     */
    public function getFumar()
    {
        return $this->fumar;
    }

    /**
     * Set mascotas
     *
     * @param boolean $mascotas
     *
     * @return House
     */
    public function setMascotas($mascotas)
    {
        $this->mascotas = $mascotas;

        return $this;
    }

    /**
     * Get mascotas
     *
     * @return boolean
     */
    public function getMascotas()
    {
        return $this->mascotas;
    }

    /**
     * Set botiquin
     *
     * @param boolean $botiquin
     *
     * @return House
     */
    public function setBotiquin($botiquin)
    {
        $this->botiquin = $botiquin;

        return $this;
    }

    /**
     * Get botiquin
     *
     * @return boolean
     */
    public function getBotiquin()
    {
        return $this->botiquin;
    }

    /**
     * Set detectorHumo
     *
     * @param boolean $detectorHumo
     *
     * @return House
     */
    public function setDetectorHumo($detectorHumo)
    {
        $this->detectorHumo = $detectorHumo;

        return $this;
    }

    /**
     * Get detectorHumo
     *
     * @return boolean
     */
    public function getDetectorHumo()
    {
        return $this->detectorHumo;
    }

    /**
     * Set detectorCO
     *
     * @param boolean $detectorCO
     *
     * @return House
     */
    public function setDetectorCO($detectorCO)
    {
        $this->detectorCO = $detectorCO;

        return $this;
    }

    /**
     * Get detectorCO
     *
     * @return boolean
     */
    public function getDetectorCO()
    {
        return $this->detectorCO;
    }

    /**
     * Set extintor
     *
     * @param boolean $extintor
     *
     * @return House
     */
    public function setExtintor($extintor)
    {
        $this->extintor = $extintor;

        return $this;
    }

    /**
     * Get extintor
     *
     * @return boolean
     */
    public function getExtintor()
    {
        return $this->extintor;
    }

    /**
     * Set fichaInstrucciones
     *
     * @param boolean $fichaInstrucciones
     *
     * @return House
     */
    public function setFichaInstrucciones($fichaInstrucciones)
    {
        $this->fichaInstrucciones = $fichaInstrucciones;

        return $this;
    }

    /**
     * Get fichaInstrucciones
     *
     * @return boolean
     */
    public function getFichaInstrucciones()
    {
        return $this->fichaInstrucciones;
    }

    /**
     * Set protectorEnchufes
     *
     * @param boolean $protectorEnchufes
     *
     * @return House
     */
    public function setProtectorEnchufes($protectorEnchufes)
    {
        $this->protectorEnchufes = $protectorEnchufes;

        return $this;
    }

    /**
     * Get protectorEnchufes
     *
     * @return boolean
     */
    public function getProtectorEnchufes()
    {
        return $this->protectorEnchufes;
    }

    /**
     * Set address
     *
     * @param \WWW\GlobalBundle\Entity\Address $address
     *
     * @return House
     */
    public function setAddress(\WWW\GlobalBundle\Entity\Address $address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return \WWW\GlobalBundle\Entity\Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set calendar
     *
     * @param \WWW\GlobalBundle\Entity\Calendar $calendar
     *
     * @return House
     */
    public function setCalendar(\WWW\GlobalBundle\Entity\Calendar $calendar = null)
    {
        $this->calendar = $calendar;

        return $this;
    }

    /**
     * Get calendar
     *
     * @return \WWW\GlobalBundle\Entity\Calendar
     */
    public function getCalendar()
    {
        return $this->calendar;
    }

    /**
     * Add photo
     *
     * @param \WWW\GlobalBundle\Entity\Photo $photo
     *
     * @return House
     */
    public function addPhoto(\WWW\GlobalBundle\Entity\Photo $photo)
    {
        $this->photos[] = $photo;

        return $this;
    }

    /**
     * Remove photo
     *
     * @param \WWW\GlobalBundle\Entity\Photo $photo
     */
    public function removePhoto(\WWW\GlobalBundle\Entity\Photo $photo)
    {
        $this->photos->removeElement($photo);
    }

    /**
     * Get photos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * Set user
     *
     * @param \WWW\UserBundle\Entity\User $user
     *
     * @return House
     */
    public function setUser(\WWW\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \WWW\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return House
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set modifiedDate
     *
     * @param \DateTime $modifiedDate
     *
     * @return House
     */
    public function setModifiedDate($modifiedDate)
    {
        $this->modifiedDate = $modifiedDate;

        return $this;
    }

    /**
     * Get modifiedDate
     *
     * @return \DateTime
     */
    public function getModifiedDate()
    {
        return $this->modifiedDate;
    }

    /**
     * Set deletedDate
     *
     * @param \DateTime $deletedDate
     *
     * @return House
     */
    public function setDeletedDate($deletedDate)
    {
        $this->deletedDate = $deletedDate;

        return $this;
    }

    /**
     * Get deletedDate
     *
     * @return \DateTime
     */
    public function getDeletedDate()
    {
        return $this->deletedDate;
    }

    /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     *
     * @return House
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * Get isDeleted
     *
     * @return boolean
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return House
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set fogones
     *
     * @param boolean $fogones
     * @return House
     */
    public function setFogones($fogones)
    {
        $this->fogones = $fogones;

        return $this;
    }

    /**
     * Get fogones
     *
     * @return boolean 
     */
    public function getFogones()
    {
        return $this->fogones;
    }

    /**
     * Devuelve el nombre de los atributos de la  clase para poder actualizar las casas con un bucle
     * @return array
     */
    public function getAttr(){
        
        $array = array();
        
        foreach($this as $key => $value)
            
            if($key != 'address' && $key != 'calendar' && $key != 'photos' && $key != 'user' && $key != 'createdDate'
                && $key != 'modifiedDate' && $key != 'deletedDate' && $key != 'isDeleted')
                
                $array[] = $key;
        
        return $array;
    }

    /**
     * Función que crea un array que sirve que luego en twig se agrupen las opciones de la casa y pueda coger el label y
     * el atributo que le corresponde.
     * Esto en realidad lo suyo sería que estuviera en la BBDD pero de momento es lo más rápido
     * En caso de que no se quiera ese orden es cuestión de cambiar el orden en el que se está creando cada grupo
     * 
     * @return array
     */
    public function getArrayGroupsAttrH(){
        $arrayAttr = array();
        $arrayAttr['varios'] = array(   array('label' =>'Aire acondicionado','attr' => 'aireAcondicionado'),
            array('label' =>'Calefacción','attr' => 'calefaccion'),
            array('label' =>'Ascensor','attr' => 'ascensor'),
            array('label' =>'Portero','attr' => 'portero'),
            array('label' =>'Timbre','attr' => 'timbre'),
            array('label' =>'Apartamento privado en edificio','attr' => 'apartamentoEdificio'));

        $arrayAttr['accesibilidad'] = array(array('label' =>'Acceso para discapacitados','attr' => 'accesoDiscapacitados'));

        $arrayAttr['aparcamiento'] = array(array('label' =>'Parking público','attr' => 'parkingPublico'),
            array('label' =>'Parking gratuito','attr' => 'parkingGratuito'));

        $arrayAttr['baño'] = array( array('label' =>'papel higiénico','attr' => 'papelHigienico'),
            array('label' =>'bidé','attr' => 'bidet'),
            array('label' =>'bañera','attr' => 'banera'),
            array('label' =>'secador de pelo','attr' => 'secadorPelo'),
            array('label' =>'jacuzzi','attr' => 'jacuzzi'),
            array('label' =>'champú y gel','attr' => 'champu'));

        $arrayAttr['cocina'] = array(array('label' =>'mesa de comedor','attr' => 'mesaComedor'),
            array('label' =>'cafetera','attr' => 'cafetera'),
            array('label' =>'productos de limpieza','attr' => 'productosLimpieza'),
            array('label' =>'fogones','attr' => 'fogones'),
            array('label' =>'horno','attr' => 'horno'),
            array('label' =>'utensilios de cocina','attr' => 'utensiliosCocina'),
            array('label' =>'microondas','attr' => 'microondas'),
            array('label' =>'nevera','attr' => 'nevera'));

        $arrayAttr['habitacion'] = array(array('label' =>'armarios','attr' =>'armario'),
            array('label' =>'sábanas','attr' => 'sabanas'),
            array('label' =>'perchero','attr' => 'perchero'),
            array('label' =>'perchas','attr' => 'perchas'),
            array('label' =>'insonorización','attr' => 'insonorizacion'),
            array('label' =>'entrada privada','attr' => 'entradaPrivada'),
            array('label' =>'ventilador','attr' => 'ventilador'),
            array('label' =>'pestillo','attr' => 'pestillo'));

        $arrayAttr['sala de estar'] = array(array('label' =>'sofa cama','attr' => 'sofaCama'),
            array('label' =>'zona de comedor','attr' => 'comedor'),
            array('label' =>'escritorio','attr' => 'escritorio'),
            array('label' =>'chimenea','attr' => 'chimenea'),
            array('label' =>'zona para trabajar con portátiles','attr' => 'zonaPortatiles'));

        $arrayAttr['vistas'] = array(array('label' =>'vistas a la ciudad','attr' => 'vistasCiudad'),
            array('label' =>'vistas de interés','attr' => 'vistasInteres'));

        $arrayAttr['equipamiento audiovisual y tecnológico'] = array(array('label' =>'televisión','attr' => 'tv'),
            array('label' =>'televisión plana','attr' => 'tvPlana'),
            array('label' =>'tevisión por satétlite','attr'=> 'tvSatelite'),
            array('label' =>'wifi','attr' => 'wifi'),
            array('label' =>'dvd','attr' => 'dvd'));

        $arrayAttr['normas'] = array(array('label' => 'eventos', 'attr' => 'eventos'),
            array('label' => 'fiestas', 'attr' => 'fiestas'),
            array('label' => 'fumar', 'attr' => 'fumar'),
            array('label' => 'mascotas', 'attr' => 'mascotas'));

        $arrayAttr['seguridad'] = array(array('label' => 'botiquín', 'attr'=> 'botiquin'),
            array('label' => 'detector de humos', 'attr' => 'detectorHumo'),
            array('label' => 'detector de monóxido de carbono', 'attr' => 'detectorCO'),
            array('label' => 'extintor', 'attr' => 'extintor'),
            array('label' => 'ficha de instrucciones de seguridad', 'attr' => 'fichaInstrucciones'),
            array('label' => 'pestillo en la puerta del dormitorio', 'attr' => 'pestillo'),
            array('label' => 'protectores de enchufes para niños', 'attr' => 'protectorEnchufes')) ;

        return $arrayAttr;
    }
}

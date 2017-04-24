<?php

namespace WWW\CarsBundle\Entity;

use Doctrine\Common\Util\Inflector;
use Symfony\Component\Validator\Constraints as Assert;
use WWW\GlobalBundle\Entity\Photo;
use WWW\UserBundle\Entity\User;


/**
 * Car
 */
class Car {
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Por favor rellene este campo", groups = {"newCar"})
     */
    private $plate;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Por favor rellene este campo", groups = {"newCar"})
     */
    private $color;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Por favor rellene este campo", groups = {"newCar"})
     */
    private $description;

    /**
     * @var \DateTime
     */
    private $enrollmentDate;

    /**
     * @var string
     */
    private $kilometers;

    /**
     * @var string
     */
    private $carInsurance;

    /**
     * @var boolean
     */
    private $smoke;

    /**
     * @var boolean
     */
    private $animals;

    /**
     * @var boolean
     */
    private $music;

    /**
     * @var boolean
     */
    private $talk;

    /**
     * @var float
     */
    private $maxWidth;

    /**
     * @var float
     */
    private $maxHeight;

    /**
     * @var float
     */
    private $maxDepth;

    /**
     * @var float
     */
    private $maxWeight;

    /**
     * @var \WWW\UserBundle\Entity\User
     */
    private $user;

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
     * @var \Doctrine\Common\Collections\Collection
     */
    
    private $photos;

    /**
     * @var integer
     *
     * @Assert\Range(min=2,  minMessage="Mínimo 2 plazas", groups = {"newCar"})
     * @Assert\NotBlank(message="Por favor rellene este campo", groups = {"newCar"})
     */
    private $seats;

    /**
     * @var string
     */
    private $type;

    /**
     * @var \WWW\CarsBundle\Entity\Model
     */
    private $model;

    /**
     * Constructor
     */
    public function __construct($data = null){

        if($data != null):

            foreach($data as $key => $value):
                $key = Inflector::camelize($key);

                if(property_exists('WWW\CarsBundle\Entity\Car',$key)):

                    if($key != 'model'):
                        if($key == 'smoke' || $key == 'animals' || $key == 'music' || $key == 'talk'):

                            $value = (bool) $value;
                        endif;
                        $this->$key = $value;
                    else:
                        $idBrand = null;
                        if(array_key_exists('brand_id',$data)) $idBrand = $data['brand_id'];
                        $this->model = new Model($data['model_id'],$data['model'],$idBrand,$data['brand']);
                    endif;
                endif;

            endforeach;

            $this->photoCar($data);

            $this->user = new User();
            $this->user->setId($data['user_id']);
        else:
            $this->photos = new \Doctrine\Common\Collections\ArrayCollection();
            $this->brand = new Model();
        endif;


    }

    private function photoCar($data){

        $this->photos = new \Doctrine\Common\Collections\ArrayCollection();

        if(array_key_exists('photos', $data)):
            foreach($data['photos'] as $value):
                $photo =  new Photo($value);
                $this->addPhoto($photo);
            endforeach;
        elseif(array_key_exists('car_photo', $data)):
            $photo =  new Photo($data['car_photo']);

            if(array_key_exists('car_photo_id', $data)):
                $photo->setId($data['car_photo_id']);
            endif;
            
            $this->addPhoto($photo);
        endif;
    }

    public function setId($id){
        return $this->id = $id;
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

    /**
     * Set plate
     *
     * @param string $plate
     *
     * @return Car
     */
    public function setPlate($plate)
    {
        $this->plate = $plate;

        return $this;
    }

    /**
     * Get plate
     *
     * @return string
     */
    public function getPlate()
    {
        return $this->plate;
    }

    /**
     * Set color
     *
     * @param string $color
     *
     * @return Car
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Car
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
     * Set enrollmentDate
     *
     * @param \DateTime $enrollmentDate
     *
     * @return Car
     */
    public function setEnrollmentDate($enrollmentDate)
    {
        $this->enrollmentDate = $enrollmentDate;

        return $this;
    }

    /**
     * Get enrollmentDate
     *
     * @return \DateTime
     */
    public function getEnrollmentDate()
    {
        return $this->enrollmentDate;
    }

    /**
     * Set kilometers
     *
     * @param string $kilometers
     *
     * @return Car
     */
    public function setKilometers($kilometers)
    {
        $this->kilometers = $kilometers;

        return $this;
    }

    /**
     * Get kilometers
     *
     * @return string
     */
    public function getKilometers()
    {
        return $this->kilometers;
    }

    /**
     * Set carInsurance
     *
     * @param string $carInsurance
     *
     * @return Car
     */
    public function setCarInsurance($carInsurance)
    {
        $this->carInsurance = $carInsurance;

        return $this;
    }

    /**
     * Get carInsurance
     *
     * @return string
     */
    public function getCarInsurance()
    {
        return $this->carInsurance;
    }

    /**
     * Set smoke
     *
     * @param boolean $smoke
     *
     * @return Car
     */
    public function setSmoke($smoke)
    {
        $this->smoke = $smoke;

        return $this;
    }

    /**
     * Get smoke
     *
     * @return boolean
     */
    public function getSmoke()
    {
        return $this->smoke;
    }

    /**
     * Set animals
     *
     * @param boolean $animals
     *
     * @return Car
     */
    public function setAnimals($animals)
    {
        $this->animals = $animals;

        return $this;
    }

    /**
     * Get animals
     *
     * @return boolean
     */
    public function getAnimals()
    {
        return $this->animals;
    }

    /**
     * Set music
     *
     * @param boolean $music
     *
     * @return Car
     */
    public function setMusic($music)
    {
        $this->music = $music;

        return $this;
    }

    /**
     * Get music
     *
     * @return boolean
     */
    public function getMusic()
    {
        return $this->music;
    }

    /**
     * Set talk
     *
     * @param boolean $talk
     *
     * @return Car
     */
    public function setTalk($talk)
    {
        $this->talk = $talk;

        return $this;
    }

    /**
     * Get talk
     *
     * @return boolean
     */
    public function getTalk()
    {
        return $this->talk;
    }

    /**
     * Set maxWidth
     *
     * @param float $maxWidth
     *
     * @return Car
     */
    public function setMaxWidth($maxWidth)
    {
        $this->maxWidth = $maxWidth;

        return $this;
    }

    /**
     * Get maxWidth
     *
     * @return float
     */
    public function getMaxWidth()
    {
        return $this->maxWidth;
    }

    /**
     * Set maxHeight
     *
     * @param float $maxHeight
     *
     * @return Car
     */
    public function setMaxHeight($maxHeight)
    {
        $this->maxHeight = $maxHeight;

        return $this;
    }

    /**
     * Get maxHeight
     *
     * @return float
     */
    public function getMaxHeight()
    {
        return $this->maxHeight;
    }

    /**
     * Set maxDepth
     *
     * @param float $maxDepth
     *
     * @return Car
     */
    public function setMaxDepth($maxDepth)
    {
        $this->maxDepth = $maxDepth;

        return $this;
    }

    /**
     * Get maxDepth
     *
     * @return float
     */
    public function getMaxDepth()
    {
        return $this->maxDepth;
    }

    /**
     * Set maxWeight
     *
     * @param float $maxWeight
     *
     * @return Car
     */
    public function setMaxWeight($maxWeight)
    {
        $this->maxWeight = $maxWeight;

        return $this;
    }

    /**
     * Get maxWeight
     *
     * @return float
     */
    public function getMaxWeight()
    {
        return $this->maxWeight;
    }

    /**
     * Set user
     *
     * @param \WWW\UserBundle\Entity\User $user
     *
     * @return Car
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
     * @return Car
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
     * @return Car
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
     * @return Car
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
     * @return Car
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
     * Add photo
     *
     * @param \WWW\GlobalBundle\Entity\Photo $photo
     *
     * @return Car
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
     * Set seats
     *
     * @param integer $seats
     *
     * @return Car
     */
    public function setSeats($seats)
    {
        $this->seats = $seats;

        return $this;
    }

    /**
     * Get seats
     *
     * @return integer
     */
    public function getSeats()
    {
        return $this->seats;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Car
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set model
     *
     * @param \WWW\CarsBundle\Entity\Model $model
     *
     * @return Car
     */
    public function setModel(\WWW\CarsBundle\Entity\Model $model = null)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return \WWW\CarsBundle\Entity\Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /*
    * @return Array de grupos
    */
    public function getGroupSequence()
    {
        $groups = array('Car');

        if ($this->isNewCar()) :

            $groups[] = 'email';
        endif;

        return $groups;
    }
}

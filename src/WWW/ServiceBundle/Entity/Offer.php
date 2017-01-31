<?php

namespace WWW\ServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Util\Inflector as Inflector;
use WWW\GlobalBundle\Entity\Photo;
use WWW\UserBundle\Entity\User;


/**
 * Offer
 */
class Offer
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @var bool
     */
    private $expired;
    
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
     * @var \WWW\UserBundle\Entity\User
     */
    private $userAdmin;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $photos;
    
    
    /**
     * @var \WWW\ServiceBundle\Entity\Service
     */
    private $service;
    
    
    /**
     * @var integer
     */
    private $holders;    
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $inscriptions;
    
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $comments;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $valorations;

    /**
     * Constructor
     */
    public function __construct($data = null){ 
     //var_dump($data);
//        print_r($data);echo "<br><br>";
        $this->photos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comments = Array();
        
        if(gettype($data) == 'array'):
            $keyPhoto = '';
            foreach ($data as $key => $value):
                $key = Inflector::camelize($key);
                
                if(property_exists('WWW\ServiceBundle\Entity\Offer',$key)):
                    if($key == 'photos'):
                        foreach($value as $photo):
                            $newPhoto = new Photo($photo);
                            $this->photos[] = $newPhoto;
                        endforeach;
                    elseif($key == 'comments'):
                        $this->comments = Array();
                    
                        foreach($value as $aComment):
                            $comment = new Comment($aComment);
                            array_push($this->comments, $comment);
                        endforeach;
                    else:
                        $this->$key = $value;
                    endif;
                    
                endif;
            endforeach;
            if(array_key_exists('service_id', $data)):

                $service = new Service((int)$data['service_id']);
                if(isset($data['service']))
                    $service->setTitle($data['service']);

                $this->setService($service);
            endif;
            /*
             * Dependiendo de por donde se llame al constructor el id puede que 
             * venga en el campo offer_id
             */
            if(array_key_exists('offer_id',$data)):
                $this->id = $data['offer_id'];
            endif;
            
            /*Al buscar todas las ofertas de un usuario en el array en vez de 
             photo viene el campo url
             */
            if(array_key_exists('url', $data)):
                $keyPhoto = 'url';
            elseif(array_key_exists('offer_photo', $data)):
                 $keyPhoto = 'offer_photo';
            endif;
            
            if(!empty($keyPhoto)):
                $photoOffer = new Photo();
                $photoOffer->setUrl($data[$keyPhoto]);
                $this->photos[] = $photoOffer;
            endif;    
            
            if(array_key_exists('username', $data) && array_key_exists('user_photo', $data)):
                $user = new User();

                if(array_key_exists('avg_score',$data))
                    $user->setAvgScore($data['avg_score']);

                $user->setUsername($data['username']);
                $user->setId($data['user_admin_id']);
                $photoUser = new Photo();
                $photoUser->setUrl($data['user_photo']);
                $user->setPhoto($photoUser);
                $this->userAdmin = $user;
                if(array_key_exists('avg_score',$data))
                    $user->setAvgScore($data['avg_score']);
            endif;    
        endif;

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

    public function setId($id){
        $this->id = $id;
    }
    
    /**
     * Set title
     *
     * @param string $title
     * @return Offer
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
     * Set description
     *
     * @param string $description
     * @return Offer
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
     * Set expired
     *
     * @param boolean $expired
     * @return Offer
     */
    public function setExpired($expired)
    {
        $this->expired = $expired;

        return $this;
    }

    /**
     * Get expired
     *
     * @return boolean 
     */
    public function getExpired()
    {
        return $this->expired;
    }    

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return Offer
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
     * @return Offer
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
     * @return Offer
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
     * @return Offer
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
     * Set userAdmin
     *
     * @param \WWW\UserBundle\Entity\User $userAdmin
     * @return Offer
     */
    public function setUserAdmin(\WWW\UserBundle\Entity\User $userAdmin = null)
    {
        $this->userAdmin = $userAdmin;

        return $this;
    }

    /**
     * Get userAdmin
     *
     * @return \WWW\UserBundle\Entity\User 
     */
    public function getUserAdmin()
    {
        return $this->userAdmin;
    }

    /**
     * Add photos
     *
     * @param \WWW\GlobalBundle\Entity\Photo $photos
     * @return Offer
     */
    public function addPhoto(\WWW\GlobalBundle\Entity\Photo $photos)
    {
        //array_push($this->photos, $photos);
        $this->photos[] = $photos;

        return $this;
    }

    /**
     * Remove photos
     *
     * @param \WWW\GlobalBundle\Entity\Photo $photos
     */
    public function removePhoto(\WWW\GlobalBundle\Entity\Photo $photos)
    {
        $this->photos->removeElement($photos);
    }
    
    /**
     * Remove photo by position
     *  
     * @param type $pos
     */
    public function removePhotoByPos($pos){
        
        unset($this->photos[$pos]);
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
     * Set service
     *
     * @param \WWW\ServiceBundle\Entity\Service $service
     * @return Offer
     */
    public function setService($service = null)
    {
//        if(gettype($service == 'int')):
//            if($service == 1):
//                $newService = new Service();
//                $newService->setTable('trade');
//                $this->service = $newService;
//
//            endif;
//        else:
            $this->service = $service;
//        endif;

        return $this;
    }

    /**
     * Get service
     *
     * @return \WWW\ServiceBundle\Entity\Service 
     */
    public function getService()
    {
        return $this->service;
    }
    

    /**
     * Set holders
     *
     * @param integer $holders
     * @return Offer
     */
    public function setHolders($holders)
    {
        $this->holders = $holders;

        return $this;
    }

    /**
     * Get holders
     *
     * @return integer 
     */
    public function getHolders()
    {
        return $this->holders;
    }

    /**
     * Add inscriptions
     *
     * @param \WWW\ServiceBundle\Entity\Inscription $inscriptions
     * @return Offer
     */
    public function addInscription(\WWW\ServiceBundle\Entity\Inscription $inscriptions)
    {
        $this->inscriptions[] = $inscriptions;

        return $this;
    }

    /**
     * Remove inscriptions
     *
     * @param \WWW\ServiceBundle\Entity\Inscription $inscriptions
     */
    public function removeInscription(\WWW\ServiceBundle\Entity\Inscription $inscriptions)
    {
        $this->inscriptions->removeElement($inscriptions);
    }

    /**
     * Get inscriptions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInscriptions()
    {
        return $this->inscriptions;
    }


    /**
     * Add comments
     *
     * @param \WWW\ServiceBundle\Entity\Comment $comments
     * @return Offer
     */
    public function addComment(\WWW\ServiceBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \WWW\ServiceBundle\Entity\Comment $comments
     */
    public function removeComment(\WWW\ServiceBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add valorations
     *
     * @param \WWW\ServiceBundle\Entity\Valoration $valorations
     * @return Offer
     */
    public function addValoration(\WWW\ServiceBundle\Entity\Valoration $valorations)
    {
        $this->valorations[] = $valorations;

        return $this;
    }

    /**
     * Remove valorations
     *
     * @param \WWW\ServiceBundle\Entity\Valoration $valorations
     */
    public function removeValoration(\WWW\ServiceBundle\Entity\Valoration $valorations)
    {
        $this->valorations->removeElement($valorations);
    }

    /**
     * Get valorations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getValorations()
    {
        return $this->valorations;
    }
}

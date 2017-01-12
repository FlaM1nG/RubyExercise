<?php

namespace WWW\UserBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\GroupSequenceProviderInterface;
use WWW\GlobalBundle\Entity\Address;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
//use Serializable;

use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\Entity\Photo;
use WWW\GlobalBundle\MyConstants;

/**
 * User
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="WWW\UserBundle\Entity\User")
 * 
 * @Assert\GroupSequenceProvider
 */
class User implements UserInterface, GroupSequenceProviderInterface{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @var int
     */
    private $id;
    
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $surname;

    /**
     * @var string
     * 
     * @Assert\NotBlank(groups = {"email","register"})
     */
    private $username;

    /**
     * @var string
     * 
     * @Assert\NotBlank(message="Por favor rellene este campo", groups = {"register","password"})
     * @Assert\Regex("/^(?=\w*\d)(?=\w*[a-zA-Z])\S{8,}$/",
     *               message="La contraseña debe contener letras y números",
     *               groups = {"register","password"})
     * @Assert\Length(min=8, groups = {"register","password"})
     * 
     */
    private $password;
    
    /**
     * @var string
     * 
     * @Assert\NotBlank(message="Por favor rellene este campo", groups = {"email","password"})
     * @Assert\Regex("/^(?=\w*\d)(?=\w*[a-zA-Z])\S{8,}$/",
     *               message="La contraseña debe contener letras y números",
     *               groups = {"email","password"})
     * @Assert\Length(min=8, groups = {"email","password"})
     * 
     */
    
    private $passwordEnClaro;

    /**
     * @var string
     */
    private $salt;

    /**
     * @var string
     */
    private $sex;

    /**
     * @var \DateTime
     * 
     * @Assert\Date(groups = {"register"})
     * @Assert\NotBlank(groups={"personalData"})
     */
    private $birthdate;

    /**
     * @var string
     * 
     * @Assert\NotBlank(groups = {"email","register"})
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true,
     *     groups = {"email","register"}
     * )
     *
     */
    private $email;

    /**
     * @var string
     */
    private $linkInvitation;

    /**
     * @var integer
     */
    private $invitNum;

    /**
     * @var integer
     * @Assert\NotBlank(groups={"register"})
     */
    private $phone;

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
     * @var \WWW\UserBundle\Entity\Role
     */
    private $role;

     /**
     * @var \WWW\GlobalBundle\Entity\Photo
     */
    private $photo;

    /**
     * @var string
     * @Assert\Length(min=9, max=9, groups = {"register"})
     * @Assert\Regex(
     *     pattern="/(^\d{8}[A-Z]$)|(^[A-Z]\d{8}$)/",
     *     match=false,
     *     message="El formato es X00000000 o 00000000X"
     * )
     * 
     */
    private $nif;
    
     /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $addresses;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $hobbies;
    
    /**
     * @var boolean
     */
    private $smsConfirmed;

    /**
     * @var string
     */
    private $confirmationToken;

    /**
     * @var string
     * @Assert\Length(max=24,groups={"bank"})
     * @Assert\NotBlank(groups={"bank"})
     * @Assert\Iban(message="formato incorrecto",groups={"bank"})
     */
    private $numAccount;

    /**
     * @var boolean
     */
    private $isConfirmed;
    
    /**
     * @var \WWW\UserBundle\Entity\User
     */
    private $hostUser;
    
     /**
     * @var string
     * @Assert\NotBlank(groups="register")
     */
    private $prefix;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $inviteds;    
    
    /**
     * @var boolean
     */
    private $isBanned;    
    
    /**
     * @var \WWW\GlobalBundle\Entity\Address
     */
    private $defaultAddress;    
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $sent;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $received;    
    
    /**
     * @var float
     */
    private $avgScore;

    /**
     * @var integer
     */
    private $valorationNum;

    /**
     * Constructor
     */
    public function __construct(Array $user=null){  
        
        if(!empty($user)):  
            
            $this->birthdate = date_create_from_format('Y-m-d', $user['birthdate']);
            $this->email = $user['email'];
            $this->id = $user['id'];
            $this->linkInvitation = $user['link_invitation'];
            $this->name = $user['name'];
            $this->phone = (int)$user['phone'];
            $this->sex = $user['sex'];
            $this->surname = $user['surname'];
            $this->username = $user['username'];
            $this->password = $user['password'];
            $this->numAccount = $user['num_account'];
            $this->prefix = $user['prefix'];
          //  $this->role = $user['ROLE_USER'];
            $this->offers = $this->searchOffers();
            
            
             if(array_key_exists('addresses', $user)):
                foreach($user['addresses'] as $address):

                  $this->createAddresses($user['addresses'], $user['default_address_id']);
                endforeach;
            endif; 
        else:
           // $this->addresses = new ArrayCollection();
            $this->offers = Array();
        endif;
        
    }
    
    private function createAddresses($arrayAddress, $idDefaultAddress){

        foreach($arrayAddress as $address):
               
            $auxAddress = new Address($address);
        
            if($auxAddress->getId() == $idDefaultAddress):
                $this->defaultAddress = $auxAddress;
            else:
                $this->addresses[] = $auxAddress;
            endif;
            
        endforeach;
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
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     * @return User
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string 
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     * Get passwordEnClaro
     *
     * @return string 
     */
    public function getPasswordEnClaro(){
        return $this->passwordEnClaro;
    }
    
    /**
     * Set password
     *
     * @param string passwordEnClaro
     * @return User
     */
    public function setPasswordEnClaro($passwordEnClaro){
        
        $this->passwordEnClaro = $passwordEnClaro;
        return $this->passwordEnClaro;
        
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set sex
     *
     * @param string $sex
     * @return User
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get sex
     *
     * @return string 
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     * @return User
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime 
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set linkInvitation
     *
     * @param string $linkInvitation
     * @return User
     */             
    public function setLinkInvitation($linkInvitation)
    { 
        $this->linkInvitation = $linkInvitation;

        return $this;
    }

    /**
     * Get linkInvitation
     *
     * @return string 
     */
    public function getLinkInvitation()
    {
        return $this->linkInvitation;
    }

    /**
     * Set invitNum
     *
     * @param integer $invitNum
     * @return User
     */
    public function setInvitNum($invitNum)
    {
        $this->invitNum = $invitNum;

        return $this;
    }

    /**
     * Get invitNum
     *
     * @return integer 
     */
    public function getInvitNum()
    {
        return $this->invitNum;
    }

    /**
     * Set phone
     *
     * @param integer $phone
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return integer 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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
     * Devuelve los roles de un usuario autenticado
     */
    public function getRoles(){
        return array('ROLE_USER');
    }
    
    /**
     * 
     * Elimina la contraseña antes de serializar la información de usuario para guardarla
     */
    public function eraseCredentials(){
        $this->password = null;
    }

    /**
     * Validación para que los usuarios sean mayores de 18
     * 
     * @Assert\True(message = "Debes tener al menos 18 años", groups={"personalData", "register"})
     */
    public function isAdult(){

       return $this->birthdate <= new\DateTime('today - 18 years'); 
    }
    
     public function __sleep()
    {
        return array('id');
    }
    
    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
             $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
             $this->salt
        ) = unserialize($serialized);
    }
    /**
     * Set role
     *
     * @param \WWW\UserBundle\Entity\Role $role
     * @return User
     */
    public function setRole(\WWW\UserBundle\Entity\Role $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \WWW\UserBundle\Entity\Role 
     */
    public function getRole()
    {
        return $this->role;
    }
    
    /**
     * Set nif
     *
     * @param string $nif
     * @return User
     */
    public function setNif($nif)
    {
        $this->nif = $nif;

        return $this;
    }

    /**
     * Get nif
     *
     * @return string
     */
    public function getNif()
    {
        return $this->nif;
    }
    
    /**
     * Set photo
     *
     * @param  $photo
     * @return User
     */
    public function setPhoto( $photo = null)
    {
        if(gettype($photo) == 'array'):
            $this->photo = new Photo($photo);
        elseif(gettype($photo) == 'String'):
            $this->photo = new Photo();
            $this->photo->setUrl($photo);
        else:    
            $this->photo = $photo;
        endif;
        

        return $this;
    }

    /**
     * Get photo
     *
     * @return \WWW\GlobalBundle\Entity\Photo 
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Add addresses
     *
     * @param $addresses
     * @return User
     */
    public function addAddress($addresses)
    {  
        if(gettype($addresses) == 'array'):
            $newAddresses = new Address($addresses);
            $this->addresses[] = $newAddresses;
        else:
            $this->addresses[] = $addresses;
        endif;
        /*$arrayAddresses = $addresses->toArray();
        $this->addresses[$arrayAddresses['id']] = $addresses->toArray();*/

        return $this;
        
        
    }

    /**
     * Remove addresses
     *
     * @param \WWW\GlobalBundle\Entity\Address $addresses
     */
    public function removeAddress(\WWW\GlobalBundle\Entity\Address $addresses)
    {
        $this->addresses->removeElement($addresses);
    }

    /**
     * Get addresses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * Add hobbies
     *
     * @param \WWW\UserBundle\Entity\Hobby $hobbies
     * @return User
     */
    public function addHobby(\WWW\UserBundle\Entity\Hobby $hobbies)
    {
        $this->hobbies[] = $hobbies;

        return $this;
    }

    /**
     * Remove hobbies
     *
     * @param \WWW\UserBundle\Entity\Hobby $hobbies
     */
    public function removeHobby(\WWW\UserBundle\Entity\Hobby $hobbies)
    {
        $this->hobbies->removeElement($hobbies);
    }

    /**
     * Get hobbies
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHobbies()
    {
        return $this->hobbies;
    }
    
    public function deleteAddress($index){
       
        unset($this->addresses[$index]);
        
    }
    
    /**
     * Set prefix
     *
     * @param string $prefix
     * @return User
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Get prefix
     *
     * @return string 
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Set smsConfirmed
     *
     * @param boolean $smsConfirmed
     * @return User
     */
    public function setSmsConfirmed($smsConfirmed)
    {
        $this->smsConfirmed = $smsConfirmed;

        return $this;
    }

    /**
     * Get smsConfirmed
     *
     * @return boolean 
     */
    public function getSmsConfirmed()
    {
        return $this->smsConfirmed;
    }
    



    /**
     * Set confirmationToken
     *
     * @param string $confirmationToken
     * @return User
     */
    public function setConfirmationToken($confirmationToken)
    {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }

    /**
     * Get confirmationToken
     *
     * @return string 
     */
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    /**
     * Set numAccount
     *
     * @param string $numAccount
     * @return User
     */
    public function setNumAccount($numAccount)
    {
        $this->numAccount = $numAccount;

        return $this;
    }

    /**
     * Get numAccount
     *
     * @return string 
     */
    public function getNumAccount()
    {
        return $this->numAccount;
    }

    /**
     * Set isConfirmed
     *
     * @param boolean $isConfirmed
     * @return User
     */
    public function setIsConfirmed($isConfirmed)
    {
        $this->isConfirmed = $isConfirmed;

        return $this;
    }

    /**
     * Get isConfirmed
     *
     * @return boolean 
     */
    public function getIsConfirmed()
    {
        return $this->isConfirmed;
    }

    /**
     * Set hostUser
     *
     * @param \WWW\UserBundle\Entity\User $hostUser
     * @return User
     */
    public function setHostUser(\WWW\UserBundle\Entity\User $hostUser = null)
    {
        $this->hostUser = $hostUser;

        return $this;
    }

    /**
     * Get hostUser
     *
     * @return \WWW\UserBundle\Entity\User 
     */
    public function getHostUser()
    {
        return $this->hostUser;
    }
    


    /**
     * Add inviteds
     *
     * @param \WWW\UserBundle\Entity\User $inviteds
     * @return User
     */
    public function addInvited(\WWW\UserBundle\Entity\User $inviteds)
    {
        $this->inviteds[] = $inviteds;

        return $this;
    }

    /**
     * Remove inviteds
     *
     * @param \WWW\UserBundle\Entity\User $inviteds
     */
    public function removeInvited(\WWW\UserBundle\Entity\User $inviteds)
    {
        $this->inviteds->removeElement($inviteds);
    }

    /**
     * Get inviteds
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInviteds()
    {
        return $this->inviteds;
    }


    /**
     * Set isBanned
     *
     * @param boolean $isBanned
     * @return User
     */
    public function setIsBanned($isBanned)
    {
        $this->isBanned = $isBanned;

        return $this;
    }

    /**
     * Get isBanned
     *
     * @return boolean 
     */
    public function getIsBanned()
    {
        return $this->isBanned;
    }


    /**
     * Set defaultAddress
     *
     * @param \WWW\GlobalBundle\Entity\Address $defaultAddress
     * @return User
     */
    public function setDefaultAddress(\WWW\GlobalBundle\Entity\Address $defaultAddress = null)
    {
        $this->defaultAddress = $defaultAddress;

        return $this;
    }

    /**
     * Get defaultAddress
     *
     * @return \WWW\GlobalBundle\Entity\Address 
     */
    public function getDefaultAddress()
    {
        return $this->defaultAddress;
    }
    
    /**
     * 
     * @param type $index
     * @return Array
     */
    public function getOffers($index = null){
        
       return $this->offers;
        
    }
    
    public function setOffers($offers = null){
        
        $this->offers = $offers;
        
    }
    
    
    private function searchOffers(){
        $file = MyConstants::PATH_APIREST.'services/offer/get_all_user_offers.php';
        $ch = new ApiRest();
        
        $data = array();
        $data['username'] = $this->username;
        $data['id'] = $this->id;
        $data['password'] = $this->password;
        
        $result = $ch->resultApiRed($data, $file);
        
    }
    
   
    /*
     * @return Array de grupos
     */
    public function getGroupSequence()
    {
        $groups = array('User');

        if ($this->isEmail()) {
            
            $groups[] = 'email';
            
        }elseif($this->isRegister()){
            
            $groups[] = "register";
            
        }elseif($this->isPersonalData()){
            
           $groups[] = "personalData";
           
        }
        elseif($this->isPassword()){
            
           $groups[] = "password";
           
        }

        return $groups;
    }
    
    public function getLastAddress(){
        return end($this->getAddresses());
    }    
    /**
     * Add sent
     *
     * @param \WWW\UserBundle\Entity\Message $sent
     * @return User
     */
    public function addSent(\WWW\UserBundle\Entity\Message $sent)
    {
        $this->sent[] = $sent;

        return $this;
    }

    /**
     * Remove sent
     *
     * @param $pos del array
     */
    public function removeSent($pos)
    { echo "****";
        
        unset($this->sent[$pos]);
        
    }
    
    //public function removeMessage(\WWW\UserBundle\Entity\Message $message)

    /**
     * Get sent
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSent()
    {
        return $this->sent;
    }

    /**
     * Add received
     *
     * @param \WWW\UserBundle\Entity\Message $received
     * @return User
     */
    public function addReceived(\WWW\UserBundle\Entity\Message $received)
    {
        $this->received[] = $received;

        return $this;
    }

    /**
     * Remove received
     *
     * @param $pos
     */
    public function removeReceived($pos)
    { echo "RECEIVED";
        unset($this->received[$pos]);
    }

    /**
     * Get received
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReceived()
    {
        return $this->received;
    }

    /**
     * Set avgScore
     *
     * @param float $avgScore
     * @return User
     */
    public function setAvgScore($avgScore)
    {
        $this->avgScore = $avgScore;

        return $this;
    }

    /**
     * Get avgScore
     *
     * @return float 
     */
    public function getAvgScore()
    {
        return $this->avgScore;
    }

    /**
     * Set valorationNum
     *
     * @param integer $valorationNum
     * @return User
     */
    public function setValorationNum($valorationNum)
    {
        $this->valorationNum = $valorationNum;

        return $this;
    }

    /**
     * Get valorationNum
     *
     * @return integer 
     */
    public function getValorationNum()
    {
        return $this->valorationNum;
    }
}

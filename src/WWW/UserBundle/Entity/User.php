<?php

namespace WWW\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

use WWW\GlobalBundle\Entity\Address;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * User
 * 
 */
class User implements UserInterface
{
    /**
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
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @var string
     * 
     * @Assert\NotBlank()
     * @Assert\Regex("/^(?=\w*\d)(?=\w*[a-zA-Z])\S{8,}$/")
     * @Assert\Length(min=8)
     */
    private $password;

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
     * @Assert\Date()
     */
    private $birthdate;

    /**
     * @var string
     * 
     * @Assert\NotBlank()
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
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
     * 
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
            $this->addresses = new \Doctrine\Common\Collections\ArrayCollection();
            
            foreach($user['addresses'] as $address):
               // print_r($address);exit;
                //array_push($this->addAddress, new Address($address));
                $auxAddress = new Address($address);
                $this->addresses[] = $auxAddress->toArray();
            
            endforeach;
            //print_r($this->addAddress);exit;
            //echo gettype($user['addresses']);
            //$this->addresses = $user['addresses'];
        else:
            $this->addresses = new ArrayCollection();
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
        return array('ROLE_USARIO');
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
     * @Assert\True(message = "Debes tener al menos 18 años")
     */
    public function isAdult(){
       return $this->birthdate <= new\DateTime('today - 18 years'); 
    }
    
    public function serialize() {
        
    }

    public function unserialize($serialized) {
        
    }

    

    /**
     * @var \WWW\UserBundle\Entity\Role
     */
    private $role;


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
     * @var string
     */
    private $confirmation_token;

    /**
     * @var boolean
     */
    private $is_confirmed;


    /**
     * Set confirmation_token
     *
     * @param string $confirmationToken
     * @return User
     */
    public function setConfirmationToken($confirmationToken)
    {
        $this->confirmation_token = $confirmationToken;

        return $this;
    }

    /**
     * Get confirmation_token
     *
     * @return string 
     */
    public function getConfirmationToken()
    {
        return $this->confirmation_token;
    }

    /**
     * Set is_confirmed
     *
     * @param boolean $isConfirmed
     * @return User
     */
    public function setIsConfirmed($isConfirmed)
    {
        $this->is_confirmed = $isConfirmed;

        return $this;
    }

    /**
     * Get is_confirmed
     *
     * @return boolean 
     */
    public function getIsConfirmed()
    {
        return $this->is_confirmed;
    }
    /**
     * @var boolean
     */
    private $sms_confirmed;

    /**
     * @var integer
     */
    private $nif;

    /**
     * @var string
     */
    private $num_account;

    /**
     * @var \WWW\UserBundle\Entity\User
     */
    private $host_user;



    /**
     * Set sms_confirmed
     *
     * @param boolean $smsConfirmed
     * @return User
     */
    public function setSmsConfirmed($smsConfirmed)
    {
        $this->sms_confirmed = $smsConfirmed;

        return $this;
    }

    /**
     * Get sms_confirmed
     *
     * @return boolean 
     */
    public function getSmsConfirmed()
    {
        return $this->sms_confirmed;
    }

    /**
     * Set nif
     *
     * @param integer $nif
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
     * @return integer 
     */
    public function getNif()
    {
        return $this->nif;
    }

    /**
     * Set num_account
     *
     * @param string $numAccount
     * @return User
     */
    public function setNumAccount($numAccount)
    {
        $this->num_account = $numAccount;

        return $this;
    }

    /**
     * Get num_account
     *
     * @return string 
     */
    public function getNumAccount()
    {
        return $this->num_account;
    }

    /**
     * Set host_user
     *
     * @param \WWW\UserBundle\Entity\User $hostUser
     * @return User
     */
    public function setHostUser(\WWW\UserBundle\Entity\User $hostUser = null)
    {
        $this->host_user = $hostUser;

        return $this;
    }

    /**
     * Get host_user
     *
     * @return \WWW\UserBundle\Entity\User 
     */
    public function getHostUser()
    {
        return $this->host_user;
    }

 
    /**
     * @var \WWW\GlobalBundle\Entity\Photo
     */
    private $photo;


    /**
     * Set photo
     *
     * @param \WWW\GlobalBundle\Entity\Photo $photo
     * @return User
     */
    public function setPhoto(\WWW\GlobalBundle\Entity\Photo $photo = null)
    {
        $this->photo = $photo;

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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $addresses;


    /**
     * Add addresses
     *
     * @param \WWW\GlobalBundle\Entity\Address $addresses
     * @return User
     */
    public function addAddress(\WWW\GlobalBundle\Entity\Address $addresses)
    {
        $this->addresses[] = $addresses->toArray();

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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $hobbies;


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
}

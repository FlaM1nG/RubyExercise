<?php

namespace WWW\GlobalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * *
 * @ORM\Table(name="mycompanyevents")
 * @ORM\Entity
 */
class MyCompanyEvents implements  \Serializable {
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
     
    protected $id;

        /**
     * @var int
     *
     * @ORM\Column(name="calendarID", type="integer")
     */
     
    protected $calendarID;
    
    
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    
     protected $title;
    
     
   /**
    * @ORM\Column(type="decimal", precision=10, scale=0)
    */
    
     protected $price;
     
     
         /**
     * @var boolean 
     * @ORM\Column(type="boolean")
     */
    protected $ocuppate = false;



    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    protected $blocked = false;
    
    /**
     * @var string URL Relative to current path.
     * 
     * @ORM\Column(type="string", length=255)
     * 
     */
    protected $url;
    
    /**
     * @var string HTML color code for the bg color of the event label.
     * @ORM\Column(type="string", length=7)
     */
    protected $bgColor;
    
    /**
     * @var string HTML color code for the foregorund color of the event label.
     * @ORM\Column(type="string", length=7)
     */
    protected $fgColor;
        
    /**
     * @var \DateTime DateTime object of the event start date/time.
     * @ORM\Column(type="datetime")
     */
    protected $startDatetime;
    
    /**
     * @var \DateTime DateTime object of the event end date/time.
     * @ORM\Column(type="datetime")
     */
    protected $endDatetime;
    
    
    /**
     * @var \DateTime DateTime object of the event created.
     * @ORM\Column(type="datetime")
     */
    protected $createdDate;
   
     /**
     * @var \DateTime DateTime object of the event modified.
     * @ORM\Column(type="datetime")
     */
    protected $modifiedDate;
    
     /**
     * @var \DateTime DateTime object of the event deleted.
     * @ORM\Column(type="datetime")
     */
    protected $deletedDate;
    
      /**
    * @var boolean Is this an event deleted?
     * @ORM\Column(type="boolean")
     */
    protected $isDeleted;
    
    /**
     * @var boolean Is this an all day event?
     * @ORM\Column(type="boolean")
     */
    protected $allDay = false;
    /**
     * @var array Non-standard fields
     * @ORM\Column(type="string")
     */
    
       /**
     * @var int
     *
     * @ORM\Column(name="serviceID", type="integer")
     */
     
    protected $serviceID;
    
    
    
//    protected $otherFields = array();
    
      public function __construct($id,$title, $price,$calendarID, $serviceID,$bgColor, $fgColor, \DateTime $startDatetime, \DateTime $endDatetime = null, $ocuppate = false, $blocked = false, $allDay = false)
    {

        $this->id = $id;
        $this->title = $title;
         $this->price = $price;
        $this->calendarID = $calendarID;
        $this->serviceID = $serviceID;
         $this->bgColor = $bgColor;
         $this->fgColor = $fgColor;
        $this->startDatetime = $startDatetime;
        $this->setOcuppate($ocuppate);
        $this->setBlocked($blocked);
        $this->setAllDay($allDay);
        
        if ($endDatetime === null && $this->allDay === false) {
            throw new \InvalidArgumentException("Must specify an event End DateTime if not an all day event.");
        }
        
        $this->endDatetime = $endDatetime;
    }
    /**
     * Convert calendar event details to an array
     * 
     * @return array $event 
     */
    public function toArray()
    {
        $event = array();
        
        if ($this->id !== null) {
            $event['id'] = $this->id;
        }
        
        if ($this->calendarID !== null) {
            $event['calendar_id'] = $this->calendarID;
        }
        
        $event['title'] = $this->title;
        $event['price'] = $this->price;
        
        $event['ocuppate'] = $this->ocuppate;

        $event['blocked'] = $this->blocked;
        
        $event['start'] = $this->startDatetime->format("Y-m-d\TH:i:sP");
        
        if ($this->url !== null) {
            $event['url'] = $this->url;
        }
        
        if ($this->bgColor !== null) {
            $event['backgroundColor'] = $this->bgColor;
            $event['borderColor'] = $this->bgColor;
        }
        
        if ($this->fgColor !== null) {
            $event['textColor'] = $this->fgColor;
        }
        
        
        if ($this->endDatetime !== null) {
            $event['end'] = $this->endDatetime->format("Y-m-d\TH:i:sP");
        }
        
         if ($this->createdDate !== null) {
            $event['createdDate'] = $this->createdDate->format("Y-m-d\TH:i:sP");
        }
        
          if ($this->modifiedDate !== null) {
            $event['modifiedDate'] = $this->modifiedDate->format("Y-m-d\TH:i:sP");
        }
        
        if ($this->deletedDate !== null) {
            $event['deletedDate'] = $this->deletedDate->format("Y-m-d\TH:i:sP");
        }
        
         $event['isDeleted'] = $this->isDeleted;
        
        $event['allDay'] = $this->allDay;
//        foreach ($this->otherFields as $field => $value) {
//            $event[$field] = $value;
//        }
        
        if ($this->serviceID !== null) {
            $event['service_id'] = $this->serviceID;
        }
        
        
        return $event;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
     public function setCalendarID($calendarID)
    {
        $this->calendarID = $calendarID;
    }
    
    public function getCalendarID()
    {
        return $this->calendarID;
    }
    
    
    public function setTitle($title) 
    {
        $this->title = $title;
    }
    
    public function getTitle() 
    {
        return $this->title;
    }
    
     public function setPrice($price) 
    {
        $this->price = $price;
    }
    
     public function getPrice() 
    {
        return $this->price;
    }
    
      public function setOcuppate($ocuppate)
    {
        $this->ocuppate = (boolean) $ocuppate;
    }
    
    public function getOcuppate()
    {
        return $this->ocuppate;
    }

    public function setBlocked($blocked)
    {
        $this->blocked = (boolean) $blocked;
    }

    public function getBlocked()
    {
        return $this->blocked;
    }
    
    public function setUrl($url)
    {
        $this->url = $url;
    }
    
    public function getUrl()
    {
        return $this->url;
    }
    
    public function setBgColor($color)
    {
        $this->bgColor = $color;
    }
    
    public function getBgColor()
    {
        return $this->bgColor;
    }
    
    public function setFgColor($color)
    {
        $this->fgColor = $color;
    }
    
    public function getFgColor()
    {
        return $this->fgColor;
    }
      
    
    public function setStartDatetime(\DateTime $start)
    {
        $this->startDatetime = $start;
    }
    
    public function getStartDatetime()
    {
        return $this->startDatetime;
    }
    
    public function setEndDatetime(\DateTime $end)
    {
        $this->endDatetime = $end;
    }
    
    public function getEndDatetime()
    {
        return $this->endDatetime;
    }
    
      public function setCreatedDate(\DateTime $createdDate)
    {
        $this->createdDate = $createdDate;
    }
    
    public function getCreatedDate()
    {
        return $this->createdDate;
    }
    
      public function setModifiedDate(\DateTime $modifiedDate)
    {
        $this->modifiedDate = $modifiedDate;
    }
    
    public function getModifiedDate()
    {
        return $this->modifiedDate;
    }
    
      public function setDeletedDate(\DateTime $deletedDate)
    {
        $this->deletedDate = $deletedDate;
    }
    
    public function getDeletedDate()
    {
        return $this->deletedDate;
    }
    
     public function setIsDeleted($isDeleted = false)
    {
        $this->isDeleted = (boolean) $isDeleted;
    }
    
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }
    
    public function setAllDay($allDay = false)
    {
        $this->allDay = (boolean) $allDay;
    }
    
    public function getAllDay()
    {
        return $this->allDay;
    }
    
      public function setServiceID($serviceID)
    {
        $this->serviceID = $serviceID;
    }
    
    public function getServiceID()
    {
        return $this->serviceID;
    }
    
    
    
    /**
     * @param string $name
     * @param string $value
     */
//    public function addField($name, $value)
//    {
//        $this->otherFields[$name] = $value;
//    }
//    /**
//     * @param string $name
//     */
//    public function removeField($name)
//    {
//        if (!array_key_exists($name, $this->otherFields)) {
//            return;
//        }
//        unset($this->otherFields[$name]);
//    }
    /**
     * @var \WWW\GlobalBundle\Entity\Calendar
     */
    private $calendar;

    /**
     * @var \WWW\ServiceBundle\Entity\Service
     */
    private $service;



//    public function setOtherFields($otherFields)
//    {
//        $this->otherFields = $otherFields;
//
//        return $this;
//    }

    /**
     * Get otherFields
     *
     * @return string 
     */
//    public function getOtherFields()
//    {
//        return $this->otherFields;
//    }

    /**
     * Set calendar
     *
     * @param \WWW\GlobalBundle\Entity\Calendar $calendar
     * @return MyCompanyEvents
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
     * Set service
     *
     * @param \WWW\ServiceBundle\Entity\Service $service
     * @return MyCompanyEvents
     */
    public function setService(\WWW\ServiceBundle\Entity\Service $service = null)
    {
        $this->service = $service;

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

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->calendarID,
            $this->title,
            $this->price,
            $this->url,
            $this->bgColor,
            $this->fgColor,
            $this->allDay,
            $this->serviceID,
            $this->blocked,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->calendarID,
            $this->title,
            $this->price,
            $this->url,
            $this->bgColor,
            $this->fgColor,
            $this->allDay,
            $this->serviceID,
            $this->blocked,
            ) = unserialize($serialized);
    }
}

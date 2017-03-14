<?php

// src/Acme/DemoBundle/EventListener/CalendarEventListener.php  

namespace WWW\GlobalBundle\EventListener;

use WWW\GlobalBundle\Event\CalendarEvent;
use WWW\GlobalBundle\Entity\MyCompanyEvents;
use Doctrine\ORM\EntityManager;

class CalendarEventListener
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function loadEvents(CalendarEvent $calendarEvent)
    {
        $startDate = $calendarEvent->getStartDatetime();
        $endDate = $calendarEvent->getEndDatetime();

        // The original request so you can get filters from the calendar
        // Use the filter in your query for example

        $request = $calendarEvent->getRequest();
        $filter = $request->get('filter');


        // load events using your custom logic here,
        // for instance, retrieving events from a repository





#}       $companyEvents = $this->entityManager->createQueryBuilder()

#}          ->select('u')

#}        ->from('GlobalBundle:MyCompanyEvents', 'u')

#}          ->where('u.calendarID = :calendarID')

#}          ->setParameter(':calendarID', 1)

#}          ->getQuery()->getResult();

        $query = $this->entityManager->createQueryBuilder()
                      ->select('sh','h')
                     ->from('HouseBundle:ShareHouse', 'sh')
                     ->innerJoin('sh.house','h')
                     ->where('sh.offer = :idOffer')
                     ->setParameter(':idOffer', $request->get('idOffer'))
                     ->getQuery()->getArrayResult();

        $houseId = $query[0]['house']['id'];
       

        $queryHouseC = $this->entityManager->createQueryBuilder()
                                           ->select('h','c')
                                            ->from('HouseBundle:house','h')
                                            ->innerJoin('h.calendar','c')
                                            ->where('h.id = :idHouse')
                                            ->setParameter(':idHouse',$houseId)
                                            ->getQuery()->getArrayResult();

        $calendarId = $queryHouseC[0]['calendar']['id'];

        $companyEvents = $this->entityManager->createQueryBuilder()

            ->select('u')

            ->from('GlobalBundle:MyCompanyEvents', 'u')

            ->where('u.calendarID = :calendarID')

            ->setParameter(':calendarID', 9)

            ->getQuery()->getResult();

//        \Doctrine\Common\Util\Debug::dump($companyEvents);

        // $companyEvents and $companyEvent in this example
        // represent entities from your database, NOT instances of EventEntity
        // within this bundle.
        //
        // Create EventEntity instances and populate it's properties with data
        // from your own entities/database values.

        foreach($companyEvents as $companyEvent) {
//print_r($companyEvent);
            // create an event with a start/end time, or an all day event
            if ($companyEvent->getAllDay() === false) {
                $eventEntity = new MyCompanyEvents($companyEvent->getTitle(),$companyEvent->getPrice(), $companyEvent->getBgColor(), $companyEvent->getFgColor(),  $companyEvent->getStartDatetime(), null,true, true);
            } else {
                $eventEntity = new MyCompanyEvents($companyEvent->getTitle(),$companyEvent->getPrice(), $companyEvent->getBgColor(), $companyEvent->getFgColor(), $companyEvent->getStartDatetime(), null,true, true);
            }
            $calendarEvent->addEvent($eventEntity);
            //optional calendar event settings
        //    $eventEntity->setAllDay(false); // default is false, set to true if this is an all day event
        //      $eventEntity->setBgColor('#FF0000'); //set the background color of the event's label
              
        //  $eventEntity->setFgColor('#FF0000'); //set the foreground color of the event's label
        //    $eventEntity->setUrl('http://www.google.com'); // url to send user to when event label is clicked
         //   $eventEntity->setCssClass('my-custom-class'); // a custom class you may want to apply to event labels
            

            //finally, add the event to the CalendarEvent for displaying on the calendar

        }
    }
}

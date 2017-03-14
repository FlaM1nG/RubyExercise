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
        // The original request so you can get filters from the calendar
        // Use the filter in your query for example

        $request = $calendarEvent->getRequest();
        $filter = $request->get('filter');


        // load events using your custom logic here,
        // for instance, retrieving events from a repository

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

            ->setParameter(':calendarID', $calendarId)

            ->getQuery()->getResult();


        foreach($companyEvents as $companyEvent) {

            // create an event with a start/end time, or an all day event
            if ($companyEvent->getAllDay() === false) {
                $eventEntity = new MyCompanyEvents($companyEvent->getTitle(),$companyEvent->getPrice(), $companyEvent->getBgColor(), $companyEvent->getFgColor(),  $companyEvent->getStartDatetime(), $companyEvent->getEndDatetime(),true, true);
            } else {
                $eventEntity = new MyCompanyEvents($companyEvent->getTitle(),$companyEvent->getPrice(), $companyEvent->getBgColor(), $companyEvent->getFgColor(), $companyEvent->getStartDatetime(), $companyEvent->getEndDatetime(),true, true);
            }
            $calendarEvent->addEvent($eventEntity);


        }
    }
}

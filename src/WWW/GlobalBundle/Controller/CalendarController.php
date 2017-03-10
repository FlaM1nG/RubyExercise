<?php

namespace WWW\GlobalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WWW\GlobalBundle\Event\CalendarEvent;




class CalendarController extends Controller
{
    /**
     * Dispatch a CalendarEvent and return a JSON Response of any events returned.
     * 
     * @param Request $request
     * @return Response
     */

    public function loadCalendarAction(Request $request)
    {
        
        $startDatetime = \DateTime::createFromFormat('Y-m-d',$request->get('start'));
        
        $endDatetime = \DateTime::createFromFormat('Y-m-d',$request->get('end'));
        
        $events = $this->container->get('event_dispatcher')->dispatch(CalendarEvent::CONFIGURE, new CalendarEvent($startDatetime, $endDatetime, $request))->getEvents();
        
        $response = new \Symfony\Component\HttpFoundation\Response();
        $response->headers->set('Content-Type', 'application/json');
        
        $return_events = array();
        
        foreach($events as $event) {
            $return_events[] = $event->toArray();    
        }
        
        $response->setContent(json_encode($return_events));
        
        return $response;
    }



    public function deleteEventAction()
    {


        if (isset($_POST['delete']) && isset($_POST['id'])) {



            $id = $_POST['id'];

            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('GlobalBundle:MyCompanyEvents')->findOneBy(array('id' => $id));

            if ($entity != null) {
                $em->remove($entity);
                $em->flush();
            }

        }


        $response = new \Symfony\Component\HttpFoundation\Response();
        $response->headers->set('Content-Type', 'application/json');
            $response->setContent(json_encode($em));

            return $response;

    }
    
}
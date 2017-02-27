<?php

namespace WWW\GlobalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WWW\GlobalBundle\Event\CalendarEvent;
use WWW\GlobalBundle\Entity\MyCompanyEvents;

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
    
    
    public function updateDataAction(){
        $request = Request::createFromGlobals();
            if ($request->getMethod() == "GET") {
                    $data1 = new DateTime($request->query->get('end'));
                    $data2 = new DateTime($request->query->get('start'));
        // here i have DateTime in above code that is to create object of date from string.
                    $ename=$request->query->get('ename');
                    $db = new MyCompanyEvents();
                    $db->setStartDatetime($data2);
                    $db->setEndDatetime($data1);
                    $db->setTitle($ename);
                    $em = $this->getDoctrine()->getEntityManager();
                    $em->persist($db);
                    $em->flush();
                    $response = array("success" => true);
            }
                else{
                $response = array( "success" => false);
                }
//you can return result as JSON
return new Response(json_encode($response));
    
    
    }
    
    
}
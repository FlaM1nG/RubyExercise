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

        $startDatetime = \DateTime::createFromFormat('Y-m-d', $request->get('start'));

        $endDatetime = \DateTime::createFromFormat('Y-m-d', $request->get('end'));

        $events = $this->container->get('event_dispatcher')->dispatch(CalendarEvent::CONFIGURE, new CalendarEvent($startDatetime, $endDatetime, $request))->getEvents();

        $response = new \Symfony\Component\HttpFoundation\Response();
        $response->headers->set('Content-Type', 'application/json');

        $return_events = array();

        foreach ($events as $event) {
            $return_events[] = $event->toArray();
        }

        $response->setContent(json_encode($return_events));

        return $response;
    }


    public function editEventAction($id, $title, $price, $serviceID) {


        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('GlobalBundle:MyCompanyEvents')->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $product->setTitle($title);
        $product->setPrice($price);
        $product->setServiceID($serviceID);

        $em->flush();

        return $this->redirect($this->generateUrl('homepage'));
    }


}
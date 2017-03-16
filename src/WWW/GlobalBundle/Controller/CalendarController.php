<?php

namespace WWW\GlobalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WWW\GlobalBundle\Event\CalendarEvent;
use WWW\GlobalBundle\Entity\MyCompanyEvents;
use WWW\HouseBundle\Entity\ShareHouse;





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


    public function createEventAction(Request $request)
    {


        $em = $this->getDoctrine()->getManager();
        $dateNow = new \DateTime('now');
        $dateEnd = new \DateTime('now');
        $dateEnd->add(new \DateInterval('P10Y'));

        $mce = new MyCompanyEvents('€', $request->get('price'), $request->get('calendar_id'), $request->get('service_id'), '#008000', '#fff', $dateNow, $dateEnd, null, null);
        // $mce->setServiceID(6);
        // $mce->setCalendarID(11);
        // $mce->setUrl("pruebatonta");

        $em->persist($mce);

        $em->flush();


        return $this->redirectToRoute('user_profiler_offers');
    }


    public function editEventAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $test = $em->getRepository('GlobalBundle:MyCompanyEvents')->find($request->get('id'));

        if (!$test) {
            throw $this->createNotFoundException(
                'No hay datos para el id ' . $request->get('id')
            );
        }

        $test->setPrice($request->get('price'));
        $em->flush();

        return $this->redirectToRoute('user_profiler_offers');

    }

    public function cargarDateAction()
    {


        $json = file_get_contents(dirname(__FILE__) . '\precios.json');

        $input_arrays = json_decode($json, true);

        $response = new \Symfony\Component\HttpFoundation\Response();
        $response->headers->set('Content-Type', 'application/json');


        if (!empty($input_arrays[0])) {

            if (!empty($input_arrays[0]['start_datetime']) && !empty($input_arrays[0]['end_datetime']) && !empty($input_arrays[0]['price'])) {

                // We get the start date
                $timestampIni = strtotime($input_arrays[0]['start_datetime']);
                $initDate = date("d", $timestampIni);

                // We get the end date
                $timestampEnd = strtotime($input_arrays[0]['end_datetime']);
                $endDate = date("d", $timestampEnd);

                // We create an array with the list of days and prices
                $result = array();
                for ($i = $initDate; $i <= $endDate; $i++) {
                    $result[$i] = $input_arrays[0]['price'] . '€';
                }

                $response->setContent(json_encode($result));
            }

            return $response;
        }
    }

}
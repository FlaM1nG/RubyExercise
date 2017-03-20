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

    public function cargarDateAction(Request $request)
    {

        $idoffer = $request->get('idOffer');

        $em = $this->getDoctrine()->getEntityManager();
        $db = $em->getConnection();

        $query = "select sh.house_id, my.price,h.calendar_id,my.start_datetime, my.end_datetime from share_house as sh inner join house as h on h.id=sh.house_id inner join my_company_events as my on h.calendar_id = my.calendar_id WHERE sh.offer_id=$idoffer";

        $stmt = $db->prepare($query);
        $params = array();
        $stmt->execute($params);
        $input_arrays = $stmt->fetchAll();




        //select house_id.share_house, id.house from share_house INNER JOIN house ON share_house.house_id=house.id
    
        $response = new \Symfony\Component\HttpFoundation\Response();
        $response->headers->set('Content-Type', 'application/json');


        // precios
      // $json = file_get_contents(dirname(__FILE__) . '/precios.json');

// Aquí pondremos todos los meses del año
        $result = array('0' => array(), '1' => array(), '2' => array(), '3' => array(), '4' => array());

//        $input_arrays = json_decode($json, true);
//echo "<pre>"; die(print_r($result));
        if (!empty($input_arrays)) {

            foreach ($input_arrays as $key => $value) {

                if (!empty($value['start_datetime']) && !empty($value['end_datetime']) && !empty($value['price'])) {

                    // We get the start date
                    $timestampIni = strtotime($value['start_datetime']);
                    $initDay = date("d", $timestampIni);
                    $initMonth = intval(date("m", $timestampIni)); // intval: Obtiene el valor entero de una variable

                    // We get the end date
                    $timestampEnd = strtotime($value['end_datetime']);
                    $endDay = date("d", $timestampEnd);
                    $endMonth = intval(date("m", $timestampEnd));

                    for ($i = $initDay; $i <= $endDay; $i++) { // Moving between days
                        //echo ($initMonth . ' == ' . $endMonth) . '<br>';
                        if ($initMonth == '0' || $endMonth == '0') {
                            $result['0'][$i] = $value['price'] . '€';
                        } else if ($initMonth == '1' || $endMonth == '1') {
                            $result['1'][$i] = $value['price'] . '€';
                        } else if ($initMonth == '2' || $endMonth == '2') {
                            $result['2'][$i] = $value['price'] . '€';
                        } else if ($initMonth == '3' || $endMonth == '3') {
                            $result['3'][$i] = $value['price'] . '€';
                        } else if ($initMonth == '4' || $endMonth == '4') {
                            $result['4'][$i] = $value['price'] . '€';
                        }
                    }
                }
            }

            // To remove empty months
            foreach($result as $key => $month)
            {
                if (empty($month)) {
                    unset($result[$key]);
                }
            }

            //echo "<pre>"; die(print_r($result));

            $response->setContent(json_encode($result));;
        }



        return $response;

    }




}

/***
 *
 *
 *
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
 *
 *
 *
 *       $em = $this->getDoctrine()->getEntityManager();
$db = $em->getConnection();


$response = new \Symfony\Component\HttpFoundation\Response();
$response->headers->set('Content-Type', 'application/json');

$query = "SELECT start_datetime,price,title,end_datetime FROM my_company_events";
$stmt = $db->prepare($query);
$params = array();
$stmt->execute($params);
$po = $stmt->fetchAll();


$response->setContent(json_encode($po));

return $response;

 *
 *
 *
 *
 *
 */
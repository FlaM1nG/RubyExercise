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
    
    public function editcreateEventAction(Request $request)
    {

        $em = $this->getDoctrine()->getEntityManager();
        $db = $em->getConnection();

        $repository = $this->getDoctrine()->getRepository('GlobalBundle:MyCompanyEvents');

        $date= new \DateTime ($_POST['start']);

        // query for a single product matching the given name and price
        $test = $repository->findOneBy(
            array('calendarID' => $_POST['calendar_id'], 'serviceID' => $_POST['service_id'], 'startDatetime' => $date
            ));


        if (!$test) {

            $dateEnd = $date;

            $mce = new MyCompanyEvents('','€', $request->get('price'), $request->get('calendar_id'), $request->get('service_id'), '#fff' , '#368d3a', $date, $dateEnd, '0' , null);

            $em->persist($mce);

            $em->flush();

            }else{

                    $test->setPrice($request->get('price'));
                    $em->flush();

            }

        return $this->redirectToRoute('user_profiler_offers');
    }


    public function cargarDateAction(Request $request)
    {

        function createDateRangeBase($startDate, $endDate, $price, $ocuppate, $format = "d-m-Y")
        {
            $begin = new \DateTime($startDate);
            $end = new \DateTime($endDate);
            $end->modify('+1 day');

            $interval = new \DateInterval('P1D'); // 1 Day
            $dateRange = new \DatePeriod($begin, $interval, $end);
            //echo "<pre>"; die(print_r($dateRange));
            $range = array();
            foreach ($dateRange as $key => $date) {
                $range[$key]['start_datetime'] = date_format($date, $format);
                $range[$key]['end_datetime'] = date_format($date, $format);
                if (!$ocuppate) {
                    $range[$key]['ocuppate'] = $ocuppate;
                } else {
                    $range[$key]['ocuppate'] = 1;
                }

                $range[$key]['price'] = $price;

            }

            return $range;
        }

        $idoffer = $request->get('idOffer');


        $em = $this->getDoctrine()->getEntityManager();
        $db = $em->getConnection();

        $query =  "select sh.house_id, sh.price as precio_base,my.price,h.calendar_id,my.start_datetime, my.end_datetime,my.ocuppate,my.title,off.service_id,my.service_id from share_house as sh inner join house as h on h.id=sh.house_id inner join my_company_events as my on h.calendar_id = my.calendar_id inner join offer as off on off.service_id = my.service_id and off.id = sh.offer_id WHERE sh.offer_id=$idoffer and off.service_id = my.service_id";

        $stmt = $db->prepare($query);
        $params = array();
        $stmt->execute($params);
        $aEspecificos  = $stmt->fetchAll();

        $response = new \Symfony\Component\HttpFoundation\Response();
        $response->headers->set('Content-Type', 'application/json');


        $resultEspecificos = array();
        if (!empty($aEspecificos)) {
            //echo "<pre>"; die(print_r($input_arrays));
            foreach ($aEspecificos as $key => $value) {

                if (!empty($value['start_datetime']) && !empty($value['end_datetime'])) {
                    $resultEspecificos[] = createDateRangeBase($value['start_datetime'], $value['end_datetime'], $value['price'], $value['ocuppate']);
                }
            }
        }

        $sql =  "select sh.house_id, sh.price as precio_base,my.price,h.calendar_id,my.start_datetime, my.end_datetime,my.ocuppate,my.title,off.service_id,my.service_id from share_house as sh inner join house as h on h.id=sh.house_id inner join my_company_events as my on h.calendar_id = my.calendar_id inner join offer as off on off.service_id = my.service_id and off.id = sh.offer_id WHERE sh.offer_id=$idoffer and off.service_id = my.service_id";

        $stmt = $db->prepare($sql);
        $params = array();
        $stmt->execute($params);
        $aEspecificos  = $stmt->fetchAll();

        if (!empty($aEspecificos)) {
            foreach ($aEspecificos as $key => $value) {

                if (!empty($value['precio_base'])) {
                    $aEspecificos['precio_base'] = $value['precio_base'];
                    $aEspecificos['ocuppate'] = $value['ocuppate'];

                }
            }
        }

// PRECIOS BASE. Por ejemplo: 10€
        $aBase = createDateRangeBase('2017-01-01', '2017-12-31', $aEspecificos['precio_base'], $aEspecificos['ocuppate']);

        if (!empty($resultEspecificos) && !empty($aBase)) {
            foreach ($aBase as $key => $value) {
                foreach ($resultEspecificos as $key2 => $value2) {
                    foreach ($value2 as $key3 => $value3) {
                        if ($value['start_datetime'] == $value3['start_datetime']) {
                            $aBase[$key]['price'] = $value3['price'];
                            $aBase[$key]['ocuppate'] = $value3['ocuppate'];
                        }
                    }
                }
            }
        }


// Aquí pondremos todos los meses del año
        $result = array('1' => array(), '2' => array(), '3' => array(), '4' => array(), '5' => array(),'6' => array(),'7' => array(),'8' => array(),'9' => array(),'10' => array(),'11' => array(),'12' => array());

        if (!empty($aBase)) {

            foreach ($aBase as $key => $value) {

                $timestampIni = strtotime($value['start_datetime']);
                (int)$initDay = date("d", $timestampIni);
                $initMonth = intval(date("m", $timestampIni)); // intval: Obtiene el valor entero de una variable

                // We get the end date
                $timestampEnd = strtotime($value['end_datetime']);
                (int)$endDay = date("d", $timestampEnd);
                $endMonth = intval(date("m", $timestampEnd));


                for ($i = (int)$initDay; $i <= (int)$endDay; $i++) { // Moving between days

                        if ($initMonth == '1' || $endMonth == '1') {
                            $result['1']['precio'][$i] = $value['price'] . '€';
                            $result['1']['ocuppate'][$i] = $value['ocuppate'];
                        } else if ($initMonth == '2' || $endMonth == '2') {
                            $result['2']['precio'][$i] = $value['price'] . '€';
                            $result['2']['ocuppate'][$i] = $value['ocuppate'];
                        } else if ($initMonth == '3' || $endMonth == '3') {
                            $result['3']['precio'][$i] = $value['price'] . '€';
                            $result['3']['ocuppate'][$i] = $value['ocuppate'];

                        } else if ($initMonth == '4' || $endMonth == '4') {
                            $result['4']['precio'][$i] = $value['price'] . '€';
                            $result['4']['ocuppate'][$i] = $value['ocuppate'];

                        } else if ($initMonth == '5' || $endMonth == '5') {
                            $result['5']['precio'][$i] = $value['price'] . '€';
                            $result['5']['ocuppate'][$i] = $value['ocuppate'];
                        } else if ($initMonth == '6' || $endMonth == '6') {
                            $result['6']['precio'][$i] = $value['price'] . '€';
                            $result['6']['ocuppate'][$i] = $value['ocuppate'];
                        } else if ($initMonth == '7' || $endMonth == '7') {
                            $result['7']['precio'][$i] = $value['price'] . '€';
                            $result['7']['ocuppate'][$i] = $value['ocuppate'];
                        } else if ($initMonth == '8' || $endMonth == '8') {
                            $result['8']['precio'][$i] = $value['price'] . '€';
                            $result['8']['ocuppate'][$i] = $value['ocuppate'];
                        } else if ($initMonth == '9' || $endMonth == '9') {
                            $result['9']['precio'][$i] = $value['price'] . '€';
                            $result['9']['ocuppate'][$i] = $value['ocuppate'];
                        } else if ($initMonth == '10' || $endMonth == '10') {
                            $result['10']['precio'][$i] = $value['price'] . '€';
                            $result['10']['ocuppate'][$i] = $value['ocuppate'];
                        } else if ($initMonth == '11' || $endMonth == '11'){
                            $result['11']['precio'][$i] = $value['price'] . '€';
                            $result['11']['ocuppate'][$i] = $value['ocuppate'];

                        }else if ($initMonth == '12' || $endMonth == '12'){
                            $result['12']['precio'][$i] = $value['price'] . '€';
                            $result['12']['ocuppate'][$i] = $value['ocuppate'];

                        }

                    }
                }
         //   }

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

    public function cargarPriceAction(Request $request)
    {

        /**
         * Returns every date between two dates as an array
         * @param string $startDate the start of the date range
         * @param string $endDate the end of the date range
         * @param string $format DateTime format, default is Y-m-d
         * @return array returns every date between $startDate and $endDate, formatted as "d-m-Y"
         */

        function createDateRange($startDate, $endDate, $price, $format = "d-m-Y")
        {
            $begin = new \DateTime($startDate);
            $end = new \DateTime($endDate);
            $end->modify('+1 day');

            $interval = new \DateInterval('P1D'); // 1 Day
            $dateRange = new \DatePeriod($begin, $interval, $end);
            //echo "<pre>"; die(print_r($dateRange));
            $range = array();
            foreach ($dateRange as $key => $date) {
                //$range[$key]['fecha'] = $date->format($format);
                //$range[$key]['price'] = $price;
                $range[date_format($date, $format)] = $price;
            }

            return $range;
        }

        $offerID = $request->get('idOffer');

        $em = $this->getDoctrine()->getEntityManager();
        $db = $em->getConnection();

        $sql =  "select sh.house_id, sh.price as precio_base,my.price,h.calendar_id,my.start_datetime, my.end_datetime,my.ocuppate,my.title,off.service_id,my.service_id from share_house as sh inner join house as h on h.id=sh.house_id inner join my_company_events as my on h.calendar_id = my.calendar_id inner join offer as off on off.service_id = my.service_id and off.id = sh.offer_id WHERE sh.offer_id=$offerID and off.service_id = my.service_id";


        $stmt = $db->prepare($sql);
        $params = array();
        $stmt->execute($params);
        $aEspecificos  = $stmt->fetchAll();

        if (!empty($aEspecificos)) {
            foreach ($aEspecificos as $key => $value) {

                if (!empty($value['precio_base'])) {
                    $aEspecificos['precio_base'] = $value['precio_base'];


                }
            }
        }


        $response = new \Symfony\Component\HttpFoundation\Response();
        $response->headers->set('Content-Type', 'application/json');
        // precios
        $idoffer = $request->get('idOffer');


        $em = $this->getDoctrine()->getEntityManager();
        $db = $em->getConnection();

        $query =  "select sh.house_id, my.price,h.calendar_id,my.start_datetime, my.end_datetime,my.ocuppate,my.title,off.service_id,my.service_id from share_house as sh inner join house as h on h.id=sh.house_id inner join my_company_events as my on h.calendar_id = my.calendar_id inner join offer as off on off.service_id = my.service_id and off.id = sh.offer_id WHERE sh.offer_id=$idoffer and off.service_id = my.service_id";

        $stmt = $db->prepare($query);
        $params = array();
        $stmt->execute($params);
        $fechas = $stmt->fetchAll();
        //echo "<pre>"; die(print_r($fechas));

        // List of dates and base prices
        $aBase = createDateRange('2017-01-01', '2017-12-31', $aEspecificos['precio_base']);

        $result = array('1' => array(), '2' => array(), '3' => array(), '4' => array(), '5' => array(),'6' => array(),'7' => array(),'8' => array(),'9' => array(),'10' => array(),'11' => array(),'12' => array());

        if (!empty($fechas)) {
            //echo "<pre>"; die(print_r($input_arrays));
            foreach ($fechas as $key => $value) {

                if (!empty($value['start_datetime']) && !empty($value['end_datetime'])) {
                    $result[] = createDateRange($value['start_datetime'], $value['end_datetime'], $value['price']);
                }
            }
        }
        //echo "<pre>"; die(print_r($result));

        // We merge the base prices with the specific ones
        if (!empty($aBase) && !empty($result)) {
            foreach ($aBase as $key => $value) {
                foreach ($result as $key2 => $value2) {
                    foreach ($value2 as $key3 => $value3) {

                        if ($key == $key3) {
                            $aBase[$key] = $value3;
                        }
                    }
                }
            }
        }


        $totalPrice = '0';

        //echo "<pre>"; die(print_r($_POST));
        if (!empty($_POST['initDate']) && !empty($_POST['endDate'])) {
            // We receive the initial and end dates
            foreach ($aBase as $fecha => $precio) {
                    // We calculate the price between the two dates entered. The format date is: 20-03-2017
                    if ((strtotime($fecha) >= strtotime($_POST['initDate'])) && (strtotime($fecha) <= strtotime($_POST['endDate']))) {
                        //echo "Fechas :" . $fecha . '<br>';
                        $totalPrice += $precio;
                    }

            }

            $response->setContent(json_encode($totalPrice));

        }

        return $response;

    }

    public function calendarAction(Request $request)
    {

        $offerID = $request->get('idOffer');

        $em = $this->getDoctrine()->getEntityManager();
        $db = $em->getConnection();

        $sql =  "select sh.house_id, sh.price as precio_base,my.price,h.calendar_id,my.start_datetime, my.end_datetime,my.ocuppate,my.title,off.service_id,my.service_id from share_house as sh inner join house as h on h.id=sh.house_id inner join my_company_events as my on h.calendar_id = my.calendar_id inner join offer as off on off.service_id = my.service_id and off.id = sh.offer_id WHERE sh.offer_id=$offerID and off.service_id = my.service_id";


        $stmt = $db->prepare($sql);
        $params = array();
        $stmt->execute($params);
        $alEspecificos  = $stmt->fetchAll();

        if (!empty($alEspecificos)) {
            foreach ($alEspecificos as $key => $value) {

                if (!empty($value['precio_base'])) {
                    $alEspecificos['precio_base'] = $value['precio_base'];

                }
            }
        }

        /**
         * Returns every date between two dates as an array
         * @param string $startDate the start of the date range
         * @param string $endDate the end of the date range
         * @param string $format DateTime format, default is Y-m-d
         * @return array returns every date between $startDate and $endDate, formatted as "d-m-Y"
         */
        function createDateRange($startDate, $endDate, $price, $title, $format = "Y-m-d")
        {
            $begin = new \DateTime($startDate);
            $end = new \DateTime($endDate);
            $end->modify('+1 day');

            $interval = new \DateInterval('P1D'); // 1 Day
            $dateRange = new \DatePeriod($begin, $interval, $end);
            //echo "<pre>"; die(print_r($dateRange));
            $range = array();
            foreach ($dateRange as $key => $date) {
                $aux['id'] = $key;
                $aux['title'] = $title;
                $aux['start'] = date_format($date, $format);
                $aux['price'] = $price;
                $range = $aux;
            }

            return $range;
        }

        $em = $this->getDoctrine()->getEntityManager();
        $db = $em->getConnection();

        $query =  "select * from share_house as sh inner join house as h on h.id=sh.house_id inner join offer as off on sh.offer_id= off.id inner join my_company_events as my on h.calendar_id=my.calendar_id and off.service_id=my.service_id WHERE sh.offer_id=$offerID";

        $stmt = $db->prepare($query);
        $params = array();
        $stmt->execute($params);
        $test = $stmt->fetchAll();

        $calendarIDaux = $test[0]["calendar_id"];
        $serviceIDaux = $test[0]["service_id"];
        $query2 =  "select * from my_company_events WHERE calendar_id = $calendarIDaux AND service_id = $serviceIDaux";

        $stmt2 = $db->prepare($query2);
        $params2 = array();
        $stmt2->execute($params2);
        $aEspecificos = $stmt2->fetchAll();

        $response = new \Symfony\Component\HttpFoundation\Response();
        $response->headers->set('Content-Type', 'application/json');

        $eventosEspecificos = array();
        if (!empty($aEspecificos)) {

            foreach ($aEspecificos as $key => $value) {

                if (!empty($value['start_datetime']) && !empty($value['end_datetime'])) {
                    $eventosEspecificos[] = createDateRange($value['start_datetime'], $value['end_datetime'], $value['price'], $value['title']);
                }
            }
        }

        $eventos = $this->createDateRangeBase( '2017-03-01', '2022-12-31', $alEspecificos['precio_base'], "€");

        foreach ($eventos as $key => $value) {
            foreach ($eventosEspecificos as $key2 => $value2) {
                if ($value['start'] == $value2['start']) {
                    $eventos[$key] = $eventosEspecificos[$key2];
                }
            }
        }

        $response->setContent(json_encode($eventos));

        return $response;
    }



    function createDateRangeBase($startDate, $endDate, $price, $title, $format = "Y-m-d")
    {
        $begin = new \DateTime($startDate);
        $end = new \DateTime($endDate);
        $end->modify('+1 day');

        $interval = new \DateInterval('P1D'); // 1 Day
        $dateRange = new \DatePeriod($begin, $interval, $end);

        $range = array();
        foreach ($dateRange as $key => $date) {
            $range[$key]['id'] = $key;
            $range[$key]['title'] = $title;
            $range[$key]['start'] = date_format($date, $format);
            $range[$key]['price'] = $price;

        }

        return $range;
    }

}
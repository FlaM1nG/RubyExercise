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

    function diferenciaDias($inicio, $fin) {
        $inicio = strtotime($inicio);
        $fin = strtotime($fin);
        $dif = $fin - $inicio;
        $diasFalt = (( ( $dif / 60 ) / 60 ) / 24);
        return ceil($diasFalt);
    }


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

        $session = $request->getSession();

        //Guardamos el id de la oferta en la sesion

        $session->set('idoferta', 'idOffer');


        $idoferta = $session->get('offer');


        $em = $this->getDoctrine()->getEntityManager();
        $db = $em->getConnection();

        $repository = $this->getDoctrine()->getRepository('GlobalBundle:MyCompanyEvents');



        $date= new \DateTime ($_POST['startDateCalendario']);

       // Si no esta vacio la fecha final la metemos y si esta vacia metemos la misma que la inicial

        if (!empty(($_POST['datepicker_DatePickerto']))) {

            $date_final = ($_POST['datepicker_DatePickerto']);
        }

            else {

                $date_final = ($_POST['startDateCalendario']);

            }
        
        $date_inicial = ($_POST['startDateCalendario']);

        //imprime el numero de dias entre el rango de fecha
        $numero_dias = $this->diferenciaDias($date_inicial, $date_final);


        for ($n = 0; $n <= $numero_dias; $n++) {

            // query for a single product matching the given name and price
            $test = $repository->findOneBy(
                array('calendarID' => $_POST['calendar_id'], 'serviceID' => $_POST['service_id'], 'startDatetime' => $date
                ));


            if (!$test) {

                $dateEnd = $date;

                $mce = new MyCompanyEvents('', '€', $request->get('price'), $request->get('calendar_id'), $request->get('service_id'), null, null, $date, $dateEnd, 0, $request->get('blocked'), 0, $request->get('inscription_id'));


                $em->persist($mce);

                $em->flush();

                $dateEnd->modify('+1 day');
                $date = $dateEnd;

            } else {
                $dateEnd = $date;
                $test->setPrice($request->get('price'));
                $test->setBlocked($request->get('blocked'));
                $em->flush();
                $dateEnd->modify('+1 day');
                $date = $dateEnd;

            }
        }
        return $this->redirectToRoute('user_profiler_editOffer', array('idOffer' => $idoferta), 301);
    }


    public function cargarDateAction(Request $request)
    {

        function createDateRangeBase($startDate, $endDate, $price, $ocuppate, $blocked, $format = "d-m-Y")
        {
            $begin = new \DateTime($startDate);
            $end = new \DateTime($endDate);
            $end->modify('+1 day');
            $interval = new \DateInterval('P1D'); // 1 Day
            $dateRange = new \DatePeriod($begin, $interval, $end);
            $range = array();
            foreach ($dateRange as $key => $date) {
                $range[$key]['start_datetime'] = date_format($date, $format);
                $range[$key]['end_datetime'] = date_format($date, $format);

                if ($ocuppate == 0) {
                    $range[$key]['ocuppate'] = "0";
                } else {
                    $range[$key]['ocuppate'] = "1";
                }

                if ($blocked == 0) {
                    $range[$key]['blocked'] = "0";
                } else {
                    $range[$key]['blocked'] = "1";
                }

                $range[$key]['price'] = $price;

            }

            return $range;
        }

        $idoffer = $request->get('idOffer');


        $em = $this->getDoctrine()->getEntityManager();
        $db = $em->getConnection();

        $query =  "select sh.house_id, sh.price as precio_base,my.price,h.calendar_id,my.start_datetime, my.end_datetime,my.ocuppate,my.blocked,my.title,off.service_id,my.service_id from share_house as sh inner join house as h on h.id=sh.house_id inner join my_company_events as my on h.calendar_id = my.calendar_id inner join offer as off on off.service_id = my.service_id and off.id = sh.offer_id WHERE sh.offer_id=$idoffer and off.service_id = my.service_id";

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
                    $resultEspecificos[] = createDateRangeBase($value['start_datetime'], $value['end_datetime'], $value['price'], $value['ocuppate'],$value['blocked']);
                }
            }
        }


        $sql =  "select sh.house_id, sh.price as precio_base, my.ocuppate as ocupado, my.blocked as bloqueado,my.start_datetime,my.end_datetime, h.calendar_id,off.service_id from share_house as sh inner join house as h on h.id=sh.house_id inner join offer as off on sh.offer_id= off.id inner join my_company_events as my WHERE sh.offer_id=$idoffer";
        $stmt = $db->prepare($sql);
        $params = array();
        $stmt->execute($params);
        $aEspecificos  = $stmt->fetchAll();




        /*if (!empty($aEspecificos)) {
            foreach ($aEspecificos as $key => $value) {

                if (!empty($value['precio_base'])) {
                    $aEspecificos['precio_base'] = $value['precio_base'];
                    $aEspecificos['ocupado'] = $value['ocupado'];
                    $aEspecificos['bloqueado'] = $value['bloqueado'];

                }
            }
        }*/
       // echo "<pre>";
        //print_r($aEspecificos);die;

// PRECIOS BASE. Por ejemplo: 10€
        //$aBase = createDateRangeBase('2017-01-01', '2018-12-31', $aEspecificos[0]['precio_base'], $aEspecificos['ocupado'],$aEspecificos['bloqueado']);
        $aBase = createDateRangeBase('2017-01-01', '2018-12-31', $aEspecificos[0]['precio_base'], 0, 0);
        if (!empty($resultEspecificos) && !empty($aBase)) {
            foreach ($aBase as $key => $value) {
                foreach ($resultEspecificos as $key2 => $value2) {
                    foreach ($value2 as $key3 => $value3) {
                        if ($value['start_datetime'] == $value3['start_datetime']) {
                            $aBase[$key]['price'] = $value3['price'];
                            $aBase[$key]['ocuppate'] = $value3['ocuppate'];
                            $aBase[$key]['blocked'] = $value3['blocked'];
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
                $initYear = date("Y", $timestampIni);

                // We get the end date
                $timestampEnd = strtotime($value['end_datetime']);
                (int)$endDay = date("d", $timestampEnd);
                $endMonth = intval(date("m", $timestampEnd));
                $endYear = date("Y", $timestampEnd);

                if (!empty($initYear) && !empty($endYear) && !empty($initDay) && !empty($endDay) ) {

                    // We take care of the year
                    for ($j = (int)$initYear; $j <= (int)$endYear; $j++) {

                        for ($i = (int)$initDay; $i <= (int)$endDay; $i++) { // Moving between days

                            if ($initMonth == '1' || $endMonth == '1') {
                                $result[$j]['1']['precio'][$i] = $value['price'] . '€';
                                $result[$j]['1']['ocuppate'][$i] = $value['ocuppate'];
                                $result[$j]['1']['blocked'][$i] = $value['blocked'];
                            } else if ($initMonth == '2' || $endMonth == '2') {
                                $result[$j]['2']['precio'][$i] = $value['price'] . '€';
                                $result[$j]['2']['ocuppate'][$i] = $value['ocuppate'];
                                $result[$j]['2']['blocked'][$i] = $value['blocked'];
                            } else if ($initMonth == '3' || $endMonth == '3') {
                                $result[$j]['3']['precio'][$i] = $value['price'] . '€';
                                $result[$j]['3']['ocuppate'][$i] = $value['ocuppate'];
                                $result[$j]['3']['blocked'][$i] = $value['blocked'];

                            } else if ($initMonth == '4' || $endMonth == '4') {
                                $result[$j]['4']['precio'][$i] = $value['price'] . '€';
                                $result[$j]['4']['ocuppate'][$i] = $value['ocuppate'];
                                $result[$j]['4']['blocked'][$i] = $value['blocked'];
                            } else if ($initMonth == '5' || $endMonth == '5') {
                                $result[$j]['5']['precio'][$i] = $value['price'] . '€';
                                $result[$j]['5']['ocuppate'][$i] = $value['ocuppate'];
                                $result[$j]['5']['blocked'][$i] = $value['blocked'];
                            } else if ($initMonth == '6' || $endMonth == '6') {
                                $result[$j]['6']['precio'][$i] = $value['price'] . '€';
                                $result[$j]['6']['ocuppate'][$i] = $value['ocuppate'];
                                $result[$j]['6']['blocked'][$i] = $value['blocked'];
                            } else if ($initMonth == '7' || $endMonth == '7') {
                                $result[$j]['7']['precio'][$i] = $value['price'] . '€';
                                $result[$j]['7']['ocuppate'][$i] = $value['ocuppate'];
                                $result[$j]['7']['blocked'][$i] = $value['blocked'];
                            } else if ($initMonth == '8' || $endMonth == '8') {
                                $result[$j]['8']['precio'][$i] = $value['price'] . '€';
                                $result[$j]['8']['ocuppate'][$i] = $value['ocuppate'];
                                $result[$j]['8']['blocked'][$i] = $value['blocked'];
                            } else if ($initMonth == '9' || $endMonth == '9') {
                                $result[$j]['9']['precio'][$i] = $value['price'] . '€';
                                $result[$j]['9']['ocuppate'][$i] = $value['ocuppate'];
                                $result[$j]['9']['blocked'][$i] = $value['blocked'];
                            } else if ($initMonth == '10' || $endMonth == '10') {
                                $result[$j]['10']['precio'][$i] = $value['price'] . '€';
                                $result[$j]['10']['ocuppate'][$i] = $value['ocuppate'];
                                $result[$j]['10']['blocked'][$i] = $value['blocked'];
                            } else if ($initMonth == '11' || $endMonth == '11') {
                                $result[$j]['11']['precio'][$i] = $value['price'] . '€';
                                $result[$j]['11']['ocuppate'][$i] = $value['ocuppate'];
                                $result[$j]['11']['blocked'][$i] = $value['blocked'];

                            } else if ($initMonth == '12' || $endMonth == '12') {
                                $result[$j]['12']['precio'][$i] = $value['price'] . '€';
                                $result[$j]['12']['ocuppate'][$i] = $value['ocuppate'];
                                $result[$j]['12']['blocked'][$i] = $value['blocked'];

                            }
                        }

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

        function createDateRange($startDate, $endDate, $price, $ocuppate, $blocked, $format = "d-m-Y")
        {
            $begin = new \DateTime($startDate);
            $end = new \DateTime($endDate);
            $end->modify('+1 day');

            $interval = new \DateInterval('P1D'); // 1 Day
            $dateRange = new \DatePeriod($begin, $interval, $end);
            $range = array();
            foreach ($dateRange as $key => $date) {
                //$range[$key]['fecha'] = $date->format($format);
                //$range[$key]['price'] = $price;
                //$range[date_format($date, $format)] = $price;
                $range[date_format($date, $format)]['precio'] = $price;
                $range[date_format($date, $format)]['ocupado'] = $ocuppate;
                $range[date_format($date, $format)]['bloqueado'] = $blocked;
            }

            return $range;
        }

        $offerID = $request->get('idOffer');

        $em = $this->getDoctrine()->getEntityManager();
        $db = $em->getConnection();

        $sql =  "select sh.house_id, sh.price as precio_base, my.ocuppate as ocupado,h.calendar_id,off.service_id from share_house as sh inner join house as h on h.id=sh.house_id inner join offer as off on sh.offer_id= off.id inner join my_company_events as my WHERE sh.offer_id=$offerID";


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

        $query = "select sh.house_id, sh.price as precio_base,my.price,h.calendar_id,my.start_datetime, my.end_datetime,my.ocuppate,my.blocked,my.title,off.service_id,my.service_id from share_house as sh inner join house as h on h.id=sh.house_id inner join my_company_events as my on h.calendar_id = my.calendar_id inner join offer as off on off.service_id = my.service_id and off.id = sh.offer_id WHERE sh.offer_id=$idoffer and off.service_id = my.service_id";
        $stmt = $db->prepare($query);
        $params = array();
        $stmt->execute($params);
        $fechas = $stmt->fetchAll();
        //echo "<pre>"; die(print_r($fechas));


        // List of dates and base prices
        $aBase = createDateRange('2017-01-01', '2017-12-31', $aEspecificos['precio_base'], 0 ,0);
        $result = array('1' => array(), '2' => array(), '3' => array(), '4' => array(), '5' => array(),'6' => array(),'7' => array(),'8' => array(),'9' => array(),'10' => array(),'11' => array(),'12' => array());

        if (!empty($fechas)) {
            //echo "<pre>"; die(print_r($input_arrays));
            foreach ($fechas as $key => $value) {

                if (!empty($value['start_datetime']) && !empty($value['end_datetime'])) {
                    $result[] = createDateRange($value['start_datetime'], $value['end_datetime'], $value['price'], $value['ocuppate'], $value['blocked']);
                }
            }
        }

        // We merge the base prices with the specific ones
        if (!empty($aBase) && !empty($result)) {
            foreach ($aBase as $key => $value) {
                foreach ($result as $key2 => $value2) {
                    foreach ($value2 as $key3 => $value3) {
                        //die($key .'=='. $key3);
                        if ($key == $key3) {
                            $aBase[$key]['precio'] = $value3['precio'];
                            $aBase[$key]['ocupado'] = $value3['ocupado'];
                            $aBase[$key]['bloqueado'] = $value3['bloqueado'];
                        }
                    }
                }
            }
        }

        //echo "<pre>"; die(print_r($aBase));
        $totalPrice = '0';
        $res = array(
            'response' => 'NOK',
            'totalPrice' => ''
        );

        $sePuede = true;

        if (!empty($_POST['initDate']) && !empty($_POST['endDate'])) {
            //We receive the initial and end dates, if this dates are the same are false
            if (($_POST['initDate']) == ($_POST['endDate'])) {
                $sePuede = false;
            }
            // We receive the initial and end dates
            foreach ($aBase as $fecha => $value) {
                    // We calculate the price between the two dates entered. The format date is: 20-03-2017
                    if ((strtotime($fecha) >= strtotime($_POST['initDate'])) && (strtotime($fecha) < strtotime($_POST['endDate']))) {
                        //echo "Fechas :" . $fecha . '<br>';
                        if ($value['ocupado'] == 1 || $value['bloqueado'] == 1) {
                            $sePuede = false;
                            //$res['response'] = 'NOK';
                        } //else {
                            //$res['response'] = 'OK';
                        //}

                        //print_r($value);

                        $res['totalPrice'] += $value['precio'];
                        //$totalPrice += $value['precio'];


                    }
            }

            if (!empty($res['totalPrice'])){


                $sesion = $request->getSession();

                //Guardamos el precio total en la sesion

                $sesion->set('preciototal', $res['totalPrice']);

                $sesion->set('fechainicial', $_POST['initDate']);

                $sesion->set('fechafinal', $_POST['endDate']);

             //   $idoferta = $session->get('offer');

            }

            if ($sePuede) {
                $res['response'] = 'OK';
            }

            //echo "<pre>"; die(print_r($res));
            //die($totalPrice . ' <-');
            $response->setContent(json_encode($res));

        }

        return $response;

    }

    public function calendarAction(Request $request)
    {

        $session = $request->getSession();

       $idoffer = $request->getSession();

        $offerID = $request->get('idOffer');

       /*
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
*/
        /**
         * Returns every date between two dates as an array
         * @param string $startDate the start of the date range
         * @param string $endDate the end of the date range
         * @param string $format DateTime format, default is Y-m-d
         * @return array returns every date between $startDate and $endDate, formatted as "d-m-Y"
         */
        function createDateRange($startDate, $endDate, $price, $ocuppate, $blocked, $title, $format = "Y-m-d")
        {
            $begin = new \DateTime($startDate);
            $end = new \DateTime($endDate);
            $end->modify('+1 day');

            $interval = new \DateInterval('P1D'); // 1 Day
            $dateRange = new \DatePeriod($begin, $interval, $end);
            $range = array();
            foreach ($dateRange as $key => $date) {
                $aux['id'] = $key;
                $aux['title'] = $title;
                $aux['start'] = date_format($date, $format);
                $aux['price'] = $price;
                $aux['ocuppate'] = $ocuppate;
                $aux['blocked'] = $blocked;
                $range = $aux;
            }

            return $range;
        }


        $response = new \Symfony\Component\HttpFoundation\Response();
        $response->headers->set('Content-Type', 'application/json');

        $eventos = array();

        $eventos = $session->get('foo');

        $idoffer = array();


        $idoffer = $session->get('oferta');


        if(empty($eventos) || $idoffer != $offerID ){



        $offerID = $request->get('idOffer');

        $em = $this->getDoctrine()->getEntityManager();
        $db = $em->getConnection();

        $query =  "select sh.house_id, sh.price as precio_base, my.ocuppate as ocupado, my.blocked as bloqueado, h.calendar_id,off.service_id from share_house as sh inner join house as h on h.id=sh.house_id inner join offer as off on sh.offer_id= off.id inner join my_company_events as my WHERE sh.offer_id=$offerID";
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



        $eventosEspecificos = array();
        if (!empty($aEspecificos)) {

            foreach ($aEspecificos as $key => $value) {

                if (!empty($value['start_datetime']) && !empty($value['end_datetime'])) {
                    $eventosEspecificos[] = createDateRange($value['start_datetime'], $value['end_datetime'], $value['price'], $value['ocuppate'],$value['blocked'], $value['title']);
                }
            }
        }


        $eventos = $this->createDateRangeBaseCAL( '2017-04-01', '2018-12-31',  $test[0]["precio_base"], $test[0]["ocupado"],$test[0]["bloqueado"],"€" );

        foreach ($eventos as $key => $value) {
            foreach ($eventosEspecificos as $key2 => $value2) {
                if ($value['start'] == $value2['start']) {
                    $eventos[$key] = $eventosEspecificos[$key2];
                }
            }
        }

            $session->set('foo', $eventos);

            $session->set('sesion', $idoffer);




        }//cierra el if

        else{

      

            $eventos = $session->get('foo');

            $idoffer = $session->get('sesion');


        }



        $response->setContent(json_encode($eventos));

        return $response;
    }

    function createDateRangeBaseCAL($startDate, $endDate, $price,$ocuppate, $blocked, $title, $format = "Y-m-d")
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
            $range[$key]['ocuppate'] = $ocuppate;
            $range[$key]['blocked'] = $blocked;


        }

        return $range;
    }


 







}
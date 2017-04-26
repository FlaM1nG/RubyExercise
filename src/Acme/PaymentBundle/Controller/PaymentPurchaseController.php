<?php

namespace Acme\PaymentBundle\Controller;

require_once ( 'C:\xampp\htdocs\wwweb\vendor\autoload.php' );

//require_once $_SERVER['DOCUMENT_ROOT'] . '/JS9NAJ8JEABj8jcsk9xbGTC7VSM9XAMbaxnbs3873778dhd4m/vendor/autoload.php';
use Acme\PaymentBundle\Entity\Payment;
use Payum\Core\Payum;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use WWW\GlobalBundle\Entity\Utilities;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\MyConstants;
use WWW\OthersBundle\Entity\Trade;
use WWW\CarsBundle\Entity\ShareCar;
use WWW\HouseBundle\Entity\ShareHouse;
use WWW\GlobalBundle\Entity\MyCompanyEvents;
use WWW\HouseBundle\Entity\House;
use com\realexpayments\remote\sdk\domain\Card;
use com\realexpayments\remote\sdk\domain\CardType;
use com\realexpayments\remote\sdk\domain\PresenceIndicator;
use com\realexpayments\remote\sdk\domain\payment\AutoSettle;
use com\realexpayments\remote\sdk\domain\payment\AutoSettleFlag;
use com\realexpayments\remote\sdk\domain\payment\PaymentRequest;
use com\realexpayments\remote\sdk\domain\payment\PaymentResponse;
use com\realexpayments\remote\sdk\domain\payment\PaymentType;
use com\realexpayments\remote\sdk\RealexClient;
use com\realexpayments\remote\sdk\http\HttpConfiguration;
use Crevillo\Payum\Redsys\Api;
use Acme\PaymentBundle\Form\PagoType;
use WWW\UserBundle\Entity\User;

class PaymentPurchaseController extends Controller {

    private $offer;
    private $service;
    private $serviceId;

    //Función pincipal popara preparar el pago
    //Carga un formulario con los siguientes campos:
    //1-Pago por paypal o pago por tarjeta
    //2- Cantidad a pagar
    //3- Moneda EU o USD
    //4- Correo del cliente

    // Funcion para calcular el numero de inserciones por fecha en my_company_events

    function diferenciaDias($inicio, $fin)
    {
        $inicio = strtotime($inicio);
        $fin = strtotime($fin);
        $dif = $fin - $inicio;
        $diasFalt = (( ( $dif / 60 ) / 60 ) / 24);
        return ceil($diasFalt);
    }


    public function prepareAction(Request $request) {
        //Redsys <20
        //Addons >20
        $user = $this->getUserProfile($request);
        $arrayAddressesPay = array();
        $arrayAddressesForm = array();

        $this->createArraysAddresses($user, $arrayAddressesPay, $arrayAddressesForm);

        $this->setUpVars($request);


        $administrationFeesPercent = MyConstants::ADMINISTRATION_FEES/100;

        $form = $this->createForm(PagoType::class, $user, array('amount' =>$this->offer->getPrice(),
                                                                'arrayAddresses' => $arrayAddressesForm));
        $form->handleRequest($request);


        $arrayCourier = null;


        $this->serviceId  = $this->offer->getOffer()->getService()->getId();


        if ($this->serviceId == 1 || $this->serviceId == 2):
            $arrayCourier = $this->getCourierPrice($request);

        endif;

        $preciototal = null;

        if ($this->serviceId == 6 || $this->serviceId == 7):

          // $precio_base= $this->offer->getPrice();

            $sesion = $request->getSession();

            //Guardamos el precio total en la sesion

            $preciototal = $sesion->get('preciototal');

            $fechainicial = $sesion->get('fechainicial');

            $offerID = $request->get('idOffer');


            $date = new \DateTime ($fechainicial);

            $calendarioId = $sesion->get('calendario_id');

           // $servicioId = $sesion->get('service_id');

            $fechafinal = $sesion->get('fechafinal');

            $fechaend = $date;

            $em = $this->getDoctrine()->getEntityManager();
            $db = $em->getConnection();

            $numero_dias = $this->diferenciaDias($fechainicial, $fechafinal); //imprime el numero de dias entre el rango de fecha


            $repository = $this->getDoctrine()->getRepository('GlobalBundle:MyCompanyEvents');

            // hacemos un for para insertar

            for ($n=0; $n<$numero_dias; $n++) {

                $test = $repository->findOneBy(
                    array('calendarID' => $calendarioId, 'serviceID' => $this->serviceId , 'startDatetime' => $date
                    ));

                if (!$test) {

                $mce = new MyCompanyEvents('', '€', $preciototal, $calendarioId, $this->serviceId , null, null, $date, $fechaend, 0, 0, 0, $request->get('inscription_id'));

                $mce->setOcuppate(true);

                $query = "select id from inscription where offer_id=$offerID";

                $stmt = $db->prepare($query);
                $params = array();
                $stmt->execute($params);
                $fechas = $stmt->fetchAll();


                $mce->setInscriptionID($fechas[0]['id']);

                $em->persist($mce);

                $em->flush();

                //vamos sumando un dia a las fechas

                $fechaend->modify('+1 day');

                $date = $fechaend;

                }else{

                    $query = "select id from inscription where offer_id=$offerID";

                    $stmt = $db->prepare($query);
                    $params = array();
                    $stmt->execute($params);
                    $fechas = $stmt->fetchAll();


                    $test->setInscriptionID($fechas[0]['id']);
                    $test->setOcuppate(true);
                    $test->setPrice($preciototal);


                    $em->flush();

                    $fechaend->modify('+1 day');

                    $date = $fechaend;


                }
            }

        endif;

        $session = $request->getSession();
        $session->set('_security.user.target_path', null);

        if ($form->isSubmitted() && $form->get('submit')->isClicked()) {

//            Si el usuario elige pagar con tarjeta (LA CAIXA)
//            if ($form->get('gateway_name')->getData() == 'addon_payments') {
//                //cargamos el pago por tarjeta
//                return $this->redirectToRoute('acme_payment_card', array(
//                            'idOffer' => $this->offer->getOffer()->getId(),
//                            'service' => $this->service,
//                ));
//            }
            //Guardamos los datos en la base de datos
            $arrayPay['gastos_gestion'] = $request->get('previoPago')['managementFee'];
            $arrayPay['gastos_pago'] = $request->get('previoPago')['managementPayFee'];
            $arrayPay['gastos_totales'] = $request->get('previoPago')['totalAmount'];
            $arrayPay['metodo_pago'] = $request->get('previoPago')['payMethod'];
            $arrayPay['precio_oferta'] = $this->offer->getPrice();
            if ($this->serviceId == 1 || $this->serviceId == 2) {
                $arrayPay['direccion'] = $request->get('previoPago')['addressPay'];
                $arrayPay['metodo_envio'] = $request->get('previoPago')['sendMethod'];
                $arrayPay['gastos_envio'] = $request->get('previoPago')['shippingCost'];
                //$arrayPay['send_office'] = $request->get('previoPago')['send_office'];
                //$arrayPay['gastos_comprobacion'] = $request->get('previoPago')['testing_cost'];
            }

            $payment = new Payment;
            //numero de referencia por la hora y fecha
            $payment->setNumber(date('His') . 'W' . $request->get('idOffer'));
            $payment->setClientId(uniqid());
            $payment->setDescription(sprintf('Pago total de %s del cliente %s', $request->get('previoPago')['totalAmount'], $user->getUsername()));
            $payment->setTotalAmount($request->get('previoPago')['totalAmount'] * 100);
            $payment->setCurrencyCode('EUR');
            $payment->setClientEmail($user->getUsername());
            $payment->setDetails($arrayPay);

            //REDSYS
            if ($request->get('previoPago')['payMethod'] == 'card') {
                // 4548812049400004
                // 12/20
                // 123
                // 123456

                $storage = $this->getPayum()->getStorage('Acme\PaymentBundle\Entity\PaymentDetails');
                $details = $storage->create();
                $details['Ds_Merchant_Amount'] = $request->get('previoPago')['totalAmount'] * 100;
                $details['Ds_Merchant_Currency'] = '978';
                $details['Ds_Merchant_Order'] = date('His') . 'W' . $request->get('idOffer');
                $details['Ds_Merchant_TransactionType'] = Api::TRANSACTIONTYPE_AUTHORIZATION;
                $details['Ds_Merchant_ConsumerLanguage'] = Api::CONSUMERLANGUAGE_SPANISH;

                $details['gastos_gestion'] = $request->get('previoPago')['managementFee'];
                $details['gastos_pago'] = $request->get('previoPago')['managementPayFee'];
                $details['gastos_totales'] = $request->get('previoPago')['totalAmount'];
                $details['metodo_pago'] = $request->get('previoPago')['payMethod'];
		$details['precio_oferta'] = $this->offer->getPrice();
                if ($this->serviceId == 1 || $this->serviceId == 2) {
                    $details['direccion'] = $request->get('previoPago')['addressPay'];
                    $details['metodo_envio'] = $request->get('previoPago')['sendMethod'];
                    $details['gastos_envio'] = $request->get('previoPago')['shippingCost'];
                   // $details['send_office'] = $request->get('previoPago')['send_office'];
                    //$arrayPay['gastos_comprobacion'] = $request->get('previoPago')['testing_cost'];
                }

                $storage->update($details);
                //Las notificaciones de compra se guardan en la tabla payum_payments_details
                //de ahi se tienen que sacar el DS_Response y manejar la respuesta
                $notifyToken = $this->getPayum()->getTokenFactory()->createNotifyToken(
                        'redsys', $details
                );

                $details['Ds_Merchant_MerchantURL'] = $notifyToken->getTargetUrl();
                $storagePay = $this->getPayum()->getStorage($payment);
                $payment->setDetails($details);
                $storagePay->update($payment);
                $details['idRedsys'] = $details->getId();
                $captureTokenOK = $this->getPayum()->getTokenFactory()->createCaptureToken(
                        'redsys', $payment, 'prueba_postpago_ok'
                );
                $captureTokenKO = $this->getPayum()->getTokenFactory()->createCaptureToken(
                        'redsys', $payment, 'prueba_postpago_ko'
                );

                $details['Ds_Merchant_UrlOK'] = $captureTokenOK->getAfterUrl(); //podriamos poner el setAfterUrl con una direccion de exito o fracaso
                $details['Ds_Merchant_UrlKO'] = $captureTokenKO->getAfterUrl();
                $payment->setDetails($details);
                $storagePay = $this->getPayum()->getStorage($payment);
                $payment->setDetails($details);
                $storagePay->update($payment);
                return $this->redirect($captureTokenOK->getTargetUrl());
            }

            //Si no, se paga por PAYPAL
            elseif ($request->get('previoPago')['payMethod'] == 'paypal') {

                $storage = $this->getPayum()->getStorage($payment);
                $storage->update($payment);

                $captureToken = $this->getPayum()->getTokenFactory()->createCaptureToken(
                        'paypal_express_checkout_with_ipn_enabled', $payment, 'acme_payment_done'
                );


                return $this->redirect($captureToken->getTargetUrl());
            }
        }

        return $this->render('pay/payPage.html.twig', array(
                    'form' => $form->createView(),
                    'offer' => $this->offer,
                    'service' => $this->serviceId,
                    'arrayCourier' => $arrayCourier,
                    'preciototal' =>  $preciototal,
                    'arrayAddresses' => $arrayAddressesPay,
                    'administrationFees' => $administrationFeesPercent,
                    'sendOfficePercent' => MyConstants::SEND_OFFICE/100,
                    'paypalFee' => MyConstants::PAYPAL_FEE/100
        ));
    }

    //Funcion para el pago con tarjeta. Tiene un formulario con los sigueintes campos:
    //1-Tipo de tarjeta Visa MasterCard
    //2-Numero de cuenta
    //3-Fecha de expiración
    //4-Cvv2
    //5-Nombre del titular de la tarjeta
    public function cardAction(Request $request) {
        $this->setUpVars($request);
        $form = $this->createCardForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $card = ( new Card())
                    ->addType($form->get('cardtype')->getData())
                    ->addNumber($form->get('acct')->getData())
                    ->addExpiryDate($form->get('exp_date')->getData())
                    ->addCvn($form->get('cvv2')->getData())
                    ->addCvnPresenceIndicator(PresenceIndicator::CVN_PRESENT)
                    ->addCardHolderName($form->get('name')->getData());
            $request = ( new PaymentRequest())
                    ->addMerchantId("whatwantweb")
                    ->addType(PaymentType::AUTH)
                    ->addCard($card)
                    ->addAmount($this->offer->getPrice() * 100)
                    ->addCurrency("EUR")
                    ->addAutoSettle(( new AutoSettle())->addFlag(AutoSettleFlag::TRUE));

            $httpConfiguration = new HttpConfiguration();
            $httpConfiguration->setEndpoint("https://remote.sandbox.addonpayments.com/remote");
            $client = new RealexClient("U1DZQjQOMB", $httpConfiguration);
            $response = $client->send($request);

            // do something with the response
            echo $response->toXML();

            $resultCode = $response->getResult();
            $message = $response->getMessage();
        }
        return $this->render('AcmePaymentBundle::prepare.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    protected function createCardForm() {
        return $this->createFormBuilder()
                        ->add('cardtype', 'choice', array(
                            'choices' => array(
                                'VISA' => 'Visa',
                                'MASTERCARD' => 'MasterCard',
                            ),
                            'mapped' => false,
                            'constraints' => array(new NotBlank())
                        ))
                        ->add('acct', null, array('data' => '4263971921001307'))
                        ->add('exp_date', null, array('data' => '1220'))
                        ->add('cvv2', null, array('data' => '123'))
                        ->add('name', null, array('data' => $this->offer->getOffer()->getUserAdmin()->getName() . ' ' . $this->offer->getOffer()->getUserAdmin()->getSurname()))
                        ->getForm()
        ;
    }

    /**
     * @return Payum
     */
    protected function getPayum() {
        return $this->get('payum');
    }

    //se comprueba por la url el tipo de servicio y el id de oferta
    //para asi buscar dicha oferta y guardarla en $this->offer
    public function setUpVars(Request $request) {

        $this->ut = new Utilities();
        $this->session = $request->getSession();
        $this->trade = null;

        $path = $request->getPathInfo();

        if (strstr($path, 'trade') !== false):
            $this->service = 'trade';
            $this->getOffer($request);
        
        elseif (strstr($path, 'share-car') !== false):
            $this->service = 'share-car';
            $this->serviceId = 4;
//            $this->getOfferShareCar($request);
            $this->getOfferInfo($request);
        
        elseif (strstr($path, 'courier-car') !== false):
            $this->service = 'courier-car';
            $this->serviceId = 5;
            $this->getOfferInfo($request);
        
        elseif (strstr($path, 'house-rents') !== false):            
            $this->service = 'house-rents';
            $this->serviceId = 6;
            $this->getOffer($request);
        elseif (strstr($path, 'share-house') !== false):
            $this->service = 'share-house';
            $this->serviceId = 7;
            $this->getOffer($request);
        else:
            $this->service = 2;
        endif;
    }

    private function getOffer($request) {

        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST . "services/offer/get_offer.php";

        $this->offer = null;

        $data['id'] = $request->get('idOffer');

        $result = $ch->resultApiRed($data, $file);
        
        if ($result['result'] == 'ok'):
            if($result['service_id'] == 6 || $result['service_id'] == 7){
                $this->offer = new ShareHouse($result);
            }
            $this->offer = new Trade($result);

        else:
            $this->ut->flashMessage("general", $request);
        endif;
    }

    private function getOfferShareCar(Request $request) {

        $file = MyConstants::PATH_APIREST . 'services/share_car/get_share_car.php';
        $ch = new ApiRest();
        $this->offer = null;
        $id = $request->get('idOffer');

        $data['id'] = $id;
        $data['option'] = "offer";

        $result = $ch->resultApiRed($data, $file);

        $this->offer = new ShareCar($result);

        return $this->offer;
    }

    private function getOfferInfo(Request $request) {
        $file = MyConstants::PATH_APIREST . 'services/offer/get_infoOffersPrice.php';
        $ch = new ApiRest();

        $data['id'] = $request->getSession()->get('id');
        $data['username'] = $request->getSession()->get('username');
        $data['password'] = $request->getSession()->get('password');
        $data['offerId'] = $request->get('idOffer');
        $data['serviceId'] = $this->serviceId;


        $result = $ch->resultApiRed($data, $file);

        if ($this->serviceId == 4 || $this->serviceId == 5):

            $this->offer = new ShareCar($result['data']);

        endif;

       // if ($this->serviceId == 6 || $this->serviceId == 7):

         //   $this->offer = new ShareHouse($result['data']);
            //$this->offer = new House($result['data']);

     //   endif;


    }

    private function getUserProfile(Request $request) {

        $user = null;
        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST . 'user/data/get_info_user.php';

        $data['id'] = $this->getUser()->getId();
        $data['username'] = $this->getUser()->getUsername();
        $data['password'] = $request->getSession()->get('password');

        $result = $ch->resultApiRed($data, $file);

        if ($result['result'] == 'ok'):
            $user = new User($result);
        endif;

        return $user;
    }

    private function getCourierPrice(Request $request) {

        $file = MyConstants::PATH_APIREST . 'services/courier/get_courierPrice.php';
        $ch = new ApiRest();

        if ($this->offer->getWeight() <= 30):

            $data['id'] = $request->getSession()->get('id');
            $data['username'] = $request->getSession()->get('username');
            $data['password'] = $request->getSession()->get('password');
            $data['id_messengerService'] = 2;
            $data['weight'] = $this->offer->getWeight();

            $result = $ch->resultApiRed($data, $file);

            if ($result['result'] == 'ok'):
                return $result['messengerPrice'][0];
            else:
                return null;
            endif;
        else:
//            esto es para que no me pete en twig
            $array = array('price_es' => null, 'price_ba' => null, 'price_ca' => null);
            return $array;
        endif;
    }
    
    private function createArraysAddresses(User $user, &$arrayAddressesPay, &$arrayAddressesForm){

        $addressDefault = $user->getDefaultAddress();

        array_unshift($arrayAddressesForm,$addressDefault);

        if(!empty($user->getAddresses()[0])):
            
            foreach($user->getAddresses()[0] as $data ):
                array_push($arrayAddressesForm,$data);
                $arrayAddressesPay[$data->getId()] = strtolower($data->getRegion());
            endforeach;

            $arrayAddressesPay[$user->getDefaultAddress()->getId()] = $user->getDefaultAddress()->getRegion();
        endif;

    }

}


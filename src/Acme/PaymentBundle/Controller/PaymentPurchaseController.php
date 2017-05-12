<?php

namespace Acme\PaymentBundle\Controller;

require_once ( 'C:\xampp\htdocs\wwweb\vendor\autoload.php' );

//require_once $_SERVER['DOCUMENT_ROOT'] . '/JS9NAJ8JEABj8jcsk9xbGTC7VSM9XAMbaxnbs3873778dhd4m/vendor/autoload.php';
use Acme\PaymentBundle\Entity\Payment;
use Payum\Core\Payum;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use WWW\GlobalBundle\Entity\Utilities;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\MyConstants;
use WWW\OthersBundle\Entity\Trade;
use WWW\CarsBundle\Entity\ShareCar;
use WWW\HouseBundle\Entity\ShareHouse;
use com\realexpayments\remote\sdk\domain\Card;
use com\realexpayments\remote\sdk\domain\PresenceIndicator;
use com\realexpayments\remote\sdk\domain\payment\AutoSettle;
use com\realexpayments\remote\sdk\domain\payment\AutoSettleFlag;
use com\realexpayments\remote\sdk\domain\payment\PaymentRequest;
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


    public function prepareAction(Request $request) {
        // Se crean las variables. Se carga el usuario de la sesion 
        $user = $this->getUserProfile($request);
        $arrayAddressesPay = array();
        $arrayAddressesForm = array();
        $form = null;
        $this->createArraysAddresses($user, $arrayAddressesPay, $arrayAddressesForm);
        // Se cargan los valores propios de la clase, oferta servicio id etc
        $this->setUpVars($request);

        $administrationFeesPercent = MyConstants::ADMINISTRATION_FEES/100;
        // Aqui se comprueba que si la oferta es de casas que pille el precio por
        // la sesion ( el precio depende de las fechas
        if ($this->serviceId == 6 || $this->serviceId == 7):
          
            $form = $this->createForm(PagoType::class, $user, array('amount' => $request->getSession()->get('preciototal'),
            'arrayAddresses' => $arrayAddressesForm, 'service'=> $this->serviceId));
        else:
            $form = $this->createForm(PagoType::class, $user, array('amount' => $this->offer->getPrice(),
            'arrayAddresses' => $arrayAddressesForm, 'service'=> $this->serviceId));
        endif;
        
        
        $form->handleRequest($request);

        $arrayCourier = null;
        $this->serviceId = $this->offer->getOffer()->getService()->getId();

        // Si el servicio es trade, se pilla el precio segun el tamaño del 
        // paquete y el peso
        if ($this->serviceId == 1 || $this->serviceId == 2):
            $arrayCourier = $this->getCourierPrice($request);

        endif;
        
        $preciototal = null;
        // Este if se podria unir con el de arriba?
        if ($this->serviceId == 6 || $this->serviceId == 7):

           // $precio_base= $this->offer->getPrice();

            $sesion = $request->getSession();

            //Cargamos el precio total de la sesion

            $preciototal = $sesion->get('preciototal');


            $this->offer->setPrice($preciototal);

        endif;

        $session = $request->getSession();
        $session->set('_security.user.target_path', null);

        if ($form->isSubmitted() && $form->get('submit')->isClicked()) {

            //Guardamos los datos en la base de datos en la parte details
            $arrayPay['gastos_gestion'] = $request->get('previoPago')['managementFee'];
            $arrayPay['gastos_pago'] = $request->get('previoPago')['managementPayFee'];
            $arrayPay['gastos_totales'] = $request->get('previoPago')['totalAmount'];
            $arrayPay['metodo_pago'] = $request->get('previoPago')['payMethod'];
            $arrayPay['precio_oferta'] = $this->offer->getPrice();
            $arrayPay['idService'] = $this->serviceId;
            if ($this->serviceId == 1 || $this->serviceId == 2) {
                $arrayPay['idInscription'] = $session->get('idInscription');
                $arrayPay['direccion'] = $request->get('previoPago')['addressPay'];
                $arrayPay['metodo_envio'] = $request->get('previoPago')['sendMethod'];
                $arrayPay['gastos_envio'] = $request->get('previoPago')['shippingCost'];
                if(!empty($request->get('previoPago')['send_office'])){
                    $arrayPay['send_office'] = $request->get('previoPago')['send_office'];
                    $arrayPay['gastos_comprobacion'] = $request->get('previoPago')['testing_cost'];
                }
            }
            if ($this->serviceId == 6 || $this->serviceId == 7) {
                $arrayPay['fechaIni'] = $sesion->get('fechainicial');
                $arrayPay['fechaFin'] = $sesion->get('fechafinal');
                $arrayPay['idCalendar'] = $sesion->get('calendario_id');                
                $arrayPay['idInscription'] = $sesion->get('idInscription');
            }

            $payment = new Payment;
            //numero de referencia por la hora y fecha
            //PUEDE QUE SE DE EL CASO QUE DOS PERSONAS QUE COMPREN LA MISMA OFERTA
            //A LA MISMA HORA (MISMO SEGUNDO) Y SE CREE UN NUMERO REPETIDO! 
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
                $details['idService'] = $this->serviceId;
                if ($this->serviceId == 1 || $this->serviceId == 2) {
                    $details['idInscription'] = $session->get('idInscription');
                    $details['direccion'] = $request->get('previoPago')['addressPay'];
                    $details['metodo_envio'] = $request->get('previoPago')['sendMethod'];
                    $details['gastos_envio'] = $request->get('previoPago')['shippingCost'];
                    if(!empty($request->get('previoPago')['send_office'])){
                        $details['send_office'] = $request->get('previoPago')['send_office'];
                        $details['gastos_comprobacion'] = $request->get('previoPago')['testing_cost'];
                    }
                    // $details['send_office'] = $request->get('previoPago')['send_office'];
                    //$arrayPay['gastos_comprobacion'] = $request->get('previoPago')['testing_cost'];
                }
             if ($this->serviceId == 6 || $this->serviceId == 7) {
                $details['fechaIni'] = $sesion->get('fechainicial');
                $details['fechaFin'] = $sesion->get('fechafinal');
                $details['idCalendar'] = $sesion->get('calendario_id');
                
                $details['idInscription'] = $sesion->get('idInscription');
            }

                $storage->update($details);
                // Las notificaciones de compra se guardan en la tabla payum_payments_details
                // de ahi se tienen que sacar el DS_Response y manejar la respuesta
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

            //PAYPAL
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
                    'preciototal' => $preciototal,
                    'arrayAddresses' => $arrayAddressesPay,
                    'administrationFees' => $administrationFeesPercent,
                    'sendOfficePercent' => MyConstants::SEND_OFFICE / 100,
                    'paypalFee' => MyConstants::PAYPAL_FEE / 100
        ));
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
            if ($result['service_id'] == 6 || $result['service_id'] == 7) {
                $this->offer = new ShareHouse($result);
            }
            else{
                $this->offer = new Trade($result);
            }
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

        if($this->serviceId == 5):
            $data['idInscription'] = $request->getSession()->get('idInscription');
        endif;

        $result = $ch->resultApiRed($data, $file);

        if ($this->serviceId == 4 || $this->serviceId == 5):

            $this->offer = new ShareCar($result['data']);
         
        endif;

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

    private function createArraysAddresses(User $user, &$arrayAddressesPay, &$arrayAddressesForm) {

        $addressDefault = $user->getDefaultAddress();

        if(!empty($addressDefault)):
            array_unshift($arrayAddressesForm,$addressDefault);
            $arrayAddressesPay[$user->getDefaultAddress()->getId()] = mb_strtolower($addressDefault->getRegion());
        endif;

        if(!empty($user->getAddresses()[0])):
            
            foreach($user->getAddresses()[0] as $data ):
                array_push($arrayAddressesForm,$data);
                $arrayAddressesPay[$data->getId()] =  mb_strtolower($data->getRegion());
            endforeach;

        endif;
    }

}

<?php

namespace Acme\PaymentBundle\Controller;

//require_once $_SERVER['DOCUMENT_ROOT'].'/JS9NAJ8JEABj8jcsk9xbGTC7VSM9XAMbaxnbs3873778dhd4m/vendor/autoload.php';
require_once ( 'C:\xampp\htdocs\wwweb\vendor\autoload.php' );

use Acme\PaymentBundle\Entity\Payment;
use Payum\Core\Payum;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Crevillo\Payum\Redsys\Api;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use WWW\ServiceBundle\Entity\Offer;
use WWW\OthersBundle\Entity\Trade;
use WWW\CarsBundle\Entity\ShareCar;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\MyConstants;
use WWW\HouseBundle\Entity\ShareHouse;

class MobileController extends Controller {
    
    private $offer;
    private $offerPrice;
    
    //EDITARRRRRRRRRRRRR
    public function prepareAction(Request $request) {

        $totalAmount = $request->request->get("total_price");
        $username = $request->request->get("username");
        $pago = $request->request->get("method");
        $idOffer = $request->request->get("id_offer");
        $idService = $request->request->get("id_service");
        $gastosPago = $request->request->get("payment_fee");
        $this->getOffer($request,$idOffer);
        $gastosGestion = $this->offerPrice->getPrice() * (MyConstants::ADMINISTRATION_FEES / 100);
        
        if( $totalAmount > $this->offerPrice->getPrice()){
            
            //Guardamos los datos en la base de datos
            $arrayPay['gastos_gestion'] = $gastosGestion;
            $arrayPay['gastos_pago'] = $gastosPago;
            $arrayPay['gastos_totales'] = $totalAmount;
			$arrayPay['metodo_pago'] = $pago;
			$arrayPay['precio_oferta'] = $this->offerPrice->getPrice();
            if ($this->offer->getService()->getId()== 1 || $this->offer->getService()->getId()== 2) {
                $arrayPay['direccion'] = $request->request->get("address_pay");;
                $arrayPay['metodo_envio'] = $request->request->get("send_method");;
                $arrayPay['gastos_envio'] = $request->request->get("shipping_cost");
                $arrayPay['send_office'] = $request->request->get('send_office');
		$arrayPay['gastos_comprobacion'] = $request->request->get('testing_cost');
            }
            if ($this->offer->getService()->getId() == 6 || $this->offer->getService()->getId() == 7){
                
                $arrayPay['fechaIni']= $request->request->get("arrival_date");
                $arrayPay['fechaFin'] = $request->request->get("departure_date");
                $arrayPay['idCalendar'] = $request->request->get("id_calendar");
                $arrayPay['idInscription'] = $request->request->get("id_inscription");
                $arrayPay['idService'] = $this->offer->getService()->getId();
            
            }
            $arrayPay['idUser'] = $request->request->get('id');
            $arrayPay['username'] = $username;
            $arrayPay['password'] = $request->request->get('password');
			
            $payment = new Payment();
            //numero de referencia por la hora y fecha
            $payment->setNumber(date('His') . 'W' . $idOffer);
            $payment->setClientId(uniqid());
            $payment->setDescription(sprintf('Pago total de %s del cliente %s', $totalAmount*100, $username));
            $payment->setTotalAmount($totalAmount * 100);
            $payment->setCurrencyCode('EUR');
            $payment->setClientEmail($username);
            $payment->setDetails($arrayPay);
            //Comprobamos si el pago que nos llega es por Tarjeta o Paypal
            if ($pago == 'paypal') {

                $storage = $this->getPayum()->getStorage($payment);
                $storage->update($payment);

                $captureToken = $this->getPayum()->getTokenFactory()->createCaptureToken(
                                'paypal_express_checkout_with_ipn_enabled',
                                $payment,
                                'acme_payment_mobile_done'
                );
                return new Response($captureToken->getTargetUrl());

            } else {

                $storage = $this->getPayum()->getStorage('Acme\PaymentBundle\Entity\PaymentDetails');
                $details = $storage->create();
                $details['Ds_Merchant_Amount'] = $totalAmount * 100;
                $details['Ds_Merchant_Currency'] = '978';
                $details['Ds_Merchant_Order'] = date('His') . 'W' . $idOffer;
                $details['Ds_Merchant_TransactionType'] = Api::TRANSACTIONTYPE_AUTHORIZATION;
                $details['Ds_Merchant_ConsumerLanguage'] = Api::CONSUMERLANGUAGE_SPANISH;
                $details['gastos_gestion'] = $gastosGestion;
                $details['gastos_pago'] = $gastosPago;
                $details['gastos_totales'] = $totalAmount;
                $details['metodo_pago'] = $pago;
                $details['precio_oferta'] = $this->offerPrice->getPrice();
                if ($this->offer->getService()->getId()== 1 || $this->offer->getService()->getId()== 2) {
                    $details['direccion'] = $request->request->get("address_pay");;
                    $details['metodo_envio'] = $request->request->get("send_method");;
                    $details['gastos_envio'] = $request->request->get("shipping_cost");
                    $details['send_office'] = $request->request->get('send_office');
					$details['gastos_comprobacion'] = $request->request->get('testing_cost');
                }
                if ($this->offer->getService()->getId() == 6 || $this->offer->getService()->getId() == 7){
                
                    $details['fechaIni']= $request->request->get("arrival_date");
                    $details['fechaFin'] = $request->request->get("departure_date");
                    $details['idCalendar'] = $request->request->get("id_calendar");
                    $details['idInscription'] = $request->request->get("id_inscription");
                    $details['idService'] = $this->offer->getService()->getId();
            
                }
                $details['idUser'] = $request->request->get('id');
                $details['username'] = $username;
		$details['password'] = $request->request->get('password');
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
                $details['Ds_Merchant_UrlKO'] = $captureTokenKO->getAfterUrl() ;

                $payment->setDetails($details);
                $storagePay = $this->getPayum()->getStorage($payment);
                $payment->setDetails($details);
                $storagePay->update($payment);
				
                return new Response($captureTokenOK->getTargetUrl());
                //return new Response($captureToken->getTargetUrl()  );
            }
        }else{
           echo "Tu que vienes... aqui a hacer trampas???";
        }
        
    }

    /**
     * @return Payum
     */
    protected function getPayum() {
        return $this->get('payum');
    }
    private function getOffer(Request $request, $idOffer) {

        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST . "services/offer/get_offer.php";

        $this->offer = null;

        $data['id'] = $idOffer;

        $result = $ch->resultApiRed($data, $file);

        if ($result['result'] == 'ok') {
            $this->offer = new Offer($result);
            if ($this->offer->getService()->getId() == 1 || $this->offer->getService()->getId() == 2) {
                $this->offerPrice = new Trade($result);
            } elseif ($this->offer->getService()->getId() == 4 ) {
                $this->offerPrice = new ShareCar($result);
            } elseif ( $this->offer->getService()->getId() == 5){
                 $idInscription = $request->request->get("id_inscription");
                 $this->getOfferInfo($request, $idInscription);
            } elseif ($this->offer->getService()->getId() == 6 || $this->offer->getService()->getId() == 7) {
                $this->offerPrice = new ShareHouse($result);
            }
        }
    }
    
        private function getOfferInfo(Request $request, $idInscription) {
        $file = MyConstants::PATH_APIREST . 'services/offer/get_infoOffersPrice.php';
        $ch = new ApiRest();

        $data['id'] = $request->request->get('id');;
        $data['username'] = $request->request->get('username');
        $data['password'] = $request->request->get('password');
        $data['offerId'] = $request->request->get("id_offer");
        $data['serviceId'] = 5;
        $data['idInscription'] = $idInscription;
        
        $result = $ch->resultApiRed($data, $file);

        $this->offerPrice = new ShareCar($result['data']);

    }

}

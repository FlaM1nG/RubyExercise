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

class MobileController extends Controller {
    
    private $offer;
    private $offerPrice;
    
    //EDITARRRRRRRRRRRRR
    public function prepareAction(Request $request) {

        $totalAmount = $request->request->get("total_price");
        $username = $request->request->get("username");
        $pago = $request->request->get("method");
        $idOffer = $request->request->get("id_offer");
        
        $gastosPago = $request->request->get("payment_fee");
        $this->getOffer($idOffer);
        $gastosGestion = $this->offerPrice->getPrice() * (MyConstants::ADMINISTRATION_FEES / 100);
        
        if( $amount >= $this->offerPrice->getPrice()){
            
            //Guardamos los datos en la base de datos
            $arrayPay['gastos_gestion'] = $gastosGestion;
            $arrayPay['gastos_pago'] = $gastosPago;
            $arrayPay['gastos_totales'] = $totalAmount;
            if ($this->offer->getService()->getId()== 1 || $this->offer->getService()->getId()== 2) {
                $arrayPay['direccion'] = $request->request->get("address_pay");;
                $arrayPay['metodo_envio'] = $request->request->get("send_method");;
                $arrayPay['gastos_envio'] = $request->request->get("shipping_cost");
                $arrayPay['send_office'] = $request->get('previoPago')['send_office'];
            }
            
            
            $payment = new Payment();
            //numero de referencia por la hora y fecha
            $payment->setNumber(date(date('His') . 'W' . $idOffer));
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
                if ($this->offer->getService()->getId()== 1 || $this->offer->getService()->getId()== 2) {
                    $details['direccion'] = $request->request->get("address_pay");;
                    $details['metodo_envio'] = $request->request->get("send_method");;
                    $details['gastos_envio'] = $request->request->get("shipping_cost");
                    $details['send_office'] = $request->get('previoPago')['send_office'];
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
    private function getOffer($idOffer) {

        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST . "services/offer/get_offer.php";

        $this->offer = null;

        $data['id'] = $idOffer;

        $result = $ch->resultApiRed($data, $file);

        if ($result['result'] == 'ok'){
            $this->offer = new Offer($result);
            if($this->offer->getService()->getId()== 1 || $this->offer->getService()->getId()== 2){
                $this->offerPrice= new Trade($result);
            }
            elseif ($this->offer->getService()->getId()== 4 || $this->offer->getService()->getId()== 5) {
                $this->offerPrice= new ShareCar($result);
        }

       
        }
    }
   
}

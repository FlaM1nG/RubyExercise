<?php
namespace Acme\PaymentBundle\Controller;

require_once $_SERVER['DOCUMENT_ROOT'].'/JS9NAJ8JEABj8jcsk9xbGTC7VSM9XAMbaxnbs3873778dhd4m/vendor/autoload.php';

use Acme\PaymentBundle\Entity\Payment;
use Payum\Core\Payum;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Crevillo\Payum\Redsys\Api;
use Symfony\Component\HttpFoundation\JsonResponse;


class MobileController extends Controller {

    public function prepareAction(Request $request) {

        //Redsys <20

        //Addons >20

                $var=$request->request->get("price");
				//var_dump($request);
                //cargamos el pago por tarjeta sabadell
                $payment = new Payment();
                //numero de referencia por la hora y fecha
                $payment->setNumber(date('ymdHis'));
                $payment->setClientId(uniqid());
                $payment->setDescription(sprintf('An order %s for a client %s',$amount , 'test@test.com'));
                $payment->setTotalAmount( 100);
                $payment->setCurrencyCode('EUR');

                $storage = $this->getPayum()->getStorage('Acme\PaymentBundle\Entity\PaymentDetails');

                $details = $storage->create();
                $details['Ds_Merchant_Amount'] = 100;
                $details['Ds_Merchant_Currency'] = '978';
                $details['Ds_Merchant_Order'] = date('ymdHis');
                $details['Ds_Merchant_TransactionType'] = Api::TRANSACTIONTYPE_AUTHORIZATION;
                $details['Ds_Merchant_ConsumerLanguage'] = Api::CONSUMERLANGUAGE_SPANISH;
                $storage->update($details);

                //Las notificaciones de compra se guardan en la tabla payum_payments_details
                //de ahi se tienen que sacar el DS_Response y manejar la respuesta

                $notifyToken = $this->getPayum()->getTokenFactory()->createNotifyToken(
                        'redsys',
                        $details
                        );

                $details['Ds_Merchant_MerchantURL'] = $notifyToken->getTargetUrl();
                $storagePay = $this->getPayum()->getStorage($payment);
                $payment->setDetails($details);
                $storagePay->update($payment);
                $captureToken = $this->getPayum()->getTokenFactory()->createCaptureToken(
                        'redsys',
                        $payment,
                        'acme_payment_done'
                );

                $details['Ds_Merchant_UrlOK'] = 'https://whatwantweb.com/JS9NAJ8JEABj8jcsk9xbGTC7VSM9XAMbaxnbs3873778dhd4m/web/payment/mobile/ok'; //podriamos poner el setAfterUrl con una direccion de exito o fracaso
                $details['Ds_Merchant_UrlKO'] = 'https://whatwantweb.com/JS9NAJ8JEABj8jcsk9xbGTC7VSM9XAMbaxnbs3873778dhd4m/web/payment/mobile/ko';

                $payment->setDetails($details);
                $storagePay = $this->getPayum()->getStorage($payment);
                $payment->setDetails($details);
                $storagePay->update($payment);

		$response = new JsonResponse();
		$response->setData(array(
                    'result' => $captureToken->getTargetUrl(),
                    'message' => $request->get('price')));
				
		return $response;
                //return new Response($captureToken->getTargetUrl()  );

    }

    /**
     * @return Payum
     */
    protected function getPayum() {
        return $this->get('payum');
    }
}
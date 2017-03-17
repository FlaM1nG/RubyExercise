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
    public function prepareAction(Request $request) {
        //Redsys <20
        //Addons >20
        $user = $this->getUserProfile($request);
        $this->setUpVars($request);

        $form = $this->createForm(PagoType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->get('submit')->isClicked()) {

//            Si el usuario elige pagar con tarjeta (LA CAIXA)
//            if ($form->get('gateway_name')->getData() == 'addon_payments') {
//                //cargamos el pago por tarjeta
//                return $this->redirectToRoute('acme_payment_card', array(
//                            'idOffer' => $this->offer->getOffer()->getId(),
//                            'service' => $this->service,
//                ));
//            }
            $payment = new Payment;
            //numero de referencia por la hora y fecha
            $payment->setNumber(date('ymdHis'));
            $payment->setClientId(uniqid());
            $payment->setDescription(sprintf('An order %s for a client %s', $this->offer->getPrice(), $user->getUsername()));
            $payment->setTotalAmount($this->offer->getPrice() * 100);
            $payment->setCurrencyCode('EUR');

            //REDSYS
            if (isset($request->get('previoPago')['card'])) {
                // 4548812049400004
                // 12/20
                // 123
                // 123456

                $storage = $this->getPayum()->getStorage('Acme\PaymentBundle\Entity\PaymentDetails');
                $details = $storage->create();
                $details['Ds_Merchant_Amount'] = $this->offer->getPrice() * 100;
                $details['Ds_Merchant_Currency'] = '978';
                $details['Ds_Merchant_Order'] = date('ymdHis');
                $details['Ds_Merchant_TransactionType'] = Api::TRANSACTIONTYPE_AUTHORIZATION;
                $details['Ds_Merchant_ConsumerLanguage'] = Api::CONSUMERLANGUAGE_SPANISH;
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
                $captureToken = $this->getPayum()->getTokenFactory()->createCaptureToken(
                        'redsys', $payment, 'acme_payment_done'
                );

                $details['Ds_Merchant_UrlOK'] = $captureToken->getAfterUrl(); //podriamos poner el setAfterUrl con una direccion de exito o fracaso
                $details['Ds_Merchant_UrlKO'] = $captureToken->getAfterUrl();
                $payment->setDetails($details);
                $storagePay = $this->getPayum()->getStorage($payment);
                $payment->setDetails($details);
                $storagePay->update($payment);
                return $this->redirect($captureToken->getTargetUrl());
            }

            //Si no, se paga por PAYPAL
            else {
                
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
     * @return \Symfony\Component\Form\Form
     */
    protected function createPurchaseForm() {

        $formBuilder = $this->createFormBuilder(null, array('data_class' => Payment::class));

        return $formBuilder
                        ->add('gateway_name', 'choice', array(
                            'choices' => array(
                                'paypal_express_checkout_with_ipn_enabled' => 'Paypal ExpressCheckout',
                                'addon_payments' => 'Pago con Tarjeta',
//                    'paypal_pro_checkout' => 'Paypal ProCheckout',
//                    'stripe_js' => 'Stripe.Js',
//                    'stripe_checkout' => 'Stripe Checkout',
//                    'authorize_net' => 'Authorize.Net AIM',
//                    'be2bill' => 'Be2bill',
//                    'be2bill_offsite' => 'Be2bill Offsite',
//                    'payex' => 'Payex',
                                'redsys' => 'Redsys',
//                    'offline' => 'Offline',
//                    'stripe_via_omnipay' => 'Stripe (Omnipay)',
//                    'paypal_express_checkout_via_omnipay' => 'Paypal ExpressCheckout (Omnipay)',
                            ),
                            'mapped' => false,
                            'constraints' => array(new NotBlank())
                        ))
                        ->add('totalAmount', 'number', array(
                            'data' => $this->offer->getPrice(),
                            'constraints' => array(new Range(array('max' => 1000, 'min' => 1)), new NotBlank())
                        ))
                        ->add('currencyCode', 'text', array(
                            'data' => 'EUR',
                            'constraints' => array(new NotBlank())
                        ))
                        ->add('clientEmail', 'text', array(
                            'data' => $this->getUser()->getEmail(),
                            'constraints' => array(new Email(), new NotBlank())
                        ))
                        ->getForm();
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

}

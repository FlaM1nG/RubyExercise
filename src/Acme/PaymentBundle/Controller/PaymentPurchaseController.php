<?php
namespace Acme\PaymentBundle\Controller;

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

class PaymentPurchaseController extends Controller
{
    private $offer;
    
    public function prepareAction(Request $request)
    {
        
       $this->setUpVars($request);
        
        $form = $this->createPurchaseForm();
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Payment $payment */
            $payment = $form->getData();

            $payment->setNumber(date('ymdHis'));
            $payment->setClientId(uniqid());
            $payment->setDescription(sprintf('An order %s for a client %s', $payment->getNumber(), $payment->getClientEmail()));
            $payment->setTotalAmount($this->offer->getPrice()*100);
            $storage = $this->getPayum()->getStorage($payment);
            $storage->update($payment);

            $captureToken = $this->getPayum()->getTokenFactory()->createCaptureToken(
                $form->get('gateway_name')->getData(),
                $payment,
                'acme_payment_done'
            );

            return $this->redirect($captureToken->getTargetUrl());
        }

        return $this->render('AcmePaymentBundle::prepare.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    protected function createPurchaseForm()
    {
        $formBuilder = $this->createFormBuilder(null, array('data_class' => Payment::class));

        return $formBuilder
            ->add('gateway_name', 'choice', array(
                'choices' => array(
                    'paypal_express_checkout_with_ipn_enabled' => 'Paypal ExpressCheckout',
//                    'paypal_pro_checkout' => 'Paypal ProCheckout',
//                    'stripe_js' => 'Stripe.Js',
//                    'stripe_checkout' => 'Stripe Checkout',
//                    'authorize_net' => 'Authorize.Net AIM',
//                    'be2bill' => 'Be2bill',
//                    'be2bill_offsite' => 'Be2bill Offsite',
//                    'payex' => 'Payex',
//                    'redsys' => 'Redsys',
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
            ->getForm()
        ;
    }

    /**
     * @return Payum
     */
    protected function getPayum()
    {
        return $this->get('payum');
    }
    private function getOffer($request){
        
        
        
        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST."services/offer/get_offer.php";

        $this->offer = null;
       
        $data['id'] = $request->get('idOffer');
       
        $result = $ch->resultApiRed($data, $file);
         
        if($result['result'] == 'ok'):
            $this->offer = new Trade($result);
            
        else:
            $this->ut->flashMessage("general", $request);
        endif;

    }
    public function setUpVars(Request $request){
        
        $this->ut = new Utilities(); 
        $this->session = $request->getSession();
        $this->trade = null;

        $path = $request->getPathInfo();
 
        if(strstr($path,'trade')!== false): 
            $this->service = 1;
            $this->getOffer($request);
        elseif(strstr($path,'share-car')!== false):
            $this->getOfferShareCar($request);
        else:
            $this->service = 2;
        endif;

    }
    private function getOfferShareCar(Request $request){

        $file = MyConstants::PATH_APIREST.'services/share_car/get_share_car.php';
        $ch = new ApiRest();
        $this->offer = null;
        $id = $request->get('idOffer');

        $data['id'] = $id;
        $data['option'] = "offer";

        $result = $ch->resultApiRed($data, $file);

        $this->offer = new ShareCar($result);

        return $this->offer;

    }
}

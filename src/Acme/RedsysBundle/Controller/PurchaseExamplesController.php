<?php
namespace Acme\RedsysBundle\Controller;

use Acme\PaymentBundle\Entity\PaymentDetails;
use Crevillo\Payum\Redsys\Api;
use Payum\Core\Payum;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PurchaseExamplesController extends Controller
{
    /**
     * @Extra\Route(
     *   "/prepare",
     *   name="acme_redsys_prepare"
     * )
     *
     * @Extra\Template("AcmeRedsysBundle::prepare.html.twig")
     */
    public function prepareAction(Request $request)
    {
        // 4548 8120 4940 0004
        // 12/20
        // 123
        // 123456

        $gatewayName = 'redsys';

        $form = $this->createPurchaseForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();

            $storage = $this->getPayum()->getStorage('Acme\PaymentBundle\Entity\PaymentDetails');

            /** @var PaymentDetails */
            $payment = $storage->create();
            $payment['Ds_Merchant_Amount'] = $data['amount'];
            $payment['Ds_Merchant_Currency'] = $data['currencyCode'];
            $payment['Ds_Merchant_Order'] = date('ymdHis');
            $payment['Ds_Merchant_TransactionType'] = Api::TRANSACTIONTYPE_AUTHORIZATION;
            $payment['Ds_Merchant_ConsumerLanguage'] = Api::CONSUMERLANGUAGE_SPANISH;
            $storage->update($payment);

            $notifyToken = $this->getPayum()->getTokenFactory()->createNotifyToken($gatewayName, $payment);
            $payment['Ds_Merchant_MerchantURL'] = $notifyToken->getTargetUrl();

            $captureToken = $this->getPayum()->getTokenFactory()->createCaptureToken(
                $gatewayName,
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
        return $this->createFormBuilder()
            ->add('amount', 'text', array('required' => false, 'data' => 123))
            ->add('currencyCode', 'text', array('required' => false, 'data' => '978'))

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
}

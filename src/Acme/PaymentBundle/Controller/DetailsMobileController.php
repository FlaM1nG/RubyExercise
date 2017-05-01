<?php
namespace Acme\PaymentBundle\Controller;

use Payum\Bundle\PayumBundle\Controller\PayumController;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Model\DetailsAggregateInterface;
use Payum\Core\Model\PaymentInterface;
use Payum\Core\Request\GetHumanStatus;
use Payum\Core\Request\Sync;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\MyConstants;
class DetailsMobileController extends PayumController
{
    public function viewAction(Request $request)
    {
        // THIS AN EXAMPLE ACTION. YOU HAVE TO OVERWRITE THIS WITH YOUR OWN ACTION.
        // CHECK THE PAYMENT STATUS AND ACT ACCORDING TO IT.

        $token = $this->getPayum()->getHttpRequestVerifier()->verify($request);

        $gateway = $this->getPayum()->getGateway($token->getGatewayName());

        try {
            $gateway->execute(new Sync($token));
        } catch (RequestNotSupportedException $e) {}

        $gateway->execute($status = new GetHumanStatus($token));

        $refundToken = null;
        $captureToken = null;
        $cancelToken = null;

        if ($status->isCaptured()) {
            $refundToken = $this->getPayum()->getTokenFactory()->createRefundToken(
                $token->getGatewayName(),
                $status->getFirstModel(),
                $request->getUri()
            );
        }
        if ($status->isAuthorized()) {
            $captureToken = $this->getPayum()->getTokenFactory()->createCaptureToken(
                $token->getGatewayName(),
                $status->getFirstModel(),
                $request->getUri()
            );

            $cancelToken = $this->getPayum()->getTokenFactory()->createCancelToken(
                $token->getGatewayName(),
                $status->getFirstModel(),
                $request->getUri()
            );
        }

        
        $details = $status->getFirstModel();
		
        $IDPayment= $details->getNumber();
		
        list($ref,$idOffer)=explode("W",$IDPayment);
        if(!isset($details->getDetails()['CANCELLED'])){   
			
            $this->updateStatus($idOffer,$details,$IDPayment, $request);
			
			if(isset($details->getDetails()['metodo_envio'])){
                if($details->getDetails()['metodo_envio']== 'correos'){
                    $codigo =new CorreosController($this->getDoctrine()->getManager());
                    $idDir= $details->getDetails()['direccion'];
                    //hacer que se llame a esta funcion una vez solo
                    if(isset($details->getDetails()['send_office'])){
                        $sendOffice= 1;
                    }
                    $sendOffice = 0;
                    $arrayDetails = $details->getDetails();
                    $codigo->getTrackingNumberAction($idOffer, $request,$idDir, $sendOffice, $arrayDetails);
                    print_r($codigo);
                }
            }
			
        }
		if ($details instanceof  DetailsAggregateInterface) {
            $details = $details->getDetails();
        }

        if ($details instanceof  \Traversable) {
            $details = iterator_to_array($details);
        }
        
        return new Response(json_encode($details, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
//        return $this->render('AcmePaymentBundle:Details:view.html.twig', array(
//            'status' => $status->getValue(),
//            'payment' => htmlspecialchars(json_encode($details, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)),
//            'gatewayTitle' => ucwords(str_replace(array('_', '-'), ' ', $token->getGatewayName())),
//            'refundToken' => $refundToken,
//            'captureToken' => $captureToken,
//            'cancelToken' => $cancelToken,
//        ));
    }
    private function updateStatus($idOffer,$details,$idPayment,Request $request){
        
        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST . 'services/payment/pay.php';

        $data['id'] = $details->getDetails()['idUser'];
        $data['username'] = $details->getDetails()['username'];
        $data['password'] = $details->getDetails()['password'];
        $data['offer_id'] = $idOffer;
        //secreto = dgv7Hbh5OMmC0Kmx2SDRC
        $extra['idPayment'] = $details->getId();
        $extra['hash'] = hash_hmac('sha512', $details->getNumber(), 'dgv7Hbh5OMmC0Kmx2SDRC');
        $extra['concept']= $details->getDescription();
        $extra['reference'] = $idPayment;
        $extra['price'] = $details->getDetails()['precio_oferta'];
        if(isset($details->getDetails()['metodo_envio'])){
			if($details->getDetails()['metodo_envio'] == correos){
				$extra['mail']['name']= $details->getDetails()['metodo_envio'];
				$extra['mail']['description']= 'paqueteria';
				$extra['mail']['price']= $details->getDetails()['gastos_envio'];
			}
        }
        $extra['pay']['name']= $details->getDetails()['metodo_pago'];
        $extra['pay']['description']= 'metodo de pago';
        $extra['pay']['price']= $details->getDetails()['gastos_pago'];
        
        $data['data']= json_encode($extra);
		
        $result = $ch->resultApiRed($data, $file);
    }
}

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
use Acme\PaymentBundle\Controller\CorreosController;

class DetailsController extends PayumController
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
        if(isset($details->getDetails()['CANCELLED'])){
            return $this->render('pay/postPayPageKO.html.twig',array(
            'details' => $details
            
            ));
        }
        else {
            
            $this->updateStatus($idOffer, $request);
            if(isset($details->getDetails()['metodo_envio'])){
                if($details->getDetails()['metodo_envio']== 'correos'){
                    $codigo =new CorreosController();

                    //hacer que se llame a esta funcion una vez solo           
                    $codigo->getTrackingNumberAction($idOffer, $request, $details->getDetails()['direccion']);
                }
            }
            return $this->render('pay/postPayPageOK.html.twig',array(
            'id' => $IDPayment
            
            ));
        }
        
    }
    
    private function getStatusPayment(){
        
    }
    
    private function updateStatus($idOffer,Request $request){
        
        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST . 'services/inscription/transition.php';

        $data['id'] = $this->getUser()->getId();
        $data['username'] = $this->getUser()->getUsername();
        $data['password'] = $request->getSession()->get('password');
        $data['user_id'] = $this->getUser()->getId();
        $data['offer_id'] = $idOffer;
        $data['status'] = '3';

        $result = $ch->resultApiRed($data, $file);

        var_dump($result);
    }
    
}

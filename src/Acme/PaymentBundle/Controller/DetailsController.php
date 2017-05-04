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
use WWW\GlobalBundle\Entity\MyCompanyEvents;

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
       //Aqui con pillar el get Id de $details nos deberia dar el id para enviar
        $IDPayment= $details->getNumber();
        list($ref,$idOffer)=explode("W",$IDPayment);
        if(isset($details->getDetails()['CANCELLED'])){
            return $this->render('pay/postPayPageKO.html.twig',array(
            'id' => $IDPayment
            
            ));
        }
        else {
            $idService = $details->getDetails()['idService'];
            if($idService== 6 || $idService == 7){
            //House
                $fechainicial = $details->getDetails()['fechaIni'];
                $date = new \DateTime($fechainicial);
                $calendarioId = $details->getDetails()['idCalendar'];
                $fechafinal = $details->getDetails()['fechaFin'];
                $fechaend = $date;
                

                $em = $this->getDoctrine()->getEntityManager();

                $repository = $this->getDoctrine()->getRepository('GlobalBundle:MyCompanyEvents');
                
                $numero_dias = $this->diferenciaDias($fechainicial, $fechafinal); //imprime el numero de dias entre el rango de fecha

                // hacemos un for para insertar

                    for ($n = 0; $n < $numero_dias; $n++) {

                        $test = $repository->findOneBy(array(
                                    'calendarID' => $calendarioId,
                                    'serviceID' => $idService,
                                    'startDatetime' => $date
                        ));

                        if (!$test) {

                            $mce = new MyCompanyEvents('', '€', $details->getDetails()['precio_oferta'], $calendarioId, $idService, null, null, $date, $fechaend, 0, 0, 0, $details->getDetails()['idInscription']);
                            $mce->setOcuppate(true);
                            $em->persist($mce);
                            $em->flush();

                            //vamos sumando un dia a las fechas

                            $fechaend->modify('+1 day');
                            $date = $fechaend;
                        } else {

                            $test->setInscriptionID($details->getDetails()['idInscription']);
                            $test->setOcuppate(true);
                            $em->flush();
                            $fechaend->modify('+1 day');
                            $date = $fechaend;
                        }
                    }
            }
            
            //////////
            
            $this->updateStatus($idOffer,$details,$IDPayment, $request);
            
            if(isset($details->getDetails()['metodo_envio'])){
                if($details->getDetails()['metodo_envio']== 'correos'){
                    $idInscription =  $details->getDetails()['idInscription'];
                    $codigo =new CorreosController($this->getDoctrine()->getManager());
                    $idDir= $details->getDetails()['direccion'];
                    //hacer que se llame a esta funcion una vez solo
                    if(isset($details->getDetails()['send_office'])){
                        $sendOffice= 1;
                    }
                    $sendOffice = 0;
                    $arrayDetails = $details->getDetails();
                    $number = $codigo->getTrackingNumberAction($idOffer, $request,$idDir, $sendOffice,$arrayDetails, $idInscription);
                    $this->saveTrackingNumber($number, $idInscription, $request);
                    //var_dump($number);
                }
            }
            return $this->render('pay/postPayPageOK.html.twig',array(
            'id' => $IDPayment
            
            ));
        }
        
    }
        
        // Funcion para calcular el numero de inserciones por fecha en my_company_events

    function diferenciaDias($inicio, $fin) {
        $inicio = strtotime($inicio);
        $fin = strtotime($fin);
        $dif = $fin - $inicio;
        $diasFalt = (( ( $dif / 60 ) / 60 ) / 24);
        return ceil($diasFalt);
    }
    private function getStatusPayment(){
        
    }
    
    private function updateStatus($idOffer,$details,$idPayment,Request $request){
        
        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST . 'services/payment/pay.php';

        $data['id'] = $this->getUser()->getId();
        $data['username'] = $this->getUser()->getUsername();
        $data['password'] = $request->getSession()->get('password');
        $data['offer_id'] = $idOffer;
        //secreto = dgv7Hbh5OMmC0Kmx2SDRC
        $extra['idPayment'] = $details->getId();
        $extra['hash'] = hash_hmac('sha512', $details->getNumber(), 'dgv7Hbh5OMmC0Kmx2SDRC');
        $extra['concept']= $details->getDescription();
        $extra['reference'] = $idPayment;
        $extra['price'] = $details->getDetails()['precio_oferta'];
        if(isset($details->getDetails()['metodo_envio'])){
            $extra['mail']['name']= $details->getDetails()['metodo_envio'];
            $extra['mail']['description']= 'paqueteria';
            $extra['mail']['price']= $details->getDetails()['gastos_envio'];
        }
        $extra['pay']['name']= $details->getDetails()['metodo_pago'];
        $extra['pay']['description']= 'metodo de pago';
        $extra['pay']['price']= $details->getDetails()['gastos_pago'];
        
        $data['data']= json_encode($extra);

        $result = $ch->resultApiRed($data, $file);
		
    }
    private function saveTrackingNumber($number,$idInscription,Request $request){
        
        $ch = new ApiRest();
        $file = MyConstants::PATH_APIREST . 'services/inscription/update_inscription.php';

        $data['id'] = $this->getUser()->getId();
        $data['username'] = $this->getUser()->getUsername();
        $data['password'] = $request->getSession()->get('password');
        $data['inscription_id'] = $idInscription;
        $data['data'] = $number;
        //secreto = dgv7Hbh5OMmC0Kmx2SDRC
        

        $result = $ch->resultApiRed($data, $file);

        
    }
}

<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WWW\CarsBundle\Form\PagoType;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\Entity\Utilities;
use WWW\GlobalBundle\Form\ContactType;
use WWW\GlobalBundle\Form\CVitaeType;
use WWW\GlobalBundle\MyConstants;
use WWW\UserBundle\Entity\User;

class IndexController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $entrada = array(
            "share_car" => array(
                "faX" => "fa-car",
                "href" => "serShareCar",
                "text" => "Coche Compartido"
            ),
            "courier" => array(
                "faX" => "fa-truck",
                "href" => "serCourier_list",
                "text" => "Paquetería"
            ),
            "money" => array(
                "faX" => "fa-money",
                "href" => "service_listTrade",
                "text" => "Compra/Venta"
            ),
            "ticket" => array(
                "faX" => "fa-ticket",
                "href" => "ticket_service",
                "text" => "Entradas"
            ),
            "alquilerTuristico" => array(
                "faX" => "fa-home",
                "href" => "serHouseRents",
                "text" => "Alquiler turístico"
            ),
            "share_house" => array(
                "faX" => "fa-users",
                "href" => "house_lisShareHouse",
                "text" => "Bed & Breakfast"
            ),
            "swap_house" => array(
                "faX" => "fa-refresh",
                "href" => "house_listHouseSwap",
                "text" => "Intercambio casa"
            ),
            "swap_room" => array(
                "faX" => "fa-exchange",
                "href" => "house_listBedroomSwap",
                "text" => "Intercambio habitación"
            ),
            "clothes" => array(
                "faX" => "fa-child",
                "href" => "service_listClothes",
                "text" => "Ropa"
            ),
            "barter" => array(
                "faX" => "fa-refresh",
                "href" => "service_listBarter",
                "text" => "Trueque"
            ),
        );

        shuffle($entrada);

        // replace this example code with whatever you need
        return $this->render('home/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'servicesFranja' => $entrada
        ));
    }


    public function aboutUsAction() {
        return $this->render('pages/aboutUs.html.twig');
    }

    public function siteMapAction() {
        return $this->render('pages/siteMap.html.twig');
    }

    public function ordersAction() {
        return $this->render('pages/orders.html.twig');
    }

    public function devolutionsAction() {
        return $this->render('pages/devolutions.html.twig');
    }

    public function contactAction(Request $request) {

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if($form->isSubmitted()):

            $file = MyConstants::PATH_APIREST.'global/utils/contact.php';

            $ch = new ApiRest();
            $ut = new Utilities();

            $data['name'] = $request->get('contact')['name'];
            $data['email'] = $request->get('contact')['email'];
            $data['subject'] = $request->get('contact')['subject'];
            $data['message'] = $request->get('contact')['message'];

            $result = $ch->resultApiRed($data, $file);

            $ut->flashMessage('Su mensaje ha sido envíado con éxito.', $request, $result,
                'Oops, ha ocurrido un error, por favor vuélvalo a intentar más tarde');

            $form = $this->createForm(ContactType::class);
        endif;

        return $this->render('pages/contact.html.twig', array('form' => $form->createView()));
    }


    public function trabajaAction(Request $request) {

        $form = $this->createForm(CVitaeType::class);
        $form->handleRequest($request);

        if($form->isSubmitted()):

        $data    = $form->getData();
        $mailer  = $this->get('mailer');

            $file = $data['file'];

            // Generar un numbre único para el archivo antes de guardarlo
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Mover el archivo al directorio donde se guardan los curriculums
            $cvDir = $this->container->getparameter('kernel.root_dir').'/../web/pdfs';
            $file->move($cvDir, $fileName);

            $fromEmail = $data['email'];
            $toEmail   = "carlosamg87@gmail.com";
            //$body      = $data['message'];
            $file 	   = $this->container->getparameter('kernel.root_dir')."/../web/pdfs/$fileName";
            $message = \Swift_Message::newInstance()
                ->setSubject($data['subject'])
                ->setFrom($fromEmail)
                ->setTo($toEmail)
               // ->setBody($body)
               ->addPart('<h1>Datos de - '.$data["name"].'</h1>
               <p>Email: '.$data["email"].'</p>
               <p>Mensaje: '.$data["message"].'</p>', 'text/html')
                ->setContentType('text/html')
                ->attach(\Swift_Attachment::fromPath($file));


        $mailer->send($message);

            // Borramos el fichero en el directorio creado

            unlink($file);


        endif;

        return $this->render('pages/curriculums.html.twig', array('form' => $form->createView()));
    }

    public function ticketAction()
    {
        
        return $this->redirect('https://www.ticketea.com/?a_aid=AFFPAP-whatwantweb');
    }

    public function shippingAction() {
        return $this->render('pages/shipping.html.twig');
    }
    
    public function privacyPolicyAction() {
        return $this->render('pages/privacyPolicy.html.twig');
    }
    
    public function paymentMethodAction() {
        return $this->render('pages/paymentMethod.html.twig');
    }
    
    public function serShareCarAction() {
        return $this->render('services/serShareCar.html.twig');
    }
    
    /*public function serTradeAction() {
        return $this->render('services/serTrade.html.twig');
    }*/
    
    public function serHouseRentsAction() {
        return $this->render('services/serHouseRents.html.twig');
    }
    
    public function offTradeAction() {
        return $this->render('offer/offTrade.html.twig');
    }
    
    public function offHouseRentsAction() {
        return $this->render('offer/offHouseRents.html.twig');
    }
    
    public function offShareCarAction() {
        return $this->render('offer/offShareCar.html.twig');
    }
    
    public function blogAction() {
        return $this->render('blog/blog.html.twig');
    }
    
    public function adminAction() {
        return $this->render('admin/baseAdmin.html.twig');
    }

    public function notFoundAction() {
        return $this->render('TwigBundle:Exception:error404.html.twig');
    }

//    public function pruebaInscripcionAction(){
//        return $this->render('offer/inscription.html.twig');
//    }

    public function pruebaPantallaPagoAction(){
//        $formulario = $this->createForm(PagoType::class);

        return $this->render('pay/payPage.html.twig');
    }

    public function pruebaPantallaPostPagoOKAction(){
//        $formulario = $this->createForm(PagoType::class);

        return $this->render('pay/postPayPageOK.html.twig');
    }

    public function pruebaPantallaPostPagoKOAction(){
//        $formulario = $this->createForm(PagoType::class);

        return $this->render('pay/postPayPageKO.html.twig');
    }

    public function pruebaDatosAdminPanelAction(){
        return $this->render('@User/Register/registerSuccessfull.html.twig');
    }

    public function termsConditionsAction(){
        return $this->render('pages/termsConditions.html.twig');
    }

    public function cookieAction(){
        return $this->render('pages/cookies.html.twig');
    }

    public function servicesPageAction(){
        return $this->render('pages/services.html.twig');
    }
}

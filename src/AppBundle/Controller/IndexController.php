<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WWW\CarsBundle\Form\PagoType;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\Entity\Utilities;
use WWW\GlobalBundle\Form\ContactType;
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
                "href" => "serShareCar",
                "text" => "Mensajeria"
            ),
            "money" => array(
                "faX" => "fa-money",
                "href" => "service_listTrade",
                "text" => "Compra/Venta"
            ),
            "ticket" => array(
                "faX" => "fa-ticket",
                "href" => "service_listTrade",
                "text" => "Entradas Ocio"
            ),
            "alquilerTuristico" => array(
                "faX" => "fa-home",
                "href" => "serHouseRents",
                "text" => "Alquiler turistico"
            ),
            "share_house" => array(
                "faX" => "fa-users",
                "href" => "house_lisShareHouse",
                "text" => "Casa compartida"
            ),
            "swap_house" => array(
                "faX" => "fa-refresh",
                "href" => "house_listHouseSwap",
                "text" => "Intercambio casa"
            ),
            "swap_room" => array(
                "faX" => "fa-exchange",
                "href" => "house_listBedroomSwap",
                "text" => "Intercambio habitaciones"
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
            
            $file = MyConstants::PATH_APIREST.'global/utils/Contact.php';

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
        $usuario = $this->getUser();
        
        $direccion = $usuario->getDefaultAddress();

        return $this->render('pages/pruebaAdmin.html.twig', array(
            'usuario' => $usuario,
            'direccion' => $direccion
        ));
    }

    public function termsConditionsAction(){
        return $this->render('pages/termsConditions.html.twig');
    }

    public function cookieAction(){
        return $this->render('pages/cookies.html.twig');
    }
}

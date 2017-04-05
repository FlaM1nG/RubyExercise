<?php

namespace Acme\PaymentBundle\Controller;

require_once ( 'C:\xampp\htdocs\wwweb\vendor\autoload.php' );

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Postmen\Postmen;
use Symfony\Component\HttpFoundation\Response;

class PruebaCorreosController extends Controller {

    public function indexAction() {
        $api_key = 'e0955a76-61fc-4267-ae31-599f047aca58';
        $region = 'sandbox';

// create Postmen API handler object

        $api = new Postmen($api_key, $region);

        try {
            // as an example we request all the labels

            $result = $api->get('labels');
            echo "RESULT:\n";
            print_r($result);
        } catch (exception $e) {
            // if error occurs we can access all
            // the details in following way

            echo "ERROR:\n";
            echo $e->getCode() . "\n"; // error code
            echo $e->getMessage() . "\n"; // error message
            print_r($e->getDetails()); // details
        }

        return new Response('prueba') ;
    }

}

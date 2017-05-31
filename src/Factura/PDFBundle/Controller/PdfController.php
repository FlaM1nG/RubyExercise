<?php

namespace Factura\PDFBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class PdfController extends Controller
{
    
    public function imprimirPdfBuyerAction(Request $request)
    {

		
        $em = $this->getDoctrine()->getEntityManager();
        $db = $em->getConnection();

        $sesion = $request->getSession();

        $idOferta = $request->get('idOffer');

		if(!empty($request->request->get("id"))){
            if($this->checkUser($request)){
                $id_usuario = $request->request->get("id");
				
            }
            else{
                $json =  array();
                $json['result'] = 'data_error';
                $json['error'] = 'autentication_failed';
                return new Response (json_encode($json));
            }
        }
        else{
            $id_usuario = $sesion->get('id');
        }
        
        //$query = "SELECT address_id FROM billing where user_id=21 and id=2";
        $query1 = "SELECT * FROM user where id=$id_usuario";
        $stmt = $db->prepare($query1);
        $params = array();
        $stmt->execute($params);
        $entities  = $stmt->fetchAll();

        $query2 = "SELECT default_address_id FROM user where id = $id_usuario";
        $stmt = $db->prepare($query2);
        $params = array();
        $stmt->execute($params);
        $default_address  = $stmt->fetchAll();

        $domicilio_def = $default_address[0]["default_address_id"];

        $query3 = "Select * from address where id=$domicilio_def and user_id=$id_usuario";
        $stmt = $db->prepare($query3);
        $params = array();
        $stmt->execute($params);
        $domicilio  = $stmt->fetchAll();

/*
        $query3 = "SELECT * FROM inscription as ins inner join billing as bil on ins.user_id=bil.user_id inner join concept as con on con.billing_id=bil.id where ins.id=con.inscription_id and ins.offer_id=$idOferta";
        $stmt = $db->prepare($query3);
        $params = array();
        $stmt->execute($params);
        $referencia  = $stmt->fetchAll();

*/

        $query4 = "SELECT id,user_id from inscription where offer_id=$idOferta and status='3'";
        $stmt = $db->prepare($query4);
        $params = array();
        $stmt->execute($params);
        $id_inscripcion  = $stmt->fetchAll();



        $id_inscription = $id_inscripcion[0]["id"];
        $id_usu_compra = $id_inscripcion[0]["user_id"];



        $query5 = "SELECT bill.id,bill.date,bill.paid_date,con.reference,con.name,con.iva,con.price,con.description from billing as bill inner join concept as con on con.inscription_id=$id_inscription where user_id=$id_usu_compra and bill.id=con.billing_id";
        $stmt = $db->prepare($query5);
        $params = array();
        $stmt->execute($params);
        $referencia  = $stmt->fetchAll();


        $html = $this->renderView('PDFBundle:Default:index.html.twig',
            array(
                'entities' => $entities,
                'domicilio' => $domicilio,
                'referencia' => $referencia,
            ));
			
		
        //Aquí defino los datos del documento como el tamaño, orientación, título, etc.
        if(!empty($request->request->get("id"))){
            return new Response(
            $html,
            200,
            array(
                    'Content-Type'          => 'text/html; charset=UTF-8',
                    )
            );
        }
        return new Response(
           // $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            $html,    
            200,
            //            array(
//                'Content-Type'          => 'application/pdf',
//                'Content-Disposition'   => 'attachment; filename="Factura.pdf"'
//            )
            array(
                'Content-Type'          => 'text/html; charset=UTF-8',
                )
        );

    }

    public function imprimirPdfSellerAction(Request $request)
    {


        $em = $this->getDoctrine()->getEntityManager();
        $db = $em->getConnection();

        // $sesion = $request->getSession();

        $idOferta = $request->get('idOffer');
        //$query = "SELECT address_id FROM billing where user_id=21 and id=2";

        $query4 = "SELECT user_admin_id from offer where id=$idOferta";
        $stmt = $db->prepare($query4);
        $params = array();
        $stmt->execute($params);
        $id_vende = $stmt->fetchAll();


        $id_usu_vendedor = $id_vende[0]["user_admin_id"];

        $query1 = "SELECT * FROM user where id=$id_usu_vendedor";
        $stmt = $db->prepare($query1);
        $params = array();
        $stmt->execute($params);
        $entities = $stmt->fetchAll();

        $query2 = "SELECT default_address_id FROM user where id =$id_usu_vendedor";
        $stmt = $db->prepare($query2);
        $params = array();
        $stmt->execute($params);
        $default_address = $stmt->fetchAll();

        $domicilio_def = $default_address[0]["default_address_id"];

        $query3 = "Select * from address where id=$domicilio_def and user_id=$id_usu_vendedor";
        $stmt = $db->prepare($query3);
        $params = array();
        $stmt->execute($params);
        $domicilio = $stmt->fetchAll();


        $query5 = "SELECT id from inscription where offer_id=$idOferta and status='3'";
        $stmt = $db->prepare($query5);
        $params = array();
        $stmt->execute($params);
        $id_inscripcion = $stmt->fetchAll();

        $id_inscription = $id_inscripcion[0]["id"];


        $query6 = "SELECT bill.id,bill.date,bill.paid_date,con.reference,con.name,con.iva,con.price,con.description from billing as bill inner join concept as con on con.inscription_id=$id_inscription where bill.id=con.billing_id and bill.user_id=$id_usu_vendedor";
        $stmt = $db->prepare($query6);
        $params = array();
        $stmt->execute($params);
        $referencia = $stmt->fetchAll();


        $html = $this->renderView('PDFBundle:Default:seller.html.twig',
            array(
                'entities' => $entities,
                'domicilio' => $domicilio,
                'referencia' => $referencia,
            ));

        //Aquí defino los datos del documento como el tamaño, orientación, título, etc.

        if(!empty($request->request->get("id"))){
            return new Response(
                $html,
                200,
                array(
                    'Content-Type'          => 'text/html; charset=UTF-8',
                )
            );
        }
        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
//            array(
//                'Content-Type'          => 'application/pdf',
//                'Content-Disposition'   => 'attachment; filename="Factura.pdf"'
//            )
            array(
                'Content-Type'          => 'text/html; charset=UTF-8',
                )
        );

    }
    
    private function checkUser(Request $request){
        $id =$request->request->get("id");
		
        $em = $this->getDoctrine()->getEntityManager();
        $db = $em->getConnection();
        $query1 = "SELECT password FROM user where id=$id";
        $stmt = $db->prepare($query1);
        $params = array();
        $stmt->execute($params);
        $password  = $stmt->fetchAll();
		
        if($password[0]['password']==$request->request->get("password")){
			
            return true;
        }
        else{
            return false;
        }
    }
}

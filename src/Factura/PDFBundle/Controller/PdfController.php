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
            $id_usuario = $request->request->get("id");
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

        $query4 = "SELECT id,user_id from inscription where offer_id=$idOferta";
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
        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="Factura.pdf"'
            )
        );

    }

    public function imprimirPdfSellerAction(Request $request)
    {


        $em = $this->getDoctrine()->getEntityManager();
        $db = $em->getConnection();

        $sesion = $request->getSession();

        $idOferta = $request->get('idOffer');

        if(!empty($request->request->get("id"))){
            $id_usuario = $request->request->get("id");
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



        $query4 = "SELECT user_admin_id from offer where id=$idOferta";
        $stmt = $db->prepare($query4);
        $params = array();
        $stmt->execute($params);
        $id_vende  = $stmt->fetchAll();

        $id_usu_vendedor = $id_vende[0]["user_admin_id"];

        $query5 = "SELECT id,user_id from inscription where offer_id=$idOferta";
        $stmt = $db->prepare($query5);
        $params = array();
        $stmt->execute($params);
        $id_inscripcion  = $stmt->fetchAll();


        $query6 = "SELECT bill.id,bill.date,bill.paid_date,con.reference,con.name,con.iva,con.price,con.description from billing as bill inner join concept as con on con.inscription_id=$id_inscription where user_id=$id_usu_compra and bill.id=con.billing_id";
        $stmt = $db->prepare($query6);
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
        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="Factura.pdf"'
            )
        );

    }

}
    /*     
         
         
    $pdf = $this->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetAuthor('Our Code World');
    $pdf->SetTitle(('Factura'));
    $pdf->SetSubject('Our Code World Subject');
    $pdf->SetPrintHeader(true);
    $pdf->SetPrintFooter(true);   
    //$pdf->SetFont('times', 'BI', 20);
    $pdf->AddPage();
   // $txt = "lo logramos";
   // $pdf ->Write(0,$txt,'',0,'C',true,0,false,false,0);
    
    $html = $this->renderView('PDFBundle:Default:index.html.twig');
    
    $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
    $pdf->Output(__DIR__ . '/../../../../web/pdfs/' . 'ejemplo.pdf', 'F');
    
      return $this->render('PDFBundle:Default:index.html.twig', array(
                   'someDataToView' => 'Something'
                ));
    
     }
     

    /*
    public function returnPDFResponseFromHTML($html){
        //set_time_limit(30); uncomment this line according to your needs
        // If you are not in a controller, retrieve of some way the service container and then retrieve it
        //$pdf = $this->container->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        //if you are in a controlller use :
        $pdf = $this->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetAuthor('Our Code World');
        $pdf->SetTitle(('Factura'));
        $pdf->SetSubject('Our Code World Subject');
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('helvetica', '', 11, '', true);
        
        //$pdf->SetMargins(20,20,40, true);
        $pdf->AddPage();
        
        $filename = 'factura';
        
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
        $pdf->Output($filename.".pdf",'I'); // This will output the PDF as a response directly
}
    
    */
    


     
    
     /*
      * class PdfController extends Controller
{
    
     public function returnPDFResponseFromHTML($html){
    
    $pdf = $this->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetAuthor('Our Code World');
    $pdf->SetTitle(('Factura'));
    $pdf->SetSubject('Our Code World Subject');
    $pdf->SetPrintHeader(true);
    $pdf->SetPrintFooter(true);   
    $pdf->SetFont('times', 'BI', 20);
    $pdf->AddPage();
   // $txt = "lo logramos";
   // $pdf ->Write(0,$txt,'',0,'C',true,0,false,false,0);
    
    $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
    $pdf->Output('example_001.pdf','I'); // This will output the PDF as a response directly
     }
     

    /*
    public function returnPDFResponseFromHTML($html){
        //set_time_limit(30); uncomment this line according to your needs
        // If you are not in a controller, retrieve of some way the service container and then retrieve it
        //$pdf = $this->container->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        //if you are in a controlller use :
        $pdf = $this->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetAuthor('Our Code World');
        $pdf->SetTitle(('Factura'));
        $pdf->SetSubject('Our Code World Subject');
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('helvetica', '', 11, '', true);
        
        //$pdf->SetMargins(20,20,40, true);
        $pdf->AddPage();
        
        $filename = 'factura';
        
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
        $pdf->Output($filename.".pdf",'I'); // This will output the PDF as a response directly
}
    
    
    

    public function imprimirHVPdfAction(){
    // You can send the html as you want
   //$html = '<h1>Plain HTML</h1>';

    // but in this case we will render a symfony view !
    // We are in a controller and we can use renderView function which retrieves the html from a view
    // then we send that html to the user.
    $html = $this->renderView(
         'PDFBundle:Default:index.html.twig',
         array(
          'someDataToView' => 'Something'
         )
    );
    
    $this->returnPDFResponseFromHTML($html);
    }
}
      $html = $this->renderView('PDFBundle:Default:index.html.twig',array());

return new Response(
    $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
    200,
    array(
        'Content-Type'          => 'application/pdf',
        'Content-Disposition'   => 'attachment; filename="file.pdf"'
    )
);



     }
}
    
     
      */
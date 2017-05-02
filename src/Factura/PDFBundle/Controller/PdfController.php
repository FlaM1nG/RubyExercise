<?php

namespace Factura\PDFBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class PdfController extends Controller
{

    public function imprimirHVPdfAction(Request $request)
    {


        $em = $this->getDoctrine()->getEntityManager();
        $db = $em->getConnection();

        $sesion = $request->getSession();

        $idOferta = $request->get('idOffer');
        
        $id_usuario = $sesion->get('id');

        //$query = "SELECT address_id FROM billing where user_id=21 and id=2";
        $query = "SELECT * FROM user where id=$id_usuario";
        $stmt = $db->prepare($query);
        $params = array();
        $stmt->execute($params);
        $entities  = $stmt->fetchAll();

        $query = "SELECT * FROM address where user_id=$id_usuario";
        $stmt = $db->prepare($query);
        $params = array();
        $stmt->execute($params);
        $domicilio  = $stmt->fetchAll();

        $query = "SELECT * FROM inscription as ins inner join billing as bil on ins.user_id=bil.user_id inner join concept as con on con.billing_id=bil.id where ins.user_id=$id_usuario and ins.offer_id=$idOferta";
        $stmt = $db->prepare($query);
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
                'Content-Disposition'   => 'attachment; filename="file.pdf"'
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
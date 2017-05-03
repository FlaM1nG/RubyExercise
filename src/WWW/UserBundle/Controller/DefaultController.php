<?php

namespace WWW\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WWW\GlobalBundle\Entity\Utilities;
use WWW\UserBundle\Entity\User as User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use WWW\GlobalBundle\Entity\ApiRest;
use WWW\GlobalBundle\MyConstants;
use WWW\UserBundle\Form\ForgotPassType;

class DefaultController extends Controller{

    public function pruebaValidationAction(Request $request){
        return $this->render('UserBundle:Validation:validation.html.twig');
    }

    public function pruebaValidationTrueAction(Request $request){
        return $this->render('UserBundle:Validation:validationTrue.html.twig');
    }

    public function pruebaValidationFalseAction(Request $request){
        return $this->render('UserBundle:Validation:validationFalse.html.twig');
    }
    
//    public function indexAction(Request $request)
//    {
//        $session = $request->getSession();
//        return $this->render('::home/index.html.twig');
//    }
    
    /**
     * Matches /change/*
     *
     * @Route("/change/{token}", name="user_change")
     */
    public function changePassAction(Request $request,$token){
        //pillar el usuario segun la relación token - user_id
        $usuario = new User();
       
        $formulario = $this->createForm('WWW\UserBundle\Form\ChangePassType',$usuario);
         
        //El usuario del formulario se asocia al objeto $usuario
        $formulario->handleRequest($request);

        if($formulario->isSubmitted() AND $formulario->isValid()):
            
            $file = MyConstants::PATH_APIREST."user/passwords/new_password.php";
            $ch = new ApiRest();
            $ut = new Utilities();
            
            $data = array("password" => $usuario->getPassword(),
                          "token" => $token);

            $result = $ch->sendInformation($data, $file, "parameters");

            if($result['result'] == 'ok'):
                $ut->flashMessage('Su contraseña ha sido cambiada con éxito', $request,$result, null);
                return $this->redirectToRoute('user_login');

            elseif($result['result'] == 'date_expired'):
                $ut->flashMessage('', $request, $result, 'El enlace ha caducado');

            elseif($result['result'] == 'bad_credentials'):
                $ut->flashMessage('', $request, $result, 'Enlace inválido');

            else:
                $ut->flashMessage('', $request, $result, '');

            endif;
            
            return $this->render('UserBundle:ChangePass:changepass.html.twig',array('formulario'=>$formulario->createView(),'token'=>$token));

        else:
            return $this->render('UserBundle:ChangePass:changepass.html.twig',array('formulario'=>$formulario->createView(),'token'=>$token));
        endif;
                
    }
    
    public function forgotPassAction(Request $request)
    {

        $usuario = new User();

        $formulario = $this->createForm(ForgotPassType::class, $usuario);

        //El usuario del formulario se asocia al objeto $usuario
        $formulario->handleRequest($request);

        if ($formulario->isSubmitted()):

            $file = MyConstants::PATH_APIREST . "user/passwords/forget_password.php";
            $data = array("email" => $usuario->getEmail());

            $ch = new ApiRest();
            $ut = new Utilities();

            $result = $ch->sendInformation($data, $file, "parameters");

            $ut->flashMessage('Se le ha enviado un email para poder acceder a su cuenta.', $request, $result,
                'Oops, ha ocurrido un error, por favor vuélvalo a intentar más tarde.');

            $usuario->setEmail('');
            $formulario = $this->createForm(ForgotPassType::class, $usuario);

            return $this->render('UserBundle:ForgotPass:forgotpass.html.twig', array('formulario' => $formulario->createView()));
        else:

            return $this->render('UserBundle:ForgotPass:forgotpass.html.twig', array('formulario' => $formulario->createView()));
        endif;

    }
    
    public function unSubscribeAction(Request $request){
        return $this->render('UserBundle:Profile:unSubscribe.html.twig');
    }
    
    public function ResendAction(Request $request){
        $usuario = new User();
        $formulario = $this->createForm('WWW\UserBundle\Form\ForgotPassType',$usuario);
         
        //El usuario del formulario se asocia al objeto $usuario
        $formulario->handleRequest($request);
        
        if(!empty($usuario->getEmail())):            

            $file =  MyConstants::PATH_APIREST."user/email/resend_email.php";
            $data = array("email" => $usuario->getEmail());
            $ch = new ApiRest();
            $result = $ch->sendInformation($data, $file, "parameters");            

            return $this->render('UserBundle:ForgotPass:forgotpass.html.twig',array('formulario'=>$formulario->createView()));
        else:
            return $this->render('UserBundle:ForgotPass:forgotpass.html.twig',array('formulario'=>$formulario->createView()));

        endif;

    }

    public function objectsAction(Request $request){
        return $this->render('UserBundle:Profile/Objects:objets.html.twig');
    }
}

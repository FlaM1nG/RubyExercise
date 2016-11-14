<?php

namespace WWW\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Validation;
use WWW\UserBundle\Entity\User as User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use WWW\UserBundle\Entity\Address;
use WWW\GlobalBundle\Entity\Address;
use WWW\UserBundle\Form\ProfileType;

class DefaultController extends Controller{
    
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        return $this->render('UserBundle:Default:index.html.twig');
    }
    
    public function loginAction(Request $request){

        $formulario = $this->createForm('WWW\UserBundle\Form\LoginType');
        
        $formulario->handleRequest($request);

        if($request->getMethod()=="POST"):
            
            $email=$request->request->all()['loginUser']['username'];
            $password=$request->request->all()['loginUser']['password'];  
         
            $ch = curl_init();
            
            // definimos la URL a la que hacemos la petición
            curl_setopt($ch, CURLOPT_URL,"http://www.whatwantweb.com/api_rest/user/registration/login_user.php");
            // indicamos el tipo de petición: POST
            curl_setopt($ch, CURLOPT_POST, TRUE);
            // definimos cada uno de los parámetros
            curl_setopt($ch, CURLOPT_POSTFIELDS, "username=".$email.
                    "&password=".$password."");

 
            // recibimos la respuesta y la guardamos en una variable
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
            $remote_server_output = curl_exec ($ch);
            var_dump($remote_server_output); 
            $data = json_decode($remote_server_output, true);
            echo $data['username'];
            $user = new User();
            
            $data = json_decode($remote_server_output, true);
         
             // cerramos la sesión cURL
            curl_close ($ch);
            
            if($data['result'] == 'ok'):
                
               $session=$request->getSession();
               $session->set("id",$data['id']);
               $session->set("username",$data['username']);
               $session->set("password",$data['password']);
               
               return $this->redirect($this->generateUrl('user_homepage'));
            else:
                $this->get('session')->getFlashBag()->add(
                                'mensaje',
                                'Los datos ingresados no son válidos'
                            );
                return $this->render('UserBundle:Default:login.html.twig',array('formulario'=>$formulario->createView()));
            endif;
        
        else: 
            return $this->render('UserBundle:Default:login.html.twig',array('formulario'=>$formulario->createView()));
        endif;
    }
    
    public function logoutAction(Request $request){
        $session=$request->getSession();
        $session->clear();
         $this->get('session')->getFlashBag()->add(
                                'mensaje',
                                'Se ha cerrado la sesion con exito'
                            );
                    return $this->redirect($this->generateUrl('user_login'));
    }
    
    public function registerAction(Request $request){
        
        $usuario = new User();
       
        $formulario = $this->createForm('WWW\UserBundle\Form\RegisterType',$usuario);
         
        //El usuario del formulario se asocia al objeto $usuario
        $formulario->handleRequest($request);
        
        if($formulario->isValid()):
            
            $ch = curl_init();
            
            // definimos la URL a la que hacemos la petición
            curl_setopt($ch, CURLOPT_URL,"http://www.whatwantweb.com/api_rest/user/restistration/register_user.php");
            // indicamos el tipo de petición: POST
            curl_setopt($ch, CURLOPT_POST, TRUE);
            // definimos cada uno de los parámetros
            curl_setopt($ch, CURLOPT_POSTFIELDS, "username=".$usuario->getUsername().
                    "&email=".$usuario->getEmail().
                    "&date=".$usuario->getBirthdate()->format("YYYY-mm-dd").
                    "&password=".$usuario->getPassword()."");

            // recibimos la respuesta y la guardamos en una variable
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $remote_server_output = curl_exec ($ch);

            // cerramos la sesión cURL
            curl_close ($ch);
            
            return $this->render('UserBundle:Register:register.html.twig',array('formulario'=>$formulario->createView()));
        else:
            return $this->render('UserBundle:Register:register.html.twig',array('formulario'=>$formulario->createView()));
        endif;
                
    }
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
        
        if(!empty($usuario->getPassword())):
            
            $ch = curl_init();
            
            // definimos la URL a la que hacemos la petición
            curl_setopt($ch, CURLOPT_URL,"http://www.whatwantweb.com/api_rest/user/passwords/new_password.php");
            // indicamos el tipo de petición: POST
            curl_setopt($ch, CURLOPT_POST, TRUE);
            // definimos cada uno de los parámetros
            curl_setopt($ch, CURLOPT_POSTFIELDS, 
                    "&password=".$usuario->getPassword().
                    "&token=".$token."");

            // recibimos la respuesta y la guardamos en una variable
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $remote_server_output = curl_exec ($ch);
            print_r($remote_server_output);
            // cerramos la sesión cURL
            curl_close ($ch);
            /*
            //Obtiene la codificador de usuario
            $encoder = $this->get('security.encoder_factory')->getEncoder($usuario);
        
            //Codificamos la contraseña
            $passwordCodificada = $encoder->encodePassword($usuario->getPassword(),$usuario->getSalt());
            $usuario->setPassword($passwordCodificada);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();*/
            
            return $this->render('UserBundle:ChangePass:changepass.html.twig',array('formulario'=>$formulario->createView(),'token'=>$token));
        else:
            return $this->render('UserBundle:ChangePass:changepass.html.twig',array('formulario'=>$formulario->createView(),'token'=>$token));
        endif;
                
    }
    public function forgotPassAction(Request $request){
        
        $usuario = new User();
       
        $formulario = $this->createForm('WWW\UserBundle\Form\ForgotPassType',$usuario);
         
        //El usuario del formulario se asocia al objeto $usuario
        $formulario->handleRequest($request);
        
        if(!empty($usuario->getEmail())):
            print_r("entra");
            $ch = curl_init();
            
            // definimos la URL a la que hacemos la petición
            curl_setopt($ch, CURLOPT_URL,"http://www.whatwantweb.com/api_rest/user/passwords/forget_password.php");
            // indicamos el tipo de petición: POST
            curl_setopt($ch, CURLOPT_POST, TRUE);
            // definimos cada uno de los parámetros
            curl_setopt($ch, CURLOPT_POSTFIELDS, 
                    "&email=".$usuario->getEmail()."");
           
            // recibimos la respuesta y la guardamos en una variable
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $remote_server_output = curl_exec ($ch);
            print_r($remote_server_output);
            // cerramos la sesión cURL
            curl_close ($ch);
            /*
            //Obtiene la codificador de usuario
            $encoder = $this->get('security.encoder_factory')->getEncoder($usuario);
        
            //Codificamos la contraseña
            $passwordCodificada = $encoder->encodePassword($usuario->getPassword(),$usuario->getSalt());
            $usuario->setPassword($passwordCodificada);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();*/
            
            return $this->render('UserBundle:ForgotPass:forgotpass.html.twig',array('formulario'=>$formulario->createView()));
        else:
            
            echo $formulario->getErrorsAsString();
            return $this->render('UserBundle:ForgotPass:forgotpass.html.twig',array('formulario'=>$formulario->createView()));
        endif;
                
    }
    
    public function profileAction(Request $request){ 
        $session=$request->getSession();
        
        $section = null;
       
        $ch = curl_init();
            
        // definimos la URL a la que hacemos la petición
        curl_setopt($ch, CURLOPT_URL,"http://www.whatwantweb.com/api_rest/user/data/get_info_user.php");
        // indicamos el tipo de petición: POST
        curl_setopt($ch, CURLOPT_POST, TRUE);
        // definimos cada uno de los parámetros
        curl_setopt($ch, CURLOPT_POSTFIELDS, "username=".$session->get('username').
                    "&id=".$session->get('id').
                    "&password=".$session->get('password')."");

 
        // recibimos la respuesta y la guardamos en una variable
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
        $remote_server_output = curl_exec ($ch);
            
        $data = json_decode($remote_server_output, true);
         
        // cerramos la sesión cURL
        curl_close ($ch);
        
        $usuario = null;
        $formAddress = null;
        
        
        if($data['result'] == 'ok'):
            
            $usuario = new User($data);
            
            $formulario = $this->createForm(ProfileType::class,$usuario);
            
            //$formulario->handleRequest($request);
          
            if($request->getMethod()=="POST"):
                
                $section = $request->request->all()['section'];
           
                if(array_key_exists('buttonAddAddress',$request->request->all() )):
                    $newAddress = new Address();
                    $usuario->addAddress($newAddress);
         
                    $form = $this->createForm(ProfileType::class,$usuario);

                    return $this->render('UserBundle:Default:profile.html.twig',array('formulario'=>$form->createView(),
                                                                          'usuario'=>$usuario));
                else:

                    if($section == 'sectionAddress')
                        self::profileAddress($usuario,$request);
                    else
                        self::updateProfile($usuario,$request);
                endif;    
            
            endif;
           
        endif;
        
        return $this->render('UserBundle:Default:profile.html.twig',array('formulario'=>$formulario->createView(),
                                                                          'usuario'=>$usuario));
    }
    
        
    private function updateProfile(User $user, Request $request){
        $arrayUser = $request->request->all()['profileUser'];
        $section = $request->request->all()['section'];
        
        echo $section;
        
        $ch = curl_init();
            
        // definimos la URL a la que hacemos la petición
        curl_setopt($ch, CURLOPT_URL,"http://www.whatwantweb.com/api_rest/user/data/update_user.php");
        // indicamos el tipo de petición: POST
        curl_setopt($ch, CURLOPT_POST, TRUE);
        // definimos cada uno de los parámetros
        
        $data = array();
        $data['username']=$user->getUsername();
        $data['id']=$user->getId();
        $data['password']=$user->getPassword();

        if($section == 'sectionPersonal'):
            $fecha = "'".$arrayUser['birthdate']['year'].'-'.$arrayUser['birthdate']['month'].'-'.$arrayUser['birthdate']['day']."'";
        
            $date= \DateTime::createFromFormat('YYYY-mm-dd', $fecha);

            /*if($date >= new\DateTime('today - 18 years')):
                return false;
            endif;*/
            $data['name']="'".$arrayUser['name']."'";
            $data['surname']="'".$arrayUser['surname']."'";
            $data['phone']=$arrayUser['phone'];
            $data['birthdate'] = $fecha;
            $data['sex'] = "'".$arrayUser['sex']."'";

        elseif($section == 'sectionEmail'):
            
            $data['email'] = "'".$arrayUser['email']."'";
            
        elseif($section == 'sectionPassword'):
        
            $data['password'] = $arrayUser['password'];
        
        elseif($section == 'sectionPhoto'):
            
            $data['photo'] = "'".$arrayUser['photo']."'";
            
        elseif($section == 'section'):    
            
            
        endif;
        
        $valor['data'] = json_encode($data);
        
        curl_setopt($ch, CURLOPT_POSTFIELDS,$valor);
        
        // recibimos la respuesta y la guardamos en una variable
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
        $remote_server_output = curl_exec ($ch);
            
        $data = json_decode($remote_server_output, true);

        // cerramos la sesión cURL
        curl_close ($ch);
        
    }
    
    private function profileAddress(User $user, Request $request){
        
        print_r($request->request->all());
        
        if(array_key_exists("idChangeAddress", $request->request->all()) && 
                isset($request->request->all()["idChangeAddress"]) && 
                $request->request->all()["idChangeAddress"] != ""):
            
            $this->updateAddress($user, $request);
        
        elseif(array_key_exists("idDeleteAddress", $request->request->all())&&
                isset($request->request->all()["idDeleteAddress"])):
            
            $this->deleteAddress($user,$request);
        
        else:
            
            $this->addAddress($user,$request);
        
        endif;
  
    }
    
    private function updateAddress(User $user, Request $request){
        
        $arrayAdress = $request->request->all()['profileUser']['addresses'];
        $posArrayAddress = $request->request->all()['idChangeAddress'];
        
        $ch = curl_init();
            
        // definimos la URL a la que hacemos la petición
        curl_setopt($ch, CURLOPT_URL,"http://www.whatwantweb.com/api_rest/user/addresses/update_address.php");
        // indicamos el tipo de petición: POST
        curl_setopt($ch, CURLOPT_POST, TRUE);
        // definimos cada uno de los parámetros
        
        $data = array();
        $data['username']=$user->getUsername();
        $data['id_user']=$user->getId();
        $data['password']=$user->getPassword();
        $data['id'] = $arrayAdress[$posArrayAddress]['id'];
        $data['name'] = "'".$arrayAdress[$posArrayAddress]['name']."'";
        $data['street'] = "'".$arrayAdress[$posArrayAddress]['street']."'";
        
        if(array_key_exists('isDefault',$arrayAdress[$posArrayAddress]))
            $data['is_default'] = 1;
        else
            $data['is_default'] = 0;

        
        $valor['data'] = json_encode($data);
        
        curl_setopt($ch, CURLOPT_POSTFIELDS,$valor);
        
        // recibimos la respuesta y la guardamos en una variable
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
        $remote_server_output = curl_exec ($ch);
            
        $data = json_decode($remote_server_output, true);

        // cerramos la sesión cURL
        curl_close ($ch);
        
    }
    
    private function deleteAddress(User $user, Request $request){
        
        echo "entro";
        
        $arrayAdress = $request->request->all()['profileUser']['addresses'];
        $posArrayAddress = $request->request->all()['idDeleteAddress'];
        
        $ch = curl_init();
            
        // definimos la URL a la que hacemos la petición
        curl_setopt($ch, CURLOPT_URL,"http://www.whatwantweb.com/api_rest/user/addresses/delete_address.php");
        // indicamos el tipo de petición: POST
        curl_setopt($ch, CURLOPT_POST, TRUE);
        // definimos cada uno de los parámetros
        
        $data = array();
        $data['username']=$user->getUsername();
        $data['id_user']=$user->getId();
        $data['password']=$user->getPassword();
        //id de la dirección a borrar
        $data['id'] = $arrayAdress[$posArrayAddress]['id'];
        
        
        $valor['data'] = json_encode($data);
        
        curl_setopt($ch, CURLOPT_POSTFIELDS,$valor);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "username=".$user->getUsername().
                    "&password=".$user->getId()."&id_user=".$user->getId()."&id=". $arrayAdress[$posArrayAddress]['id']);
        
        // recibimos la respuesta y la guardamos en una variable
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
        $remote_server_output = curl_exec ($ch);
            
        $data = json_decode($remote_server_output, true);
        echo "<br>salida<br>";
        print_r($data);

        // cerramos la sesión cURL
        curl_close ($ch);
    }

}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DefaultController
 *
 * @author Rocio
 */

namespace WWW\UserBundle\Controller;

use WWW\UserBundle\Form\Type\ProfileFormType;
use WWW\UserBundle\Form\Type\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WWW\UserBundle\Entity\User;
use WWW\UserBundle\Entity\CodigoPostal;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Event\FilterUserResponseEvent;
 
class DefaultController extends Controller{
    
    public function newAction(){
        
    }
    
    public function showAction(Request $request){
        
        $user = $this->getUser();  
        $form = $this->createForm(new ProfileFormType(),$user);
        
        $product = new CodigoPostal();
        $product->setProvincia('Granada');
        
        /*
        $repository = $this->getDoctrine()->getRepository('WWWUserBundle:CodigoPostal');
        $product = $repository->findOneByPais('España');
        
        
        $product = new CodigoPostal();
        $product->setCiudad('Atarfe');
        $product->setProvincia('Granada');
        $product->setPais('España');

        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();
         * 
         */
        
        return $this->render('FOSUserBundle:Profile:edit.html.twig', array(
            'form' => $form->createView(),
            'cp' =>$product,
        ));
    
        
       
    }
    
    public function loginAction(Request $request)
    {
        /** @var $session \Symfony\Component\HttpFoundation\Session\Session */
        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        return $this->renderLogin(array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
        ));
    }

    /**
     * Renders the login template with the given parameters. Overwrite this function in
     * an extended controller to provide additional data for the login template.
     *
     * @param array $data
     *
     * @return Response
     */
    protected function renderLogin(array $data)
    {
        return $this->render('WWWUserBundle:Security:login.html.twig', $data);
    }

    public function checkAction()
    {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }

    public function logoutAction()
    {
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }
    /**
     * Edit the user.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function editAction(Request $request)
    {
        
        $user = $this->getUser();
        
        /*if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }*/

        /** @var $dispatcher EventDispatcherInterface */
        /*$dispatcher = $this->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }*/

        /** @var $formFactory FactoryInterface */
        //$formFactory = $this->get('fos_user.profile.form.factory');
        
        if($request->request->all()['tabActive'] == 'info'){
            $user->setNombre($request->request->all()['www_user_profile']['nombre']);
            $user->setApellidos($request->request->all()['www_user_profile']['apellidos']);
            if(!empty($request->request->all()['www_user_profile']['tlfn']))
                $user->setTlfn($request->request->all()['www_user_profile']['tlfn']);
            //$user->setFechaNacimiento($request->request->all()['www_user_profile']['fecha_nacimiento']);
            $user->setSexo($request->request->all()['www_user_profile']['sexo']);
            
        }elseif($request->request->all()['tabActive'] == 'credenciales'){
            
            $password1 = $request->request->all()['www_user_profile']['plainPassword']['first'];
            $password2 = $request->request->all()['www_user_profile']['plainPassword']['second'];
            $email = $request->request->all()['www_user_profile']['email'];
            
            //validación email
            if(!empty($email) && filter_var( $email, FILTER_VALIDATE_EMAIL ) !== false )
                    $user->setEmail($email);
            
            //validación contraseña
            if(!empty($password1) && !empty($password2) && $password1 == $password2 && strlen($password1) >= 8 &&
               filter_var($password1, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/([\d]+[A-Za-z]+)|[A-Za-z]+[\d]/"))) !== false)
                    $user->setPassword(password_hash($password1,PASSWORD_DEFAULT));
        }
        
        //Actualiza BBDD
        $userManager = null;
        $userManger = $this->getDoctrine()->getManager();
        $userManger->flush();
        
        $form = $this->createForm(new ProfileFormType(),$user);
        
        return $this->render('FOSUserBundle:Profile:edit.html.twig', array('form' => $form->createView(),
        ));
        
        /*if ($form->isValid()) { echo "entro";
            /** @var $userManager UserManagerInterface 
            $userManager = $this->get('fos_user.user_manager');
            
            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_profile_show');
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }*/

    }
    public function registerAction(Request $request)
    {
        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user = $userManager->createUser();
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $this->createForm(new RegistrationFormType(),$user);
        

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

                $userManager->updateUser($user);

                if (null === $response = $event->getResponse()) {
                    $url = $this->getParameter('fos_user.registration.confirmation.enabled')
                        ? $this->generateUrl('fos_user_registration_confirmed')
                        : $this->generateUrl('www_user_profile');

                    $response = new RedirectResponse($url);
                }

                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                return $response;
            }

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_FAILURE, $event);

            if (null !== $response = $event->getResponse()) {
                return $response;
            }
        }

        return $this->render('FOSUserBundle:Registration:register.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}

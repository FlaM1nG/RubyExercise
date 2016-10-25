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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WWW\UserBundle\Entity\User;
use WWW\UserBundle\Entity\CodigoPostal;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;
 
class DefaultController extends Controller{
    
    public function newAction(){
        
    }
    
    public function showAction(Request $request){
        
        $user = $this->getUser();
       /* if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
*/
        /*
        $form = $this->createForm(new ProfileFormType(),$user);
        
        $product = 2;
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
}

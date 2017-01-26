<?php
/*
 * Este archivo pertenece a la aplicación de prueba Cupon.
 * El código fuente de la aplicación incluye un archivo llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */
namespace AppBundle\Manager;
use WWW\UserBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
/**
 * Esta clase encapsula algunas operaciones que se realizan habitualmente sobre
 * las entidades de tipo Usuario.
 */
class UserManager
{
    /** @var ObjectManager */
    private $em;
    /** @var EncoderFactoryInterface */
    private $encoderFactory;
    /** @var TokenStorageInterface */
    private $tokenStorage;
    
    public function __construct(ObjectManager $entityManager, EncoderFactoryInterface $encoderFactory, TokenStorageInterface $tokenStorage)
    {
        $this->em = $entityManager;
        $this->encoderFactory = $encoderFactory;
        $this->tokenStorage = $tokenStorage;
    }
//              Usar esta funcion para guardar con doctrine los usuarios en la base de datos y asi usar el getUser    
//     /**
//     * @param Usuario $usuario
//     */
//    public function guardar(User $usuario)
//    {
//        $isConfirmed='1';
//        $smsConfirmed='1';
//        $confirmationToken='131324342342';
//        $usuario->setConfirmationToken($confirmationToken);
//        $usuario->setSmsConfirmed($smsConfirmed);
//        $usuario->setIsConfirmed($isConfirmed);
//        $this->em->persist($usuario);
//        $this->em->flush();
//    }
    
    /**
     * @param User $user
     */
    public function login(User $user)
    {
//        print_r($user);exit;
        $token = new UsernamePasswordToken($user, null, 'user', $user->getRoles());
        $this->tokenStorage->setToken($token);
    }
}
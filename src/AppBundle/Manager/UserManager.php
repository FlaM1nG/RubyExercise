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
    
    /**
     * @param User $user
     */
    public function login(User $user)
    {
        $token = new UsernamePasswordToken($user, null, 'user', $user->getRoles());
        $this->tokenStorage->setToken($token);
    }
}
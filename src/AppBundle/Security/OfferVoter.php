<?php
// src/AppBundle/Security/PostVoter.php
namespace AppBundle\Security;

use WWW\UserBundle\Entity\User;
use WWW\UserBundle\Entity\Role;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class OfferVoter extends Voter
{
    // en estos strings puedes poner lo que quieras
    const CREATE = 'create_offer';
    const EDIT = 'edit_offer';
    const DELETE = 'delete_offer';
    const SELECT = 'select_offer';
    
    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    protected function supports($attribute, $subject)
    {
        
        // si el atributo no es uno de los que soportamos, devolver false
        if (!in_array($attribute, array(self::SELECT,  self::CREATE))) {
           
           // print_r('1');
            return false;
        }

        // sólo votar en objetos Post dentro de este voter
        if (!$subject instanceof \WWW\OthersBundle\Entity\Trade) {
            print_r("el objeto no es trade");
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        
        if (!$user instanceof User) {
            // el usuario debe estar logeado; sino, denegar el acceso
            var_dump('El objeto no es de tipo usuario');
            return false;
        }

        // $subject es un objeto Post, gracias al método supports
        /** @var Post $post */
        $trade = $subject;

        switch($attribute) {
            
            case self::SELECT:
                return $this->canSelect($trade, $user,$token );
            case self::CREATE:
                return $this->canCreate($token );
        }

        throw new \LogicException('Este código no debería ser visto');
    }

    
  
    private function canSelect(\WWW\OthersBundle\Entity\Trade $trade, User $user ,TokenInterface $token)
    {
         $user = $token->getUser();
         
        

        
        // esto asume que el objeto tiene un método getOwner()
        // para obtener la entidad del usuario que posee este objeto
        if( $user->getUsername() != $trade->getOffer()->getUserAdmin()->getUsername() && !$trade->getOffer()->getExpired()){
            return true;
            
        }
        else{
            return false;
        }
    }
    private function canCreate( TokenInterface $token)
    {
        
        // ROLE_SUPER_ADMIN can do anything! The power!
        if ($this->decisionManager->decide($token, array('ROLE_USER'))) {
            return true;
        }
        else{
            print_r("no deberia entrar aqui");
        }
    }
}   
?>
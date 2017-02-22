<?php
// src/AppBundle/Security/PostVoter.php
namespace AppBundle\Security;

use WWW\UserBundle\Entity\User;
use WWW\UserBundle\Entity\Role;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class MsgOfferVoter extends Voter
{
    // en estos strings puedes poner lo que quieras
    const CREATE = 'create_msg_offer';
    const COMMENT = 'comment_offer';
    const DELETE = 'delete_msg_offer';
    
    
    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    protected function supports($attribute, $subject)
    {
        // si el atributo no es uno de los que soportamos, devolver false
        if (!in_array($attribute, array(self::CREATE, self::COMMENT, self::DELETE))) {
            return false;
        }

        // sólo votar en objetos Post dentro de este voter
        if (!$subject instanceof \WWW\ServiceBundle\Entity\Offer) {
            print_r("el objeto no es oferta");
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // el usuario debe estar logeado; sino, denegar el acceso
            return false;
        }

        // $subject es un objeto Post, gracias al método supports
        /** @var Post $post */
        $offer = $subject;

        switch($attribute) {
            case self::CREATE:
                return $this->canCreate($offer, $user, $token);
            case self::DELETE:
                return $this->canDelete($offer, $user);
            case self::COMMENT:
                return $this->canComment($offer, $user,$token);
        }

        throw new \LogicException('Este código no debería ser visto');
    }

    private function canCreate(\WWW\ServiceBundle\Entity\Offer $offer, User $user, TokenInterface $token)
    {
        
        $user = $token->getUser();
        // el objeto Post podría tener, por ejemplo, un método isPrivate()
        // que comprueba la propiedad booleana $private
        if( $user->getUsername() != $offer->getUserAdmin()->getUsername() && $this->decisionManager->decide($token, array('ROLE_USER'))){
            return true;
            
        }
        else{
            return false;
        }
    }
    private function canComment(\WWW\ServiceBundle\Entity\Offer $offer, User $user, TokenInterface $token)
    {
        
        $user = $token->getUser();
        // el objeto Post podría tener, por ejemplo, un método isPrivate()
        // que comprueba la propiedad booleana $private
        if( $this->decisionManager->decide($token, array('ROLE_USER'))){
            return true;
            
        }
        else{
            return false;
        }
    }
    
    
}
?>
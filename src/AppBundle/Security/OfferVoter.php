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
        if (!in_array($attribute, array(self::CREATE, self::EDIT, self::DELETE,self::SELECT))) {
            return false;
        }

        // sólo votar en objetos Post dentro de este voter
        if (!$subject instanceof Offer) {
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
        $post = $subject;

        switch($attribute) {
            case self::CREATE:
                return $this->canCreate($post, $user);
            case self::EDIT:
                return $this->canEdit($post, $user);
            case self::DELETE:
                return $this->canDelete($post, $user);
            case self::SELECT:
                return $this->canSelect($post, $user);
        }

        throw new \LogicException('Este código no debería ser visto');
    }

    private function canCreate(Post $post, User $user, TokenInterface $token)
    {
        // si pueden editar, pueden ver
        if ($this->decisionManager->decide($token, array($user->getRole()))) {
            return true;
        }

        // el objeto Post podría tener, por ejemplo, un método isPrivate()
        // que comprueba la propiedad booleana $private
        return !$post->isPrivate();
    }

    private function canEdit(Post $post, User $user)
    {
        // esto asume que el objeto tiene un método getOwner()
        // para obtener la entidad del usuario que posee este objeto
        return $user === $post->getOwner();
    }
    private function canDelete(Post $post, User $user)
    {
        // esto asume que el objeto tiene un método getOwner()
        // para obtener la entidad del usuario que posee este objeto
        return $user === $post->getOwner();
    }
    private function canSelect(Post $post, User $user)
    {
        // esto asume que el objeto tiene un método getOwner()
        // para obtener la entidad del usuario que posee este objeto
        return $user === $post->getOwner();
    }
}
?>
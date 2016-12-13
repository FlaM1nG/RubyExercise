<?php
// src/AppBundle/Security/PostVoter.php
namespace AppBundle\Security;

use WWW\UserBundle\Entity\User;
use WWW\UserBundle\Entity\Role;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class UsrVoter extends Voter
{
    // en estos strings puedes poner lo que quieras
    const VIEW = 'see_usr_profile';
    const EDIT = 'edit_usr_profile';
    const DELETE = 'delete_usr';
    const RATE = 'rate_usr';
    const BLOCK = 'block_usr';
    const REPORT = 'report_issue';
    
    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    protected function supports($attribute, $subject)
    {
        // si el atributo no es uno de los que soportamos, devolver false
        if (!in_array($attribute, array(self::VIEW, self::EDIT, self::DELETE,self::RATE,self::BLOCK,self::REPORT))) {
            return false;
        }

        // sólo votar en objetos Post dentro de este voter
        if (!$subject instanceof Post) {
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
            case self::VIEW:
                return $this->canSee($post, $user);
            case self::EDIT:
                return $this->canEdit($post, $user);
            case self::DELETE:
                return $this->canDelete($post, $user);
            case self::RATE:
                return $this->canRate($post, $user);
            case self::BLOCK:
                return $this->canBlock($post, $user);
            case self::REPORT:
                return $this->canReport($post, $user);
        }

        throw new \LogicException('Este código no debería ser visto');
    }

    private function canSee(Post $post, User $user, TokenInterface $token)
    {
        // si pueden editar, pueden ver
        if ($this->decisionManager->decide($token, array('ROLE_SUPER_ADMIN'))) {
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
    private function canRate(Post $post, User $user)
    {
        // esto asume que el objeto tiene un método getOwner()
        // para obtener la entidad del usuario que posee este objeto
        return $user === $post->getOwner();
    }
    private function canBlock(Post $post, User $user)
    {
        // esto asume que el objeto tiene un método getOwner()
        // para obtener la entidad del usuario que posee este objeto
        return $user === $post->getOwner();
    }
    private function canReport(Post $post, User $user)
    {
        // esto asume que el objeto tiene un método getOwner()
        // para obtener la entidad del usuario que posee este objeto
        return $user === $post->getOwner();
    }
}
?>
<?php

namespace App\Security\Voter;

use App\Entity\Post;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class PostVoter extends Voter
{
    const EDIT = 'edit';

    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject): bool
    {
        if (!in_array($attribute, [self::EDIT])) {
            return false;
        }

        if (!$subject instanceof Post) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        $post = $subject;

        // if the user is anonymous, do not grant access
        if (!$user instanceof User) {
            return false;
        }

        if($this->security->isGranted('ROLE_AUTHOR') && $attribute == self::EDIT) {
            return $this->canEdit($post, $user);
        }

        return false;
    }

    private function canEdit(Post $post, User $user): bool
    {
        return $user === $post->getAuthor();
    }
}

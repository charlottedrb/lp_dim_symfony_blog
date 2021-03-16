<?php

namespace App\Security\Voter;

use App\Entity\Comment;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class CommentVoter extends Voter
{
    const DELETE = 'delete';
    const EDIT = 'edit';

    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject): bool
    {
        if (!in_array($attribute, [self::DELETE, self::EDIT])) {
            return false;
        }

        if (!$subject instanceof Comment) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        $comment = $subject;

        // if the user is anonymous, do not grant access
        if (!$user instanceof User) {
            return false;
        }

        if($this->security->isGranted('ROLE_AUTHOR')) {
            switch ($attribute){
                case self::EDIT:
                    return $this->canEdit($comment, $user);
                case self::DELETE:
                    return $this->canDelete($comment, $user);
            }
        }

        return false;
    }

    private function canDelete(Comment $comment, User $user): bool
    {
        // this assumes that the Comment object has a `getOwner()` method
        return $user === $comment->getAuthor();
    }

    private function canEdit(Comment $comment, User $user): bool
    {
        return $user === $comment->getAuthor();
    }
}

<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class RoleVoter extends Voter
{
    public const ISADMIN = 'ISADMIN';
    public const ISUER = 'ISUSER';

    protected function supports(string $attribute, $user): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::ISADMIN, self::ISUER])
            && $user instanceof \App\Entity\Users;
    }

    protected function voteOnAttribute(string $attribute, $user, TokenInterface $token): bool
    {
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::ISADMIN:
                return $this->isAdmin($user);
                break;
            case self::ISUER:
                return $this->isUser($user);
                break;
        }

        return false;
    }
    private function isAdmin($user)
    {
        if ($user->getRoles() == ["ROLE_ADMIN", "ROLE_USER"]) {
            return true;
        }
        return false;
    }
    private function isUser($user)
    {
        if ($user->getRoles() == ["ROLE_USER"]) {
            return true;
        }
        return false;
    }
}

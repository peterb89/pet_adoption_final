<?php

namespace App\Security\Voter;

use App\Entity\Profile\Profile;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ProfileVoter extends Voter
{
    public const EDIT = 'PROFILE_EDIT';
    public const VIEW = 'PROFILE_VIEW';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::VIEW])
            && $subject instanceof Profile;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token, ?\Symfony\Component\Security\Core\Authorization\Voter\Vote $vote = null): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        /** @var Profile $profile */
        $profile = $subject;

        // Admin can see/edit everything
        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            return true;
        }

        // You can only see/edit your own profile
        return $profile->getUser() === $user;
    }
}
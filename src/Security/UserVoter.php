<?php

namespace App\Security;

use App\Entity\Booking;
use App\Entity\Message;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserVoter extends Voter
{
    public const PROFILE_EDIT = 'PROFILE_EDIT';
    public const BOOKING_ACCESS = 'BOOKING_ACCESS';
    public const MESSAGE_ACCESS = 'MESSAGE_ACCESS';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return match ($attribute) {
            self::PROFILE_EDIT => $subject instanceof User,
            self::BOOKING_ACCESS => $subject instanceof Booking,
            self::MESSAGE_ACCESS => $subject instanceof Message,
            default => false,
        };
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $currentUser = $token->getUser();
        if (!$currentUser instanceof User) {
            return false;
        }

        if (in_array('ROLE_ADMIN', $currentUser->getRoles(), true)) {
            return true;
        }

        return match ($attribute) {
            self::PROFILE_EDIT => $subject instanceof User && $subject->getId() === $currentUser->getId(),
            self::BOOKING_ACCESS => $subject instanceof Booking && (
                $subject->getStudent()?->getId() === $currentUser->getId()
                || $subject->getOffer()?->getMentor()?->getId() === $currentUser->getId()
            ),
            self::MESSAGE_ACCESS => $subject instanceof Message && (
                $subject->getSender()?->getId() === $currentUser->getId()
                || $subject->getRecipient()?->getId() === $currentUser->getId()
            ),
            default => false,
        };
    }
}

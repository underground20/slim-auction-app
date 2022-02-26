<?php

namespace App\Auth\Infrastructure\Doctrine\InMemory;

use App\Auth\Domain\Email;
use App\Auth\Domain\Network;
use App\Auth\Domain\Token;
use App\Auth\Domain\User;
use App\Auth\Domain\UserId;
use App\Auth\Domain\UserRepositoryInterface;
use JetBrains\PhpStorm\Pure;

class UserRepository implements UserRepositoryInterface
{
    private array $emailToUserAssoc;
    private array $confirmTokenToUserAssoc;
    private array $networkToUserAssoc;
    private array $userIdToUserAssoc;
    private array $passwordResetTokenToUserAssoc;

    #[Pure] public function hasByEmail(Email $email): bool
    {
        return isset($this->emailToUserAssoc[$email->getValue()]);
    }

    public function add(User $user): void
    {
        $this->emailToUserAssoc[$user->getEmail()->getValue()] = $user;
        $this->userIdToUserAssoc[(string) $user->getUserId()] = $user;
        if ($user->getConfirmToken() !== null) {
            $this->confirmTokenToUserAssoc[$user->getConfirmToken()->getValue()] = $user;
        }
        if ($user->getPasswordResetToken() !== null) {
            $this->passwordResetTokenToUserAssoc[$user->getPasswordResetToken()->getValue()] = $user;
        }
        if (!empty($user->getNetworks()))
        {
            $network = $user->getNetworks()[0];
            $this->networkToUserAssoc[$network->getIdentity()] = $user;
        }
    }

    #[Pure] public function findByConfirmToken(Token $token): ?User
    {
        return $this->confirmTokenToUserAssoc[$token->getValue()] ?? null;
    }

    #[Pure] public function hasByNetwork(Network $network): bool
    {
        return isset($this->networkToUserAssoc[$network->getIdentity()]);
    }

    public function get(UserId $userId): User
    {
        return $this->userIdToUserAssoc[(string) $userId];
    }

    #[Pure] public function getByEmail(Email $email): User
    {
        return $this->emailToUserAssoc[$email->getValue()];
    }

    #[Pure] public function findByPasswordResetToken(Token $token): ?User
    {
        return $this->passwordResetTokenToUserAssoc[$token->getValue()];
    }
}

<?php

namespace App\Auth\Domain\Service;

use App\Auth\Domain\Email;
use App\Auth\Domain\Exception\UserNotFoundException;
use App\Auth\Domain\Role;
use App\Auth\Domain\Token;
use App\Auth\Domain\UserId;
use App\Auth\Domain\UserRepositoryInterface;

class UserSettingsService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function requestPasswordReset(Email $email, Token $token): void
    {
        $user = $this->userRepository->getByEmail($email);
        $user->requestPasswordReset($token, new \DateTimeImmutable());
    }

    public function resetPassword(Token $token, string $passwordHash): void
    {
        if (!$user = $this->userRepository->findByPasswordResetToken($token))
        {
            throw new UserNotFoundException();
        }

        $user->resetPassword($token, $passwordHash);
    }

    public function changeRole(UserId $userId, Role $role): void
    {
        $user = $this->userRepository->get($userId);
        $user->changeRole($role);
    }
}

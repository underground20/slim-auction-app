<?php

namespace App\Auth\Domain;

class UserAuthenticationService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function requestJoinByEmail(UserId $userId, Email $email, string $passwordHash, Token $token): void
    {
        if ($this->userRepository->hasByEmail($email)) {
            throw new UserAlreadyRegisteredException();
        }

        $user = User::selfRegister($userId, $email, $passwordHash, $token);

        $this->userRepository->add($user);
    }

    public function confirm(Token $token): void
    {
        if (!$user = $this->userRepository->findByConfirmToken($token)) {
            throw new \DomainException('Incorrect token');
        }

        $user->confirmJoin($token);
    }
}

<?php

declare(strict_types=1);

namespace App\Auth\Domain\Service;

use App\Auth\Domain\Email;
use App\Auth\Domain\Exception\IncorrectTokenException;
use App\Auth\Domain\Exception\UserAlreadyRegisteredException;
use App\Auth\Domain\Exception\UserWithNetworkAlreadyExistException;
use App\Auth\Domain\Network;
use App\Auth\Domain\Token;
use App\Auth\Domain\User;
use App\Auth\Domain\UserId;
use App\Auth\Domain\UserRepositoryInterface;

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

    public function confirmJoin(Token $token): void
    {
        if (!$user = $this->userRepository->findByConfirmToken($token)) {
            throw new IncorrectTokenException();
        }

        $user->confirmJoin($token);
    }

    public function joinByNetwork(Email $email, Network $network): void
    {
        if ($this->userRepository->hasByNetwork($network)) {
            throw new UserWithNetworkAlreadyExistException();
        }

        if ($this->userRepository->hasByEmail($email)) {
            throw new UserAlreadyRegisteredException();
        }

        $user = User::joinByNetwork(UserId::generate(), $email, $network);

        $this->userRepository->add($user);
    }

    public function attachNetwork(UserId $userId, Network $network): void
    {
        if ($this->userRepository->hasByNetwork($network)) {
            throw new UserWithNetworkAlreadyExistException();
        }

        $user = $this->userRepository->get($userId);
        $user->attachNetwork($network);
    }
}

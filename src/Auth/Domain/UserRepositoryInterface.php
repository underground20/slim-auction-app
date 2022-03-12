<?php

namespace App\Auth\Domain;

use App\Auth\Domain\Exception\UserNotFoundException;

interface UserRepositoryInterface
{
    public function hasByEmail(Email $email): bool;

    public function add(User $user): void;

    public function findByConfirmToken(Token $token): ?User;

    public function hasByNetwork(Network $network): bool;

    public function get(UserId $userId): User;

    /**
     * @param Email $email
     * @return User
     * @throws UserNotFoundException
     */
    public function getByEmail(Email $email): User;

    public function findByPasswordResetToken(Token $token): ?User;
}

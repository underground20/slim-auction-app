<?php

namespace App\Auth\Domain;

interface UserRepositoryInterface
{
    public function hasByEmail(Email $email): bool;

    public function add(User $user): void;

    public function findByConfirmToken(Token $token): ?User;

    public function hasByNetwork(Network $network): bool;

    public function get(UserId $userId): User;
}

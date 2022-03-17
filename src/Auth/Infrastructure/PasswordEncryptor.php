<?php

declare(strict_types=1);

namespace App\Auth\Infrastructure;

use App\Auth\Service\PasswordEncryptorInterface;

class PasswordEncryptor implements PasswordEncryptorInterface
{
    private int $memoryCost;

    public function __construct(int $memoryCost = PASSWORD_ARGON2_DEFAULT_MEMORY_COST)
    {
        $this->memoryCost = $memoryCost;
    }

    public function encrypt(string $password): string
    {
        return password_hash($password, PASSWORD_ARGON2I, ['memory_cost' => $this->memoryCost]);
    }
}

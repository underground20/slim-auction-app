<?php

declare(strict_types=1);

namespace App\Auth\Service;

interface PasswordEncryptorInterface
{
    public function encrypt(string $password): string;
}

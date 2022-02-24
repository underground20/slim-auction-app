<?php

namespace App\Auth\Service;

interface PasswordEncryptorInterface
{
    public function encrypt(string $password): string;
}

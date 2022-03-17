<?php

declare(strict_types=1);

namespace App\Auth\Command\ResetPassword\Reset;

class Command
{
    public string $newPassword;
    public string $token;
}

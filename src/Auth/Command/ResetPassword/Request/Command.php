<?php

declare(strict_types=1);

namespace App\Auth\Command\ResetPassword\Request;

use Symfony\Component\Validator\Constraints\Email;

class Command
{
    public function __construct(
        #[Email]
        public string $email,
    ) {}
}

<?php

declare(strict_types=1);

namespace App\Auth\Command\ResetPassword\Reset;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class Command
{
    public function __construct(
        #[Length(min: 6, max: 100)]
        public string $newPassword,
        #[NotBlank]
        public string $token
    ) {}
}

<?php

declare(strict_types=1);

namespace App\Auth\Command\Confirm;

use Symfony\Component\Validator\Constraints\NotBlank;

class Command
{
    public function __construct(
        #[NotBlank]
        public string $token,
    ) {}
}

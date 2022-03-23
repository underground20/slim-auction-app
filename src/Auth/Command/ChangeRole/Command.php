<?php

declare(strict_types=1);

namespace App\Auth\Command\ChangeRole;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Uuid;

class Command
{
    public function __construct(
        #[NotBlank]
        #[Uuid]
        public string $userId,
        #[NotBlank]
        public string $role
    ) {}
}

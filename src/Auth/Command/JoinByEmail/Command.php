<?php

namespace App\Auth\Command\JoinByEmail;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;

class Command
{
    public function __construct(
        #[Email]
        public string $email,
        #[Length(min: 6, max: 100)]
        public string $password
    ) {}
}

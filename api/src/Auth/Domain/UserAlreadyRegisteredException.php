<?php

namespace App\Auth\Domain;

use JetBrains\PhpStorm\Pure;

class UserAlreadyRegisteredException extends \DomainException
{
    #[Pure] public function __construct()
    {
        parent::__construct('User already registered');
    }
}

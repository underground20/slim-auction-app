<?php

namespace App\Auth\Domain\Exception;

use JetBrains\PhpStorm\Pure;

class UserNotFoundException extends \DomainException
{
    #[Pure] public function __construct()
    {
        parent::__construct('User not found');
    }
}

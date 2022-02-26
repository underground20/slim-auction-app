<?php

namespace App\Auth\Domain\Exception;

use JetBrains\PhpStorm\Pure;

class UserNotActiveException extends \DomainException
{
    #[Pure] public function __construct()
    {
        parent::__construct('User not active');
    }
}

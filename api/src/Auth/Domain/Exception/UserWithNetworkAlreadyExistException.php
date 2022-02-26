<?php

namespace App\Auth\Domain\Exception;

use JetBrains\PhpStorm\Pure;

class UserWithNetworkAlreadyExistException extends \DomainException
{
    #[Pure] public function __construct()
    {
        parent::__construct('User with network already exist');
    }
}

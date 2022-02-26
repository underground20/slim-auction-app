<?php

namespace App\Auth\Domain\Exception;

use JetBrains\PhpStorm\Pure;

class ExpiredTokenException extends \DomainException
{
    #[Pure] public function __construct()
    {
        parent::__construct('Token is expired');
    }
}

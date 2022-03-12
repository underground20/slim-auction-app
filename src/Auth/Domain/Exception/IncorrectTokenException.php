<?php

namespace App\Auth\Domain\Exception;

use JetBrains\PhpStorm\Pure;

class IncorrectTokenException extends \DomainException
{
    #[Pure] public function __construct()
    {
        parent::__construct('Incorrect token');
    }
}

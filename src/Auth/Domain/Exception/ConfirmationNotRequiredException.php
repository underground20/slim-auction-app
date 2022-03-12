<?php

namespace App\Auth\Domain\Exception;

use JetBrains\PhpStorm\Pure;

class ConfirmationNotRequiredException extends \DomainException
{
    #[Pure] public function __construct()
    {
        parent::__construct('Confirmation is not required');
    }
}

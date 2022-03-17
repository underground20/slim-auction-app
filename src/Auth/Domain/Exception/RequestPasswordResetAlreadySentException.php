<?php

declare(strict_types=1);

namespace App\Auth\Domain\Exception;

use JetBrains\PhpStorm\Pure;

class RequestPasswordResetAlreadySentException extends \DomainException
{
    #[Pure] public function __construct()
    {
        parent::__construct('Request already sent');
    }
}

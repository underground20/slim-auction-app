<?php

declare(strict_types=1);

namespace App\Auth\Domain\Exception;

use JetBrains\PhpStorm\Pure;

class ResetPasswordNotRequestedException extends \DomainException
{
    #[Pure] public function __construct()
    {
        parent::__construct('Reset password not requested');
    }
}

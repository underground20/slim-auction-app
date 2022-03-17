<?php

declare(strict_types=1);

namespace App\Auth\Domain\Exception;

use JetBrains\PhpStorm\Pure;

class NetworkAlreadyAttachedException extends \DomainException
{
    #[Pure] public function __construct()
    {
        parent::__construct('Network already attached');
    }
}

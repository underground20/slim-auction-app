<?php

declare(strict_types=1);

namespace App\Auth\Domain;

enum Status: int
{
    case WAIT = 0;
    case ACTIVE = 1;

    public function isWait(): bool
    {
        return $this === self::WAIT;
    }

    public function isActive(): bool
    {
        return $this === self::ACTIVE;
    }
}

<?php

declare(strict_types=1);

namespace App\Auth\Service;

use App\Auth\Domain\Token;

interface TokenizerInterface
{
    public function generate(\DateTimeImmutable $date): Token;
}

<?php

namespace App\Auth\Service;

use App\Auth\Domain\Token;

interface TokenizerInterface
{
    public function generate(\DateTimeImmutable $date): Token;
}

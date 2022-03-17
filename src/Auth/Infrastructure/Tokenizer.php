<?php

declare(strict_types=1);

namespace App\Auth\Infrastructure;

use App\Auth\Domain\Token;
use App\Auth\Service\TokenizerInterface;
use Ramsey\Uuid\Uuid;

class Tokenizer implements TokenizerInterface
{
    private \DateInterval $interval;

    public function __construct(\DateInterval $interval)
    {
        $this->interval = $interval;
    }

    public function generate(\DateTimeImmutable $date): Token
    {
        return new Token(
            Uuid::uuid4()->toString(),
            $date->add($this->interval)
        );
    }
}

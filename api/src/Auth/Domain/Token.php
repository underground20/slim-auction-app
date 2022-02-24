<?php

namespace App\Auth\Domain;

use Webmozart\Assert\Assert;

class Token
{
    private string $value;
    private \DateTimeImmutable $expiredAt;

    public function __construct(string $value, \DateTimeImmutable $expiredAt)
    {
        Assert::uuid($value);
        $this->value = $value;
        $this->expiredAt = $expiredAt;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getExpiredAt(): \DateTimeImmutable
    {
        return $this->expiredAt;
    }
}

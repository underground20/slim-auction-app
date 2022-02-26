<?php

namespace App\Auth\Domain;

use App\Auth\Domain\Exception\ExpiredTokenException;
use App\Auth\Domain\Exception\IncorrectTokenException;
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

    public function validate(self $token): void
    {
        if (!$this->isEqual($token->getValue())) {
            throw new IncorrectTokenException();
        }

        if ($this->isExpiredTo($token->getExpiredAt())) {
            throw new ExpiredTokenException();
        }
    }

    public function isEqual(string $value): bool
    {
        return $this->value === $value;
    }

    public function isExpiredTo(\DateTimeImmutable $date): bool
    {
        return $this->expiredAt <= $date;
    }
}

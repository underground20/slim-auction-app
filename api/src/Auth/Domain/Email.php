<?php

namespace App\Auth\Domain;

use Webmozart\Assert\Assert;

class Email
{
    private string $value;

    public function __construct(string $value)
    {
        Assert::email($value);

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}

<?php

namespace App\Common;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class AbstractUuid
{
    protected string $value;

    public function __construct(UuidInterface $value)
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value->toString();
    }

    public static function generate(): static
    {
        return new static(Uuid::uuid4());
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}

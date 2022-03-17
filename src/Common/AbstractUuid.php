<?php

declare(strict_types=1);

namespace App\Common;

use JetBrains\PhpStorm\Pure;
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
        return $this->value;
    }

    public static function generate(): static
    {
        return new static(Uuid::uuid4());
    }

    public static function createFromString(string $value): static
    {
        return new static(Uuid::fromString($value));
    }

    #[Pure] public function __toString(): string
    {
        return $this->getValue();
    }
}

<?php

declare(strict_types=1);

namespace App\Auth\Domain;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;
use JetBrains\PhpStorm\Pure;

#[Embeddable]
class Network
{
    #[Column(type: "string", length: 16)]
    private string $name;

    #[Column(type: "string", length: 16)]
    private string $identity;

    public function __construct(string $name, string $identity)
    {
        $this->name = $name;
        $this->identity = $identity;
    }

    #[Pure] public function isEqualTo(self $network): bool
    {
        return $this->identity === $network->getIdentity() && $this->name === $network->getName();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getIdentity(): string
    {
        return $this->identity;
    }
}

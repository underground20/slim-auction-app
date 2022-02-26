<?php

namespace App\Auth\Domain;

use JetBrains\PhpStorm\Pure;

class Network
{
    private string $network;
    private string $identity;

    public function __construct(string $network, string $identity)
    {
        $this->network = $network;
        $this->identity = $identity;
    }

    #[Pure] public function isEqualTo(self $network): bool
    {
        return $this->identity === $network->getIdentity() && $this->network === $network->getNetwork();
    }

    public function getNetwork(): string
    {
        return $this->network;
    }

    public function getIdentity(): string
    {
        return $this->identity;
    }
}

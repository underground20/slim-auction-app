<?php

declare(strict_types=1);

namespace App\Auth\Command\AttachNetwork;

use App\Auth\Domain\Network;
use App\Auth\Domain\Service\UserAuthenticationService;
use App\Auth\Domain\UserId;

class Handler
{
    private UserAuthenticationService $authenticationService;

    public function __construct(UserAuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function handle(Command $command): void
    {
        $this->authenticationService->attachNetwork(
            UserId::createFromString($command->userId),
            new Network($command->network, $command->identity)
        );
    }
}

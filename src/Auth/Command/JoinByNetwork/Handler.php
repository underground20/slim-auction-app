<?php

namespace App\Auth\Command\JoinByNetwork;

use App\Auth\Domain\Email;
use App\Auth\Domain\Network;
use App\Auth\Domain\Service\UserAuthenticationService;

class Handler
{
    private UserAuthenticationService $authenticationService;

    public function __construct(UserAuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function handle(Command $command): void
    {
        $this->authenticationService->joinByNetwork(
            new Email($command->email),
            new Network($command->network, $command->identity)
        );
    }
}

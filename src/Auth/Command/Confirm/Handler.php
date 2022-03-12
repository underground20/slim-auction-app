<?php

namespace App\Auth\Command\Confirm;

use App\Auth\Domain\Service\UserAuthenticationService;
use App\Auth\Domain\Token;

class Handler
{
    private UserAuthenticationService $authenticationService;

    public function __construct(UserAuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function handle(Command $command): void
    {
        $this->authenticationService->confirmJoin(new Token($command->token, new \DateTimeImmutable()));
    }
}

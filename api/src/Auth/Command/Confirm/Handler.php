<?php

namespace App\Auth\Command\Confirm;

use App\Auth\Domain\Token;
use App\Auth\Domain\UserAuthenticationService;

class Handler
{
    private UserAuthenticationService $authenticationService;

    public function __construct(UserAuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function handle(Command $command): void
    {
        $this->authenticationService->confirm(new Token($command->token, new \DateTimeImmutable()));
    }
}

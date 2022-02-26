<?php

namespace App\Auth\Command\ChangeRole;

use App\Auth\Domain\Role;
use App\Auth\Domain\Service\UserSettingsService;
use App\Auth\Domain\UserId;

class Handler
{
    private UserSettingsService $userSettingsService;

    public function __construct(UserSettingsService $userSettingsService)
    {
        $this->userSettingsService = $userSettingsService;
    }

    public function handle(Command $command): void
    {
        $this->userSettingsService->changeRole(
            UserId::createFromString($command->userId),
            Role::tryFrom($command->role)
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Auth\Command\ResetPassword\Reset;

use App\Auth\Domain\Service\UserSettingsService;
use App\Auth\Domain\Token;
use App\Auth\Service\PasswordEncryptorInterface;

class Handler
{
    private UserSettingsService $userSettingsService;
    private PasswordEncryptorInterface $passwordEncryptor;

    public function __construct(UserSettingsService $userSettingsService, PasswordEncryptorInterface $passwordEncryptor)
    {
        $this->userSettingsService = $userSettingsService;
        $this->passwordEncryptor = $passwordEncryptor;
    }

    public function handle(Command $command): void
    {
        $this->userSettingsService->resetPassword(
            new Token($command->token, new \DateTimeImmutable()),
            $this->passwordEncryptor->encrypt($command->newPassword)
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Auth\Command\ResetPassword\Request;

use App\Auth\Domain\Email;
use App\Auth\Domain\Service\UserSettingsService;
use App\Auth\Service\TokenizerInterface;

class Handler
{
    private UserSettingsService $userSettingsService;
    private TokenizerInterface $tokenizer;

    public function __construct(UserSettingsService $userSettingsService, TokenizerInterface $tokenizer)
    {
        $this->userSettingsService = $userSettingsService;
        $this->tokenizer = $tokenizer;
    }

    public function handle(Command $command): void
    {
        $this->userSettingsService->requestPasswordReset(
            new Email($command->email),
            $this->tokenizer->generate(new \DateTimeImmutable())
        );
    }
}

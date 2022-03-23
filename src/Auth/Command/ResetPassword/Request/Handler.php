<?php

declare(strict_types=1);

namespace App\Auth\Command\ResetPassword\Request;

use App\Auth\Domain\Email;
use App\Auth\Domain\Service\UserSettingsService;
use App\Auth\Service\TokenizerInterface;
use App\Auth\Service\TokenSender;

class Handler
{
    private UserSettingsService $userSettingsService;
    private TokenizerInterface $tokenizer;
    private TokenSender $tokenSender;

    public function __construct(
        UserSettingsService $userSettingsService, 
        TokenizerInterface $tokenizer,
        TokenSender $tokenSender,
    ) {
        $this->userSettingsService = $userSettingsService;
        $this->tokenizer = $tokenizer;
        $this->tokenSender = $tokenSender;
    }

    public function handle(Command $command): void
    {
        $this->userSettingsService->requestPasswordReset(
            $email = new Email($command->email),
            $token = $this->tokenizer->generate(new \DateTimeImmutable())
        );
        
        $this->tokenSender->send($email, $token);
    }
}

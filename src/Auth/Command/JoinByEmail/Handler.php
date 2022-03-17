<?php

declare(strict_types=1);

namespace App\Auth\Command\JoinByEmail;

use App\Auth\Domain\Email;
use App\Auth\Domain\Service\UserAuthenticationService;
use App\Auth\Domain\UserId;
use App\Auth\Service\PasswordEncryptorInterface;
use App\Auth\Service\TokenizerInterface;
use App\Auth\Service\TokenSender;

class Handler
{
    private UserAuthenticationService $authenticationService;
    private PasswordEncryptorInterface $passwordEncryptor;
    private TokenizerInterface $tokenizer;
    private TokenSender $tokenSender;

    public function __construct(
        UserAuthenticationService $authenticationService,
        PasswordEncryptorInterface $passwordEncryptor,
        TokenizerInterface $tokenizer,
        TokenSender $tokenSender
    ) {
        $this->authenticationService = $authenticationService;
        $this->passwordEncryptor = $passwordEncryptor;
        $this->tokenizer = $tokenizer;
        $this->tokenSender = $tokenSender;
    }

    public function handle(Command $command): void
    {
        $this->authenticationService->requestJoinByEmail(
            UserId::generate(),
            $email = new Email($command->email),
            $this->passwordEncryptor->encrypt($command->password),
            $token = $this->tokenizer->generate(new \DateTimeImmutable())
        );

        $this->tokenSender->sendUserRegisteredMail($email, $token);
    }
}

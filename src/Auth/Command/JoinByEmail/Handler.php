<?php

namespace App\Auth\Command\JoinByEmail;

use App\Auth\Domain\Email;
use App\Auth\Domain\Service\UserAuthenticationService;
use App\Auth\Domain\UserId;
use App\Auth\Service\PasswordEncryptorInterface;
use App\Auth\Service\TokenizerInterface;

class Handler
{
    private UserAuthenticationService $authenticationService;
    private PasswordEncryptorInterface $passwordEncryptor;
    private TokenizerInterface $tokenizer;

    public function __construct(
        UserAuthenticationService $authenticationService,
        PasswordEncryptorInterface $passwordEncryptor,
        TokenizerInterface $tokenizer
    ) {
        $this->authenticationService = $authenticationService;
        $this->passwordEncryptor = $passwordEncryptor;
        $this->tokenizer = $tokenizer;
    }

    public function handle(Command $command): void
    {
        $this->authenticationService->requestJoinByEmail(
            UserId::generate(),
            new Email($command->email),
            $this->passwordEncryptor->encrypt($command->password),
            $this->tokenizer->generate(new \DateTimeImmutable())
        );
    }
}

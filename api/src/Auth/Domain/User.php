<?php

namespace App\Auth\Domain;

use App\Auth\Domain\Exception\ConfirmationNotRequiredException;

class User
{
    private UserId $userId;
    private Email $email;
    private string $passwordHash;
    private ?Token $confirmToken;
    private Status $status;
    private \DateTimeImmutable $createdAt;

    private function __construct(UserId $userId, Email $email)
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->status = Status::WAIT;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public static function selfRegister(UserId $userId, Email $email, string $passwordHash, Token $token): self
    {
        $self = new self($userId, $email);
        $self->email = $email;
        $self->passwordHash = $passwordHash;
        $self->confirmToken = $token;

        return $self;
    }

    public function confirmJoin(Token $token): void
    {
        if ($this->confirmToken === null) {
            throw new ConfirmationNotRequiredException();
        }

        $this->confirmToken->validate($token);
        $this->status = Status::ACTIVE;
        $this->confirmToken = null;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function changePassword(string $passwordHash): void
    {
        $this->passwordHash = $passwordHash;
    }

    public function getConfirmToken(): ?Token
    {
        return $this->confirmToken;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}

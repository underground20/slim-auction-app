<?php

namespace App\Auth\Domain;

class User
{
    private UserId $userId;
    private Email $email;
    private string $passwordHash;
    private ?Token $token;
    private \DateTimeImmutable $createdAt;

    public function __construct(UserId $userId, Email $email)
    {
        $this->userId = $userId;
        $this->email = $email;
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
        $self->token = $token;

        return $self;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function changePassword(string $passwordHash): void
    {
        $this->passwordHash = $passwordHash;
    }

    public function getToken(): ?Token
    {
        return $this->token;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}

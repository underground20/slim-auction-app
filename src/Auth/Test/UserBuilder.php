<?php

declare(strict_types=1);

namespace App\Auth\Test;

use App\Auth\Domain\Email;
use App\Auth\Domain\Token;
use App\Auth\Domain\User;
use App\Auth\Domain\UserId;
use Ramsey\Uuid\Uuid;

class UserBuilder
{
    private UserId $userId;
    private Email $email;
    private string $passwordHash;
    private \DateTimeImmutable $createdAt;
    private Token $joinConfirmToken;
    private bool $isActive = false;

    public function __construct()
    {
        $this->userId = UserId::generate();
        $this->email = new Email('test@gmail.com');
        $this->passwordHash = 'hash';
        $this->createdAt = new \DateTimeImmutable();
        $this->joinConfirmToken = new Token(Uuid::uuid4()->toString(), $this->createdAt->modify('+1 day'));
    }

    public function build(): User
    {
        $user = User::selfRegister(
            $this->userId,
            $this->email,
            $this->passwordHash,
            $this->joinConfirmToken
        );

        if ($this->isActive) {
            $user->confirmJoin(
                new Token(
                    $this->joinConfirmToken->getValue(),
                    $this->joinConfirmToken->getExpiredAt()->modify('-1 day')
                )
            );
        }

        return $user;
    }

    public function withJoinConfirmToken(Token $token): self
    {
        $clone = clone $this;
        $clone->joinConfirmToken = $token;
        return $clone;
    }

    public function active(): self
    {
        $clone = clone $this;
        $clone->isActive = true;
        return $clone;
    }
}

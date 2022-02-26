<?php

namespace App\Auth\Domain;

use App\Auth\Domain\Exception\ConfirmationNotRequiredException;
use App\Auth\Domain\Exception\NetworkAlreadyAttachedException;

class User
{
    private UserId $userId;
    private Email $email;
    private string $passwordHash;
    private ?Token $confirmToken = null;
    private Status $status;
    private \DateTimeImmutable $createdAt;
    private \ArrayObject $networks;

    private function __construct(UserId $userId, Email $email, Status $status)
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->status = $status;
        $this->createdAt = new \DateTimeImmutable();
        $this->networks = new \ArrayObject();
    }

    public static function selfRegister(UserId $userId, Email $email, string $passwordHash, Token $token): self
    {
        $self = new self($userId, $email, Status::WAIT);
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

    public static function joinByNetwork(UserId $userId, Email $email, Network $network): self
    {
        $user = new self($userId, $email, Status::ACTIVE);
        $user->networks->append($network);

        return $user;
    }

    public function attachNetwork(Network $network)
    {
        /** @var Network $existNetwork */
        foreach ($this->networks as $existNetwork) {
            if ($existNetwork->isEqualTo($network))
            {
                throw new NetworkAlreadyAttachedException();
            }
        }
        $this->networks->append($network);
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return Network[]
     */
    public function getNetworks(): array
    {
        return $this->networks->getArrayCopy();
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function getEmail(): Email
    {
        return $this->email;
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

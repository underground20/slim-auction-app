<?php

declare(strict_types=1);

namespace App\Auth\Domain;

use App\Auth\Domain\Exception\ConfirmationNotRequiredException;
use App\Auth\Domain\Exception\NetworkAlreadyAttachedException;
use App\Auth\Domain\Exception\RequestPasswordResetAlreadySentException;
use App\Auth\Domain\Exception\ResetPasswordNotRequestedException;
use App\Auth\Domain\Exception\UserNotActiveException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: "auth_users")]
class User
{
    #[Column(type: "auth_user_id")]
    #[Id]
    private UserId $userId;

    #[Column(type: "auth_user_email", unique: true)]
    private Email $email;

    #[Column(type: "string", nullable: true)]
    private string $passwordHash;

    #[Embedded(class: Token::class)]
    private ?Token $joinConfirmToken = null;

    #[Column(type: "auth_user_status")]
    private Status $status;

    #[Column(type: "datetime_immutable")]
    private \DateTimeImmutable $createdAt;

    #[Embedded(class: Token::class)]
    private ?Token $passwordResetToken = null;

    #[Column(type: "auth_user_role", length: 16)]
    private Role $role;

    #[OneToMany(mappedBy: "user", targetEntity: UserNetwork::class, cascade: ["all"], orphanRemoval: true)]
    private Collection $networks;

    private function __construct(UserId $userId, Email $email, Status $status)
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->status = $status;
        $this->createdAt = new \DateTimeImmutable();
        $this->networks = new ArrayCollection();
        $this->role = Role::USER;
    }

    public static function selfRegister(UserId $userId, Email $email, string $passwordHash, Token $token): self
    {
        $self = new self($userId, $email, Status::WAIT);
        $self->email = $email;
        $self->passwordHash = $passwordHash;
        $self->joinConfirmToken = $token;

        return $self;
    }

    public function confirmJoin(Token $token): void
    {
        if ($this->joinConfirmToken === null) {
            throw new ConfirmationNotRequiredException();
        }

        $this->joinConfirmToken->validate($token);
        $this->status = Status::ACTIVE;
        $this->joinConfirmToken = null;
    }

    public static function joinByNetwork(UserId $userId, Email $email, Network $network): self
    {
        $user = new self($userId, $email, Status::ACTIVE);
        $user->networks->add(new UserNetwork($user, $network));

        return $user;
    }

    public function attachNetwork(Network $network): void
    {
        /** @var UserNetwork $existNetwork */
        foreach ($this->networks as $existNetwork) {
            if ($existNetwork->getNetwork()->isEqualTo($network)) {
                throw new NetworkAlreadyAttachedException();
            }
        }
        $this->networks->add(new UserNetwork($this, $network));
    }

    public function requestPasswordReset(Token $token, \DateTimeImmutable $date): void
    {
        if (!$this->status->isActive()) {
            throw new UserNotActiveException();
        }
        if ($this->passwordResetToken !== null && !$this->passwordResetToken->isExpiredTo($date)) {
            throw new RequestPasswordResetAlreadySentException();
        }

        $this->passwordResetToken = $token;
    }

    public function resetPassword(Token $token, string $passwordHash): void
    {
        if ($this->passwordResetToken === null) {
            throw new ResetPasswordNotRequestedException();
        }

        $this->passwordResetToken->validate($token);
        $this->passwordHash = $passwordHash;
        $this->passwordResetToken = null;
    }

    public function changeRole(Role $role): void
    {
        $this->role = $role;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getPasswordResetToken(): ?Token
    {
        return $this->passwordResetToken;
    }

    /**
     * @return Network[]
     */
    public function getNetworks(): array
    {
        return $this->networks->map(static fn (UserNetwork $network) => $network->getNetwork())->toArray();
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getJoinConfirmToken(): ?Token
    {
        return $this->joinConfirmToken;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}

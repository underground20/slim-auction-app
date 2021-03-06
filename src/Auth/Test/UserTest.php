<?php

declare(strict_types=1);

namespace App\Auth\Test;

use App\Auth\Domain\Email;
use App\Auth\Domain\Exception\ConfirmationNotRequiredException;
use App\Auth\Domain\Exception\ExpiredTokenException;
use App\Auth\Domain\Exception\IncorrectTokenException;
use App\Auth\Domain\Exception\NetworkAlreadyAttachedException;
use App\Auth\Domain\Network;
use App\Auth\Domain\Token;
use App\Auth\Domain\User;
use App\Auth\Domain\UserId;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UserTest extends TestCase
{
    public function testRegisterSuccess(): void
    {
        $user = User::selfRegister(
            $userId = UserId::generate(),
            $email = new Email('test@gmail.com'),
            $hash = 'hash',
            $token = new Token(Uuid::uuid4()->toString(), new \DateTimeImmutable())
        );

        self::assertEquals($userId, $user->getUserId());
        self::assertEquals($email, $user->getEmail());
        self::assertEquals($hash, $user->getPasswordHash());
        self::assertEquals($token, $user->getJoinConfirmToken());
        self::assertTrue($user->getStatus()->isWait());
        self::assertFalse($user->getStatus()->isActive());
    }

    public function testConfirmRegisterSuccess(): void
    {
        $user = (new UserBuilder())
            ->withJoinConfirmToken($token = new Token(Uuid::uuid4()->toString(), new \DateTimeImmutable()))
            ->build();

        $user->confirmJoin(new Token($token->getValue(), $token->getExpiredAt()->modify('-1 day')));

        self::assertTrue($user->getStatus()->isActive());
        self::assertNull($user->getJoinConfirmToken());
    }

    public function testJoinByNetwork(): void
    {
        $network = new Network('google', 'google-1');
        $user = User::joinByNetwork(UserId::generate(), new Email('test@gmail.com'), $network);

        self::assertTrue($user->getStatus()->isActive());
        self::assertContains($network, $user->getNetworks());
        self::assertEquals($network, $user->getNetworks()[0]);
    }

    public function testAttachNetworkThrowAlreadyAttachedException(): void
    {
        $user = (new UserBuilder())
            ->active()
            ->build();

        $network = new Network('google', 'google-1');
        $user->attachNetwork($network);

        self::expectException(NetworkAlreadyAttachedException::class);
        $user->attachNetwork($network);
    }

    public function testConfirmThrowIncorrectTokenException(): void
    {
        $user = (new UserBuilder())
            ->withJoinConfirmToken($token = new Token(Uuid::uuid4()->toString(), new \DateTimeImmutable()))
            ->build();

        self::expectException(IncorrectTokenException::class);
        $user->confirmJoin(new Token(Uuid::uuid4()->toString(), $token->getExpiredAt()));
    }

    public function testConfirmThrowTokenExpiredException(): void
    {
        $user = (new UserBuilder())
            ->withJoinConfirmToken($token = new Token(Uuid::uuid4()->toString(), new \DateTimeImmutable()))
            ->build();

        self::expectException(ExpiredTokenException::class);
        $user->confirmJoin(new Token($token->getValue(), new \DateTimeImmutable()));
    }

    public function testConfirmThrowUserNotRegisteredException(): void
    {
        $user = (new UserBuilder())
            ->withJoinConfirmToken(new Token(Uuid::uuid4()->toString(), new \DateTimeImmutable()))
            ->active()
            ->build();

        self::expectException(ConfirmationNotRequiredException::class);
        $user->confirmJoin(new Token(Uuid::uuid4()->toString(), new \DateTimeImmutable()));
    }

    public function testRequestPasswordReset(): void
    {
        $user = (new UserBuilder())->active()->build();

        $date = new \DateTimeImmutable();
        $token = new Token(Uuid::uuid4()->toString(), $date);
        $user->requestPasswordReset($token, $date);

        self::assertTrue($user->getPasswordResetToken()->isEqual($token->getValue()));
    }

    public function testPasswordReset(): void
    {
        $user = (new UserBuilder())->active()->build();
        $token = new Token($value = Uuid::uuid4()->toString(), $date = new \DateTimeImmutable());

        $user->requestPasswordReset($token, $date);
        $user->resetPassword(new Token($value, $date->modify('-1 day')), $hash = 'hash');

        self::assertNull($user->getPasswordResetToken());
        self::assertEquals($user->getPasswordHash(), $hash);
    }
}

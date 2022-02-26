<?php

namespace App\Auth\Test;

use App\Auth\Domain\Email;
use App\Auth\Domain\Exception\ExpiredTokenException;
use App\Auth\Domain\Exception\IncorrectTokenException;
use App\Auth\Domain\Exception\ConfirmationNotRequiredException;
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
        self::assertEquals($token, $user->getConfirmToken());
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
        self::assertNull($user->getConfirmToken());
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
}

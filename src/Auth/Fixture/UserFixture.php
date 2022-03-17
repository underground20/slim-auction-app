<?php

declare(strict_types=1);

namespace App\Auth\Fixture;

use App\Auth\Domain\Email;
use App\Auth\Domain\Token;
use App\Auth\Domain\User;
use App\Auth\Domain\UserId;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class UserFixture extends AbstractFixture
{
    private const PASSWORD_HASH= '12345Q';

    public function load(ObjectManager $manager): void
    {
        $user = User::selfRegister(
            UserId::generate(),
            new Email('test@prognik.com'),
            self::PASSWORD_HASH,
            new Token($token = Uuid::uuid4()->toString(), new \DateTimeImmutable('+1 day'))
        );

        $user->confirmJoin(new Token($token, new \DateTimeImmutable()));
        $manager->persist($user);
        $manager->flush();
    }
}

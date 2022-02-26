<?php

namespace App\Auth\Test;

use App\Auth\Domain\Email;
use App\Auth\Domain\Exception\UserAlreadyRegisteredException;
use App\Auth\Domain\Exception\UserWithNetworkAlreadyExistException;
use App\Auth\Domain\Network;
use App\Auth\Domain\Service\UserAuthenticationService;
use App\Auth\Domain\UserRepositoryInterface;
use App\Auth\Infrastructure\Doctrine\InMemory\UserRepository;
use PHPUnit\Framework\TestCase;

class UserAuthenticationServiceTest extends TestCase
{
    private UserRepositoryInterface $userRepo;
    private UserAuthenticationService $authenticationService;

    public function testJoinByNetworkThrowAlreadyExistException(): void
    {
        $network = new Network('google', 'google-1');

        $this->authenticationService->joinByNetwork(new Email('test1@gmail.com'), $network);
        self::expectException(UserWithNetworkAlreadyExistException::class);
        $this->authenticationService->joinByNetwork(new Email('test2@gmail.com'), $network);
    }

    public function testJoinByNetworkThrowUserAlreadyRegisteredException(): void
    {
        $user = (new UserBuilder())
            ->active()
            ->build();
        $this->userRepo->add($user);

        self::expectException(UserAlreadyRegisteredException::class);
        $this->authenticationService->joinByNetwork(new Email('test@gmail.com'), new Network('google', 'google-1'));
    }

    public function testAttachNetwork(): void
    {
        $user = (new UserBuilder())
            ->active()
            ->build();
        $this->userRepo->add($user);
        $network1 = new Network('google', 'google-1');
        $network2 = new Network('yandex', 'yandex-1');

        $this->authenticationService->attachNetwork($user->getUserId(), $network1);
        $this->authenticationService->attachNetwork($user->getUserId(), $network2);

        self::assertCount(2, $user->getNetworks());
        self::assertEquals($network1, $user->getNetworks()[0]);
        self::assertEquals($network2, $user->getNetworks()[1]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepo = new UserRepository();
        $this->authenticationService = new UserAuthenticationService($this->userRepo);
    }
}

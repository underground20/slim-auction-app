<?php

namespace App\Auth\Infrastructure\Doctrine\DBAL;

use App\Auth\Domain\Email;
use App\Auth\Domain\Exception\UserNotFoundException;
use App\Auth\Domain\Network;
use App\Auth\Domain\Token;
use App\Auth\Domain\User;
use App\Auth\Domain\UserId;
use App\Auth\Domain\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class UserRepository implements UserRepositoryInterface
{
    private EntityManagerInterface $em;
    private EntityRepository $repo;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repo = $this->em->getRepository(User::class);
    }

    public function hasByEmail(Email $email): bool
    {
        return $this->repo->createQueryBuilder('u')
            ->select('COUNT(u.userId)')
            ->where('u.email = :email')
            ->setParameter(':email', $email->getValue())
            ->getQuery()->getSingleScalarResult() > 0;
    }

    public function add(User $user): void
    {
        $this->em->persist($user);
    }

    public function findByConfirmToken(Token $token): ?User
    {
        return $this->repo->findOneBy(['joinConfirmToken.value' => $token->getValue()]);
    }

    public function hasByNetwork(Network $network): bool
    {
        return $this->repo->createQueryBuilder('u')
            ->select('COUNT(u.userId)')
            ->innerJoin('u.networks', 'n')
            ->where('n.network.name = :name')
            ->andWhere('n.network.identity = :identity')
            ->setParameter(':name', $network->getName())
            ->setParameter(':identity', $network->getIdentity())
            ->getQuery()->getSingleScalarResult() > 0;
    }

    public function get(UserId $userId): User
    {
        $user = $this->repo->find($userId->getValue());
        if ($user === null) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    public function getByEmail(Email $email): User
    {
        $user = $this->repo->findOneBy(['email' => $email->getValue()]);
        if ($user === null) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    public function findByPasswordResetToken(Token $token): ?User
    {
        return $this->repo->findOneBy(['passwordResetToken.value' => $token->getValue()]);
    }
}

<?php

declare(strict_types=1);

use App\Auth\Domain\UserRepositoryInterface;
use App\Auth\Infrastructure\Doctrine\DBAL\UserRepository;
use App\Auth\Infrastructure\PasswordEncryptor;
use App\Auth\Infrastructure\Tokenizer;
use App\Auth\Service\PasswordEncryptorInterface;
use App\Auth\Service\TokenizerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

return [
    UserRepositoryInterface::class => static function (ContainerInterface $container): UserRepositoryInterface {
        $em = $container->get(EntityManagerInterface::class);
        return new UserRepository($em);
    },
    TokenizerInterface::class => static function (ContainerInterface $container): TokenizerInterface {
        return new Tokenizer(new DateInterval($container->get('config')['token_ttl']));
    },
    PasswordEncryptorInterface::class => static fn (): PasswordEncryptorInterface => new PasswordEncryptor(),

    'config' => [
        'token_ttl' => 'PT1H',
    ],
];

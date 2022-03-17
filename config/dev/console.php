<?php

declare(strict_types=1);

use App\Console\FixturesLoadCommand;
use Doctrine\Migrations\Tools\Console\Command\DiffCommand;
use Doctrine\Migrations\Tools\Console\Command\ExecuteCommand;
use Doctrine\Migrations\Tools\Console\Command\GenerateCommand;
use Doctrine\Migrations\Tools\Console\Command\MigrateCommand;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\DropCommand;
use Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand;
use Psr\Container\ContainerInterface;

return [
    FixturesLoadCommand::class => static function (ContainerInterface $container) {
        $config = $container->get('config')['console'];
        $em = $container->get(EntityManagerInterface::class);

        return new FixturesLoadCommand($em, $config['fixture_paths']);
    },

    'config' => [
        'console' => [
            'commands' => [
                FixturesLoadCommand::class,
                ValidateSchemaCommand::class,
                DropCommand::class,
                ExecuteCommand::class,
                DiffCommand::class,
                MigrateCommand::class,
                GenerateCommand::class,
            ],
            'fixture_paths' => [
                __DIR__ . '/../../src/Auth/Fixture',
            ],
        ],
    ],
];

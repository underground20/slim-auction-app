<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;

require __DIR__ . '/../vendor/autoload.php';

/** @var ContainerInterface $container */
$container = (require __DIR__ . '/../config/container.php')();

$app = new Application();

$commands = $container->get('config')['console']['commands'];
foreach ($commands as $command) {
    $app->add($container->get($command));
}

$app->run();

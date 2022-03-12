<?php

declare(strict_types=1);

use App\Http\Middleware\Flusher;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Slim\App;

return static function (App $app, ContainerInterface $container): void {
    /** @psalm-var array{debug:bool} */
    $config = $container->get('config');
    $em = $container->get(EntityManagerInterface::class);

    $app->addErrorMiddleware($config['debug'], true, true);
    $app->addMiddleware(new Flusher($em));
};

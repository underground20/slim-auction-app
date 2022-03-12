<?php

declare(strict_types=1);

use App\Http\Middleware\Flusher;
use App\Http\Middleware\ValidationExceptionHandler;
use Doctrine\ORM\EntityManagerInterface;
use Slim\App;

return static function (App $app): void {
    $container = $app->getContainer();
    /** @psalm-var array{debug:bool} */
    $config = $container->get('config');
    $em = $container->get(EntityManagerInterface::class);

    $app->addBodyParsingMiddleware();
    $app->addMiddleware(new ValidationExceptionHandler());
    $app->addErrorMiddleware($config['debug'], true, true);
    $app->addMiddleware(new Flusher($em));
};

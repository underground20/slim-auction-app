<?php

declare(strict_types=1);

use App\Http\Middleware\DomainExceptionHandler;
use App\Http\Middleware\Flusher;
use App\Http\Middleware\ValidationExceptionHandler;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;

return static function (App $app): void {
    /** @var ContainerInterface $container */
    $container = $app->getContainer();
    $em = $container->get(EntityManagerInterface::class);

    $app->addBodyParsingMiddleware();
    $app->addMiddleware(new ValidationExceptionHandler());
    $app->add(DomainExceptionHandler::class);
    $app->add(ErrorMiddleware::class);

    $app->addMiddleware(new Flusher($em));
};

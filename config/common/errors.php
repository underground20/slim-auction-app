<?php

use App\ErrorHandler\SentryDecorator;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Log\LoggerInterface;
use Slim\Handlers\ErrorHandler;
use Slim\Interfaces\CallableResolverInterface;
use Slim\Middleware\ErrorMiddleware;

return [
    ErrorMiddleware::class => static function (ContainerInterface $container): ErrorMiddleware {
        $callableResolver = $container->get(CallableResolverInterface::class);
        $responseFactory = $container->get(ResponseFactoryInterface::class);
        $config = $container->get('config')['errors'];

        $middleware = new ErrorMiddleware(
            $callableResolver,
            $responseFactory,
            $config['display_errors'],
            $config['log'],
            true
        );

        $logger = $container->get(LoggerInterface::class);
        $middleware->setDefaultErrorHandler(
            new SentryDecorator(
                new ErrorHandler($callableResolver, $responseFactory, $logger)
            )
        );

        return $middleware;
    },

    'config' => [
        'errors' => [
            'display_errors' => (bool)getenv('APP_DEBUG'),
            'log' => true
        ]
    ]
];
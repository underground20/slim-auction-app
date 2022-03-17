<?php

declare(strict_types=1);

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return [
    LoggerInterface::class => static function (ContainerInterface $container): LoggerInterface {
        $config = $container->get('config')['logger'];
        $level = $config['debug'] ? Logger::DEBUG : Logger::INFO;
        $logger = new Logger('api');
        if ($config['stderr']) {
            $logger->pushHandler(new StreamHandler('php://stderr', $level));
        }
        if (!empty($config['file'])) {
            $logger->pushHandler(new StreamHandler($config['file'], $level));
        }

        return $logger;
    },

    'config' => [
        'logger' => [
            'debug' => (bool)getenv('APP_DEBUG'),
            'file' => null,
            'stderr' => true,
        ],
    ],
];

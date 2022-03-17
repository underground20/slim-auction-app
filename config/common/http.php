<?php

declare(strict_types=1);

use Laminas\Diactoros\ResponseFactory;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\CallableResolver;
use Slim\Interfaces\CallableResolverInterface;

return [
    CallableResolverInterface::class => static fn (ContainerInterface $container): CallableResolverInterface => new CallableResolver($container),
    ResponseFactoryInterface::class => static fn (): ResponseFactoryInterface => new ResponseFactory(),
];

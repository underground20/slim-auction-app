<?php

namespace Test\Functional;

use Laminas\Diactoros\ServerRequestFactory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

class WebTestCase extends TestCase
{
    protected static function json(string $method, string $path, array $body = []): ServerRequestInterface
    {
        $request = self::request($method, $path)
            ->withHeader('Accept', 'application/json')
            ->withHeader('Content-Type', 'application/json');
        $request->getBody()->write(json_encode($body, JSON_THROW_ON_ERROR));
        return $request;
    }

    protected static function request(string $method, string $path): ServerRequestInterface
    {
        return (new ServerRequestFactory())->createServerRequest($method, $path);
    }

    protected function app(): App
    {
        $container = require __DIR__ . '/../../config/container.php';
        /** @var App $app */
        return (require __DIR__ . '/../../config/app.php')($container);
    }
}

<?php

namespace App\Http\Action;

use App\Auth\Command\JoinByEmail\Command;
use App\Auth\Command\JoinByEmail\Handler;
use Laminas\Diactoros\Response\EmptyResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class JoinByEmailAction implements RequestHandlerInterface
{
    private Handler $handler;

    public function __construct(Handler $handler)
    {
        $this->handler = $handler;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();
        $command = new Command();
        $command->email = $data['email'];
        $command->password = $data['password'];
        $this->handler->handle($command);

        return new EmptyResponse(201);
    }
}
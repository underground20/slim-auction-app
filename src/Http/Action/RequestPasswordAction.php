<?php

namespace App\Http\Action;

use App\Auth\Command\ResetPassword\Request\Command;
use App\Auth\Command\ResetPassword\Request\Handler;
use App\Common\Validation\Validator;
use Laminas\Diactoros\Response\EmptyResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RequestPasswordAction implements RequestHandlerInterface
{
    private Handler $handler;
    private Validator $validator;

    public function __construct(Handler $handler, Validator $validator)
    {
        $this->handler = $handler;
        $this->validator = $validator;
    }
    
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();
        $command = new Command($data['email']);
        $this->validator->validate($command);
        
        $this->handler->handle($command);
        
        return new EmptyResponse(200);
    }
}
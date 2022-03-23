<?php

declare(strict_types=1);

use App\Auth\Service\TokenSender;
use Psr\Container\ContainerInterface;
use Symfony\Component\Mailer\MailerInterface;

return [
    TokenSender::class => static function (ContainerInterface $container): TokenSender {
        $mailer = $container->get(MailerInterface::class);
        $config = $container->get('config')['mailer'];
        
        return new TokenSender($mailer, $config['from']);
    },
    
    'config' => [
        'mailer' => [
            'from' => 'test@gmail.com'
        ],
    ],
];
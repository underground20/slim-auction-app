<?php

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;

return [
    MailerInterface::class => static function(): MailerInterface {
        $transport = new EsmtpTransport('mailer', '1025');

        return new Mailer($transport);
    }
];
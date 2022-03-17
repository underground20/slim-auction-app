<?php

declare(strict_types=1);

namespace App\Auth\Service;

use App\Auth\Domain\Token;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class TokenSender
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendUserRegisteredMail(\App\Auth\Domain\Email $email, Token $token): void
    {
        $message = (new Email())
            ->from('test1@gmail.com')
            ->to($email->getValue())
            ->subject('Email confirmation')
            ->text("Your token: {$token->getValue()}, expired at
                 {$token->getExpiredAt()->format("h:i:s Y-m-d")}");

        $this->mailer->send($message);
    }
}

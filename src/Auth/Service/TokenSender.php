<?php

declare(strict_types=1);

namespace App\Auth\Service;

use App\Auth\Domain\Token;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class TokenSender
{
    private MailerInterface $mailer;
    private string $from;

    public function __construct(MailerInterface $mailer, string $from)
    {
        $this->mailer = $mailer;
        $this->from = $from;
    }

    public function send(\App\Auth\Domain\Email $email, Token $token): void
    {
        $message = (new Email())
            ->from($this->from)
            ->to($email->getValue())
            ->subject('Token for action')
            ->text("Your token: {$token->getValue()}, expired at
                 {$token->getExpiredAt()->format("h:i:s Y-m-d")}");

        $this->mailer->send($message);
    }
}

<?php

namespace App\Auth\Test;

use App\Auth\Infrastructure\Tokenizer;
use PHPUnit\Framework\TestCase;

class TokenizerTest extends TestCase
{
    public function testCreate(): void
    {
        $interval = new \DateInterval('PT1H');
        $date = new \DateTimeImmutable('+1 day');

        $tokenizer = new Tokenizer($interval);
        $token = $tokenizer->generate($date);

        self::assertEquals($date->add($interval), $token->getExpiredAt());
    }
}

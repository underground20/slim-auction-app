<?php

namespace App\Auth\Test;

use App\Auth\Domain\Email;
use PHPUnit\Framework\TestCase;

/** @covers \App\Auth\Domain\Email */
class EmailTest extends TestCase
{
    public function testSuccess(): void
    {
        $email = new Email($value = 'test@gmail.com');

        self::assertEquals($value, $email->getValue());
    }

    public function testIncorrect(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Email('test');
    }

    public function testEmpty(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Email('');
    }
}

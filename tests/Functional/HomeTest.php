<?php

declare(strict_types=1);

namespace Test\Functional;

class HomeTest extends WebTestCase
{
    public function testSuccess(): void
    {
        $response = $this->app()->handle(
            self::json('GET', '/')->withParsedBody(['hello'])
        );

        self::assertEquals(json_encode('hello'), (string)$response->getBody());
        self::assertEquals(200, $response->getStatusCode());
    }
}

<?php

declare(strict_types=1);

$files = glob(__DIR__ . '/common/*.php');

$configs = array_map(
    static function (string $file): array {
        /**
         * @var array
         * @psalm-suppress UnresolvableInclude
         */
        return require $file;
    },
    $files
);

return array_merge_recursive(...$configs);

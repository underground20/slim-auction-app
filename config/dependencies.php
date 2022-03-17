<?php

declare(strict_types=1);

use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;

$aggregator = new ConfigAggregator([
    new PhpFileProvider(__DIR__ . '/common/*.php'),
    new PhpFileProvider(__DIR__ . '/dev/*.php'),
    new PhpFileProvider(__DIR__ . 'dependencies.php/' . (getenv('APP_ENV') ?: 'prod') . '/*.php'),
]);

return $aggregator->getMergedConfig();

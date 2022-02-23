<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

return static function (): ContainerInterface {
    $builder = new ContainerBuilder();
    $builder->addDefinitions(require_once __DIR__ . '/dependencies.php');

    return $builder->build();
};

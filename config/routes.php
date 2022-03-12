<?php

declare(strict_types=1);

use App\Http\Action\HomeAction;
use App\Http\Action\JoinByEmailAction;
use Slim\App;

return static function (App $app): void {
    $app->get('/', HomeAction::class);
    $app->post('/join', JoinByEmailAction::class);
};

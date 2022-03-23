<?php

declare(strict_types=1);

use App\Http\Action\ChangeRoleAction;
use App\Http\Action\ConfirmAction;
use App\Http\Action\HomeAction;
use App\Http\Action\JoinByEmailAction;
use App\Http\Action\RequestPasswordAction;
use App\Http\Action\ResetPasswordAction;
use Slim\App;

return static function (App $app): void {
    $app->get('/', HomeAction::class);
    $app->post('/auth/join', JoinByEmailAction::class);
    $app->post('/password/request', RequestPasswordAction::class);
    $app->post('/password/reset', ResetPasswordAction::class);
    $app->post('/auth/confirm', ConfirmAction::class);
    $app->post('/role/change', ChangeRoleAction::class);
};

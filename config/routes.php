<?php

// Define app routes

use Slim\App;

return function (App $app) {
    $app->get('/', \App\Action\Home\HomeAction::class);
    // $app->get('/ping', \App\Action\Home\PingAction::class);
};

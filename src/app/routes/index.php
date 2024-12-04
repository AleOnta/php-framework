<?php

use App\Router;
use App\Controllers\HomeController;

# create a new router
$router = new Router();

# create the home route at /
$router->get('/', HomeController::class, 'index');

$router->group('/test', function ($router) {
    $router->get('/one', HomeController::class, 'testOne');
    $router->get('/two', HomeController::class, 'testTwo');
});

# Routes the request
$router->dispatch();

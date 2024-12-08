<?php

use App\Router;
use App\Controllers\HomeController;
use App\Controllers\UserController;

# create a new router
$router = new Router();

# create the home route at /
$router->get('/', HomeController::class, 'index');

$router->group('/users', function ($router) {
    $router->get('/register', UserController::class, 'showRegistrationForm');
    $router->post('/register', UserController::class, 'createUser');
});

# Routes the request
$router->dispatch();

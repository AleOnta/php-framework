<?php

use App\Router;
use App\Controllers\HomeController;
use App\Controllers\UserController;

# create a new router
$router = new Router();

# create the home route at /
$router->get('/', HomeController::class, 'index');

$router->group('/users', function ($router) {
    # registration routes
    $router->get('/register', UserController::class, 'showRegistrationForm');
    $router->post('/register', UserController::class, 'register');
    # login routes
    $router->get('/login', UserController::class, 'showLoginForm');
    $router->post('/login', UserController::class, 'login');
    # logout route
    $router->post('/logout', UserController::class, 'logout');
});

# Routes the request
$router->dispatch();

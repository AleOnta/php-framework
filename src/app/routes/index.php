<?php

use App\Router;
use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Middlewares\CSRFMiddleware;

# create a new router
$router = new Router($container);

# create the home route at /
$router->get('/', HomeController::class, 'index');

$router->group('/users', function ($router) {
    # registration routes
    $router->get('/register', UserController::class, 'showRegistrationForm');
    $router->post('/register', UserController::class, 'register', [CSRFMiddleware::class]);
    # login routes
    $router->get('/login', UserController::class, 'showLoginForm');
    $router->post('/login', UserController::class, 'login', [CSRFMiddleware::class]);
    # logout route
    $router->post('/logout', UserController::class, 'logout', [CSRFMiddleware::class]);
});

# Routes the request
$router->dispatch();

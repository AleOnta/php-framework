<?php

use App\Router;
use App\Controllers\RootController;
use App\Controllers\UserController;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\CSRFMiddleware;
use App\Middlewares\RoleMiddleware;

# create a new router
$router = new Router($container);

# create the home route at /
$router->get('/', RootController::class, 'index');
# unauthorized response
$router->get('/unauthorized', RootController::class, 'unauthorized');
# create a group of routes
$router->group('/users', function ($router) {
    # registration routes
    $router->get('/register', UserController::class, 'showRegistrationForm');
    $router->post('/register', UserController::class, 'register', [CSRFMiddleware::class]);
    # login routes
    $router->get('/login', UserController::class, 'showLoginForm');
    $router->post('/login', UserController::class, 'login', [CSRFMiddleware::class]);
    # logout route
    $router->post('/logout', UserController::class, 'logout', [CSRFMiddleware::class]);

    # show profile route
    $router->get('/show/{id}', UserController::class, 'show', [AuthMiddleware::class, [RoleMiddleware::class, ['requiredRoles' => ['admin']]]]);
});

$router->group('/migrations', function ($router) {
    # create a test route for migrations reporting
    $router->get('', RootController::class, 'migrations', [AuthMiddleware::class, [RoleMiddleware::class, ['requiredRoles' => ['admin']]]]);
    # create a route for running missing migrations
    $router->post('/up', RootController::class, 'migrationsUp', [AuthMiddleware::class, [RoleMiddleware::class, ['requiredRoles' => ['admin']]], CSRFMiddleware::class]);
});

# Routes the request
$router->dispatch();

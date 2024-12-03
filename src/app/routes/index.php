<?php

use App\Router;
use App\Controllers\HomeController;

# create a new router
$router = new Router();

# create the home route at /
$router->get('/', HomeController::class, 'index');

# Routes the request
$router->dispatch();

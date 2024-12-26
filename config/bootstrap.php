<?php

use App\Core\MySQL;
use App\Models\Auth;
use App\Core\Container;
use App\MigrationRunner;
use App\Utility\EnvLoader;
use App\Utility\AppConstants;
use App\Services\UserService;
use App\Services\RoleService;
use App\Services\PasswordService;
use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Repositories\PasswordRepository;

# include composer autoload
include "../vendor/autoload.php";
require_once AppConstants::HELPERS_DIR . "auth_helpers.php";

# load default .env into memory
$env = new EnvLoader;
$env->loadEnv();

# create a new container
$container = new Container();

# DATABASES
$container->set('db', fn() => MySQL::connect());

# REPOSITORIES
$container->set(UserRepository::class, fn($c) => new UserRepository($c->get('db')));
$container->set(RoleRepository::class, fn($c) => new RoleRepository($c->get('db')));
$container->set(PasswordRepository::class, fn($c) => new PasswordRepository($c->get('db')));

# SERVICES
$container->set(UserService::class, fn($c) => new UserService($c->get(UserRepository::class)));
$container->set(RoleService::class, fn($c) => new RoleService($c->get(RoleRepository::class)));
$container->set(PasswordService::class, fn($c) => new PasswordService($c->get(PasswordRepository::class)));

# CONTROLLERS
$container->set(HomeController::class, fn($c) => new HomeController());
$container->set(UserController::class, fn($c) => new UserController(
    $c->get(UserService::class),
    $c->get(RoleService::class),
    $c->get(PasswordService::class)
));

# run migration if needed

# creates a new session
auth()->startSession();

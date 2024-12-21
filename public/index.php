<?php

use App\Core\MySQL;
use App\Models\Auth;
use App\MigrationRunner;
use App\Utility\AppConstants;

# include composer autoload
require __DIR__ . '/../vendor/autoload.php';

# create database connection
$db = new MySQL();

# run migration if needed
$migrationRunner = new MigrationRunner($db->getConnection());
$migrationRunner->migrate();

# start a new session
Auth::startSession();

# pass the request to the router
$router = require AppConstants::ROUTES_DIR . "index.php";

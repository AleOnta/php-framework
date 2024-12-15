<?php

use App\Utility\AppConstants;

# start a new session
session_start();

# include composer autoload
require __DIR__ . '/../vendor/autoload.php';

# pass the request to the router
$router = require AppConstants::ROUTES_DIR . "index.php";

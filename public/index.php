<?php

use App\Models\Auth;
use App\Utility\AppConstants;

# include composer autoload
require __DIR__ . '/../vendor/autoload.php';

# start a new session
Auth::startSession();

# pass the request to the router
$router = require AppConstants::ROUTES_DIR . "index.php";

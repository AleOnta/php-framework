<?php

# import the configuration bootstrap file
require_once "../config/bootstrap.php";

use App\Utility\AppConstants;

# pass the request to the router
$router = require AppConstants::ROUTES_DIR . "index.php";

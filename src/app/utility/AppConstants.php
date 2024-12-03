<?php

namespace App\Utility;

class AppConstants
{
    # define the root path of the application
    public const ROOT_DIR = 'C:/Users/Ale-O/Documents/Projects/php-framework/';
    # define other child paths
    public const ENV_PATH = self::ROOT_DIR . ".env";
    public const VIEWS_DIR = self::ROOT_DIR . "src/app/views/";
    public const ASSETS_DIR = self::ROOT_DIR . "public/assets/";
    public const ROUTES_DIR = self::ROOT_DIR . "src/app/routes/";
    public const MIGRATIONS_DIR = self::ROOT_DIR . "src/app/migrations/";
    public const TEMPLATES_DIR = self::ROOT_DIR . "src/app/views/templates/";
    public const COMPONENTS_DIR = self::ROOT_DIR . "src/app/views/components/";
}

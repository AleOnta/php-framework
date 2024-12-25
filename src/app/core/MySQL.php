<?php

namespace App\Core;

use PDO;
use PDOException;
use RuntimeException;

class MySQL
{
    public static ?PDO $connection = null;

    public static function connect()
    {
        if (!isset(self::$connection)) {
            # attempt database connection
            $dsn = "mysql:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_NAME']};charset={$_ENV['DB_CHARSET']}";
            self::$connection = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PSW']);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$connection;
    }
}

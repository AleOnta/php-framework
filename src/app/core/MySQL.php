<?php

namespace App\Core;

use PDO;
use PDOException;
use App\Utility\EnvLoader;
use App\Utility\AppConstants;

class MySQL
{

    # singleton
    private static $instance = null;
    private PDO $connection;

    public function __construct()
    {
        # load env into memory
        $env = new EnvLoader;
        $env->loadEnv();

        # attempt database connection
        try {
            $dsn = "mysql:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_NAME']};charset={$_ENV['DB_CHARSET']}";
            $this->connection = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PSW']);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die(PHP_EOL . "MySQL connection has failed: {$e->getMessage()}");
        }
    }

    public static function getInstance()
    {
        # check if connection exists
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}

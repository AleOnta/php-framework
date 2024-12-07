<?php

class CreateUsersTable
{
    public function up(PDO $db)
    {
        $query = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            firstname VARCHAR(50) NOT NULL,
            lastname VARCHAR(50) NOT NULL,
            username VARCHAR(50) NOT NULL UNIQUE,
            email VARCHAR(75) NOT NULL UNIQUE,
            dob DATE NOT NULL,
            status TINYINT NOT NULL DEFAULT 1,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;";
        # execute the query
        $db->exec($query);
    }

    public function down(PDO $db)
    {
        $query = "DROP TABLE IF EXISTS users;";
        # execute the query
        $db->exec($query);
    }
}

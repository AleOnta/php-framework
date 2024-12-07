<?php

class CreatePasswordsTable
{

    public function up(PDO $db)
    {
        $query = "CREATE TABLE IF NOT EXISTS passwords (
            id INT AUTO_INCREMENT PRIMARY KEY,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
        ";
        $db->exec($query);
    }

    public function down($db)
    {
        $query = "DROP TABLE IF EXISTS passwords;";
        $db->exec($query);
    }
}

<?php

class CreateUsersTable
{
    public function up(PDO $db)
    {
        $query = "CREATE TABLE IF NOT EXISTS users (
            id AUTO_INCREMENT PRIMARY KEY,
            firstname VARCHAR(50) NOT NULL,
            lastname VARCHAR(50) NOT NULL,
            username VARCHAR(50) NOT NULL,
            email VARCHAR(75) NOT NULL,
            dob DATE NOT NULL
        );";
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

<?php

class CreateRolesTable
{
    public function up(PDO $db)
    {
        # define CREATE query
        $query = "CREATE TABLE IF NOT EXISTS roles (
            id INT AUTO_INCREMENT PRIMARY KEY,
            label VARCHAR(255) UNIQUE
        );";
        # create the table
        $db->exec($query);

        # create default roles
        $stmt = $db->prepare("INSERT INTO roles (label) VALUES (:role);");
        foreach (['admin', 'user'] as $role) {
            $stmt->execute(['role' => $role]);
        }
    }

    public function down(PDO $db)
    {
        # define DROP query
        $query = "DROP TABLE IF EXISTS roles;";
        # drop the table
        $db->exec($query);
    }
}

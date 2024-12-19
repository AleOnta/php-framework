<?php

class CreateUserRolesTable
{
    public function up(PDO $db)
    {
        # define CREATE query
        $query = "CREATE TABLE IF NOT EXISTS user_roles (
            user_id INT,
            role_id INT,
            PRIMARY KEY (user_id, role_id),
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
        )";
        # create the table
        $db->exec($query);
    }

    public function down(PDO $db)
    {
        # define DROP query
        $query = "DROP TABLE IF EXISTS user_roles;";
        # drop the table
        $db->exec($query);
    }
}

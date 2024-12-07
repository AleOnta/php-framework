<?php

class AlterUsersTable
{

    public function up(PDO $db)
    {
        $query = "ALTER TABLE users
            ADD COLUMN password_id INT NOT NULL AFTER email,
            ADD CONSTRAINT fk_user_password_id FOREIGN KEY (password_id)
            REFERENCES passwords(id);
        ";
        $db->exec($query);
    }
}

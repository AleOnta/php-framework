<?php

namespace App\Repositories;

use PDO;

class PasswordRepository extends Repository
{
    public function __construct(PDO $db)
    {
        # istantiate the base repository
        parent::__construct($db, 'passwords');
        # map the model table in the db
        $this->modelMap = [
            'id' => 'id',
            'hash' => 'hash',
            'createdAt' => 'created_at',
            'updatedAt' => 'updated_at'
        ];
    }

    public function create($password)
    {
        # hashing
        $hash = password_hash($password, PASSWORD_DEFAULT);
        # compose the query
        $stmt = $this->db->prepare("INSERT INTO passwords (id, password, created_at, updated_at) VALUES (NULL, :password, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);");
        # bind values
        $stmt->bindParam(':password', $hash, PDO::PARAM_STR);
        # execute the query
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
    }
}

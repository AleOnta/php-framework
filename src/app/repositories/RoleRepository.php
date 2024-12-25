<?php

namespace App\Repositories;

use PDO;

class RoleRepository extends Repository
{
    public function __construct(PDO $db)
    {
        # istantiate the base repository
        parent::__construct($db, 'roles');
        # map the model table in the db
        $this->modelMap = [
            'id' => 'id',
            'label' => 'label'
        ];
    }

    public function getRoleId($label)
    {
        # prepare SELECT query
        $stmt = $this->db->prepare("SELECT id FROM roles WHERE label = :label LIMIT 1;");
        # bind the params
        $stmt->bindParam(':label', $label, PDO::PARAM_STR);
        # execute the query
        $stmt->execute();
        # return the id or false
        return $stmt->fetch(PDO::FETCH_COLUMN) ?? false;
    }

    public function assignRoleToUser($roles, $userId)
    {
        # define INSERT query
        $stmt = $this->db->prepare("INSERT INTO user_roles (user_id, role_id) VALUES (:user_id, :role_id);");
        # create role for each record received
        foreach ($roles as $role) {
            # retrieve the role id
            $roleId = $this->getRoleId($role);
            if ($roleId) {
                # create the role record
                $success = $stmt->execute(['user_id' => $userId, 'role_id' => $roleId]);
            }
        }
        return $success ?? false;
    }
}

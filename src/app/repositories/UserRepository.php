<?php

namespace App\Repositories;

use PDO;
use App\Models\User;
use App\Repositories\Repository;

class UserRepository extends Repository
{
    public function __construct(PDO $db)
    {
        # instantiate the base repository
        parent::__construct($db, 'users');
        # map the model table in db
        $this->modelMap = [
            'id' => 'id',
            'firstName' => 'firstname',
            'lastName' => 'lastname',
            'userName' => 'username',
            'email' => 'email',
            'passwordId' => 'password_id',
            'birthdate' => 'dob',
            'status' => 'status',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at'
        ];
    }

    public function getUserByEmail(string $email)
    {
        # define the query
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email;");
        # bind the email parameter
        $stmt->bindParam('email', $email, PDO::PARAM_STR);
        # execute the statement
        $stmt->execute();
        # return the entity or false
        return $stmt->fetch(PDO::FETCH_ASSOC) ?? false;
    }

    public function getUserByUsername(string $username)
    {
        # define the query
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username;");
        # bind the username parameter
        $stmt->bindParam('username', $username, PDO::PARAM_STR);
        # execute the statement
        $stmt->execute();
        # return the entity or false
        return $stmt->fetch(PDO::FETCH_ASSOC) ?? false;
    }

    public function getUserByIdWithRoles(int $id)
    {
        # define the query
        $stmt = $this->db->prepare(
            "SELECT users.*, GROUP_CONCAT(roles.label) AS roles 
             FROM users
             LEFT JOIN user_roles ON users.id = user_roles.user_id
             LEFT JOIN roles ON roles.id = user_roles.role_id
             WHERE users.id = :id
             GROUP BY users.id;"
        );
        # execute the query
        $stmt->execute(['id' => $id]);
        # extract data
        $user = $stmt->fetch();
        # hydrate in model
        return $this->hydrate($user) ?? false;
    }

    public function hydrate(array $data)
    {
        $user = new User();
        $user->setId($data['id']);
        $user->setFirstName($data['firstname']);
        $user->setLastName($data['lastname']);
        $user->setUserName($data['username']);
        $user->setEmail($data['email']);
        $user->setPasswordId($data['password_id']);
        $user->setBirthdate($data['dob']);
        $user->setStatus($data['status']);
        $user->setCreatedAt($data['created_at']);
        $user->setUpdatedAt($data['updated_at']);
        # if roles were extracted, set them
        if (isset($data['roles'])) {
            $roles = explode(',', $data['roles']);
            $user->setRoles($roles);
        }
        return $user;
    }

    public function createEntity(array $user, int $pswId)
    {
        # define column statement
        $columns = ['firstname', 'lastname', 'username', 'email', 'password_id', 'dob'];
        $columnsStr = implode(',', $columns);
        # define values statement
        $values = [$user['firstname'], $user['lastname'], $user['username'], $user['email'], $pswId, $user['dob']];
        $valuesPlaceholder = implode(',', array_fill(0, count($columns), '?'));
        # prepare the query
        $stmt = $this->db->prepare("INSERT INTO {$this->table} ({$columnsStr}) VALUES ({$valuesPlaceholder})");
        # execute the query and return res
        return $stmt->execute($values) ? $this->db->lastInsertId() : false;
    }
}

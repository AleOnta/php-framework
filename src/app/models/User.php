<?php

namespace App\Models;

use App\Core\Model;

class User extends Model
{

    protected string $firstName;
    protected string $lastName;
    protected string $userName;
    protected string $email;
    protected string $birthdate;
    protected int $status;
    protected string $createdAt;
    protected string $updatedAt;

    public function __construct()
    {
        # instance of Model 
        parent::__construct();
        # map the model in the database
        $this->table = 'users';
        $this->modelMap = [
            'firstName' => 'firstname',
            'lastName' => 'lastname',
            'userName' => 'username',
            'email' => 'email',
            'birthdate' => 'dob',
            'status' => 'status',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at'
        ];
    }

    # retrieve and return user by its id
    public function getUserById(int $id)
    {
        return $this->findById($id);
    }

    # retrieve and return user by its email
    public function getUserByEmail(string $email)
    {
        return $this->find(['email' => $email]);
    }
}

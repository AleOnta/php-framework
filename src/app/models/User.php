<?php

namespace App\Models;

use PDO;
use DateTime;
use Exception;
use App\Core\Model;
use stdClass;

class User extends Model
{
    public string $firstName;
    public string $lastName;
    public string $userName;
    protected string $email;
    protected ?int $passwordId;
    public string $birthdate;
    protected int $status;
    protected array $roles;
    protected string $createdAt;
    protected string $updatedAt;

    public function __construct()
    {
        # instance of Model 
        parent::__construct();
        # define table name for model
        $this->table = 'users';
        # map the model in the database
        $this->modelMap = [
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

    # GETTERS
    public function getFirstName()
    {
        return $this->firstName;
    }
    public function getLastName()
    {
        return $this->lastName;
    }
    public function getUserName()
    {
        return $this->userName;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getPasswordId()
    {
        return $this->passwordId;
    }
    public function getBirthdate()
    {
        return $this->birthdate;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    # SETTERS
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }
    public function setUserName(string $userName)
    {
        $this->userName = $userName;
    }
    public function setEmail(string $email)
    {
        $this->email = $email;
    }
    public function setPasswordId(int $passwordId)
    {
        $this->passwordId = $passwordId;
    }
    public function setBirthdate(string $birthdate)
    {
        $this->birthdate = $birthdate;
    }
    public function setStatus(int $status)
    {
        return $this->status;
    }
    public function setCreatedAt(string $createdAt)
    {
        $this->createdAt = $createdAt;
    }
    public function setUpdatedAt(string $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    # retrieve and return user by its email
    public function getUserByEmail(string $email)
    {
        $data = $this->find(['email' => $email]);
        if ($data) {
            return $this->hydrate($data);
        }
        return false;
    }

    # retrieve and return user by its username
    public function getUserByUsername(string $username)
    {
        $data = $this->find(['username' => $username]);
        if ($data) {
            return $this->hydrate($data);
        }
        return false;
    }

    # retrieve user hashed password by id
    public function getUserPasswordById(int $passwordId)
    {
        # prepare the query
        $stmt = $this->db->prepare("SELECT password FROM passwords WHERE id = :id");
        # bind params
        $stmt->bindParam(':id', $passwordId, PDO::PARAM_INT);
        # execute the query
        $stmt->execute();
        # return the password
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    # hash and persist a password in the db
    public function storePassword(string $password): ?int
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

    # persist a new user in the db
    public function create(stdClass $data, int $passwordId, string $role = 'user')
    {
        # set values into instance
        $this->firstName = $data->firstname;
        $this->lastName = $data->lastname;
        $this->userName = $data->username;
        $this->email = $data->email;
        $this->passwordId = $passwordId;
        $this->birthdate = $data->birthdate;

        # persist the user
        $userId = $this->save();
        # create the role record
        $role = $this->addUserRole($userId);
        # return result 
        if ($role) return $userId;
        else return false;
    }

    public function addUserRole(int $userId, mixed $roles = ['user'])
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

    # hydration function that returns an instance of the user received
    public function hydrate(array $data)
    {
        $user = new User();
        $user->setFirstName($data['fistname']);
        $user->setLastName($data['lastname']);
        $user->setUserName($data['username']);
        $user->setEmail($data['email']);
        $user->setPasswordId($data['password_id']);
        $user->setBirthdate($data['birthdate']);
        $user->setStatus($data['status']);
        $user->setCreatedAt($data['created_at']);
        $user->setUpdatedAt($data['updated_at']);
        return $user;
    }

    # function that validate user inputs for user creation
    public static function validateUser(array $userInputs)
    {
        $errors = [];
        # loop on user inputs
        foreach ($userInputs as $key => $input) {

            # skip dynamic values
            if (in_array($key, ['passwordId', 'status', 'created_at', 'updated_at'])) continue;

            # check for fname - lname - uname and dob
            if (in_array($key, ['firstname', 'lastname', 'username', 'dob'])) {
                # define the allowed pattern
                $regex = match ($key) {
                    'firstname', 'lastname' => ['pattern' => '/^[a-zA-Z\s]+$/', 'msg' => "{$key} can't contain non-alphabetical characters."],
                    'username' => ['pattern' => '/^[a-zA-Z0-9\_\-\s]+$/', 'msg' => "Invalid characters found in {$key}."],
                    'dob' => ['pattern' => '/^\d{4}-\d{2}-\d{2}$/', 'msg' => 'Please provide a valid date of birth.'],
                    default => ''
                };

                # check regex on input
                if (!preg_match($regex['pattern'], $input)) {
                    $errors[$key] = $regex['msg'];
                }

                # check if its a valid date
                if ($key == 'dob') {
                    $date = DateTime::createFromFormat('Y-m-d', $input);
                    if (!$date || $date->format('Y-m-d') !== $input) {
                        $errors[$key] = $regex['msg'];
                    }
                }
                continue;
            }

            # validate email address
            if ($key == 'email') {
                if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
                    $errors[$key] = "Please provide a valid email address.";
                }
                continue;
            }
        }
        return ['count' => count($errors), 'errors' => $errors];
    }

    # function that validate user credentials for login
    public static function validateCredentials(array $credentials)
    {

        # extract credentials
        $email = trim($credentials['email']);
        $password = trim($credentials['password']);

        # check email value
        if (is_null($email) || $email == '') {
            return ['status' => false, 'message' => "Email can't be empty..."];
        }

        # check email value
        if (is_null($password) || $password == '') {
            return ['status' => false, 'message' => "The password can't be empty..."];
        }

        # check the email composition
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['status' => false, 'message' => "Please provide a valid email address."];
        }

        # data is okay
        return ['status' => true];
    }

    private function getRoleId($label)
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
}

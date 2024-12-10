<?php

namespace App\Models;

use PDO;
use DateTime;
use Exception;
use App\Core\Model;

class User extends Model
{
    protected string $firstName;
    protected string $lastName;
    protected string $userName;
    protected string $email;
    protected ?int $passwordId;
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
    public function setFirstName($value)
    {
        if ($value == '') {
            throw new Exception("Firstname can't be empty.");
        }
        $this->firstName = $value;
    }
    public function setLastName($value)
    {
        return $this->lastName;
    }
    public function setUserName($value)
    {
        return $this->userName;
    }
    public function setEmail($value)
    {
        return $this->email;
    }
    public function setPasswordId($value)
    {
        return $this->passwordId;
    }
    public function setBirthdate($value)
    {
        return $this->birthdate;
    }
    public function setStatus($value)
    {
        return $this->status;
    }

    # retrieve and return user by its email
    public function getUserByEmail(string $email)
    {
        return $this->find(['email' => $email]);
    }

    # hash and persist a password in the db
    public function storePassword($password): ?int
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
    public function create($passwordId) {}

    # function that validate user inputs for user creation
    public static function validateUser($userInputs)
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
}

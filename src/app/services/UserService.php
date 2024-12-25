<?php

namespace App\Services;

use App\Models\User;
use DateTime;
use App\Repositories\UserRepository;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    public function validateUserData(array $userInputs)
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

            # check if email is already in use
            if ($this->userRepository->getUserByEmail($userInputs['email'])) {
                return ['count' => 1, 'errors' => ['email' => 'email is already associated with an account.']];
            }

            # check if username is already in use
            if ($this->userRepository->getUserByUsername($userInputs['username'])) {
                return ['count' => 1, 'errors' => ['username' => "username '{$userInputs['username']}' isnt available."]];
            }
        }
        return ['count' => count($errors), 'errors' => $errors];
    }

    public function validateUserCredentials(array $credentials)
    {
        # extract credentials
        $email = trim($credentials['email']);
        $password = trim($credentials['password']);

        # check email value
        if (is_null($email) || $email == '') {
            return ['status' => false, 'message' => "Email can't be empty..."];
        }

        # check password value
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

    public function createUser(array $data, int $pswId)
    {
        $userId = $this->userRepository->createEntity($data, $pswId);
        if ($userId) {
            return $userId;
        }
        return "Failed to create User";
    }

    public function getUserByEmail(string $email, string $password)
    {
        # check if the user exists by email
        $user = $this->userRepository->getUserByEmail($email);
        if (!$user) {
            return ['status' => false, 'message' => "User {$email} doesn't exists."];
        }
        return ['status' => true, 'data' => $user];
    }
}

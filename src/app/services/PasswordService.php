<?php

namespace App\Services;

use App\Repositories\PasswordRepository;

class PasswordService
{

    private PasswordRepository $passwordRepository;

    public function __construct(PasswordRepository $passwordRepo)
    {
        $this->passwordRepository = $passwordRepo;
    }

    public function validatePassword(string $password, string $passwordCheck)
    {
        $errors = [];
        # check both passwords are equals
        if ($password !== $passwordCheck) {
            $errors['password'] = 'The two password are different.';
        }

        # pattern for password (min 8 char, min 1 digit, min 1 UP, min 1 lw, min 1 special char)
        $pattern = '/^\S*(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=\S*[\W])[a-zA-Z\d]{8,}\S*$/';
        # check for password validity
        if (!preg_match($pattern, $password)) {
            $errors['password'] = 'Password is too weak';
        }
        return ['count' => count($errors), 'errors' => $errors];
    }

    public function storePassword(string $password)
    {
        $pswId = $this->passwordRepository->create($password);
        if ($pswId) {
            return $pswId;
        }
        return false;
    }

    public function matchUserPassword(int $pswId, string $password)
    {
        $hash = $this->passwordRepository->findById($pswId);
        if (!$hash) {
            return ['status' => false, 'message' => 'Password not found.'];
        }
        $match = password_verify($password, $hash['password']);
        if (!$match) {
            return ['status' => false, 'message' => "Password doesn't match our record."];
        }
        return ['status' => true];
    }
}

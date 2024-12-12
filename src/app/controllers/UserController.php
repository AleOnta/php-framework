<?php

namespace App\Controllers;

use App\Controller;
use App\Models\User;
use App\Models\Request;

class UserController extends Controller
{

    public function showRegistrationForm()
    {
        # define the content of the page
        $content = ['page_title' => 'Register', 'view' => 'register'];
        # define the assets required
        $assets = ['css' => [], 'js' => ['register']];
        # render the page
        $this->render('basic', $content, $assets);
    }

    public function createUser()
    {
        $header = Request::getCustomHeader();
        if ($header === 'custom-register-user') {
            # get req body
            $data = Request::getJsonBody();
            # compose user for validation
            $user = [
                'firstname' => $data->firstname,
                'lastname' => $data->lastname,
                'username' => $data->username,
                'email' => $data->email,
                'password' => $data->password,
                'dob' => $data->birthdate
            ];

            # validate the user
            $errors = User::validateUser($user);
            if ($errors['count'] > 0) {
                # bad user input
                $this->return(400, false, $errors);
            }

            # check if the user already exists
            $entity = new User();
            $email = $entity->getUserByEmail($data->email);
            if ($email !== false) {
                $this->return(400, false, ['errorMsg' => "Email {$data->email} has already been registered"]);
            }

            # check if username is already been used
            $username = $entity->getUserByUsername($data->username);
            if ($username !== false) {
                $this->return(400, false, ['errorMsg' => "Username '{$data->username}' isn't available"]);
            }

            # create the new user
            $pswId = $entity->storePassword($data->password);
            if ($pswId) {
                $userId = $entity->create($data, $pswId);
                $this->return(201, true, ['msg' => "User created correctly"]);
            }
            $this->return(500, false, ['errorMsg' => 'Error while creating the user']);
        }
    }

    private function return(int $code, bool $status, array $data = [])
    {
        http_response_code($code);
        echo json_encode(['status' => $status, 'data' => $data]);
        exit;
    }
}

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
        $assets = [
            'css' => [],
            'js' => ['register']
        ];
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
            if ($errors['status'] > 0) {
                print_r($errors);
            } else {
                echo "OK";
            }
        }
    }
}

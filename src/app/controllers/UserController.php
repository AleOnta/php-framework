<?php

namespace App\Controllers;

use App\Controller;
use App\Models\User;
use App\Models\Auth;
use App\Models\Request;

class UserController extends Controller
{

    public function showRegistrationForm()
    {
        # define the content of the page
        $content = ['page_title' => 'Register', 'view' => 'register'];
        # define the assets required
        $assets = ['css' => [], 'js' => ['users']];
        # render the page
        $this->render('basic', $content, $assets);
    }

    public function register()
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
                if ($userId) {
                    # user created correctly
                    $this->return(201, true, ['msg' => "User created correctly"]);
                }
                # internal server error
                $this->return(500, false, ['msg' => 'An error has occurred']);
            }
            $this->return(500, false, ['errorMsg' => 'Error while creating the user']);
        }
    }

    public function showLoginForm()
    {
        # define the content of the page
        $content = ['page_title' => 'Login', 'view' => 'login'];
        # define the assets required
        $assets = ['css' => [], 'js' => ['index', 'users']];
        # render the page
        $this->render('basic', $content, $assets);
    }

    public function login()
    {
        # retrieve custom header
        $header = Request::getCustomHeader();
        if ($header === 'login-user') {
            # retrieve submitted data
            $data = Request::getJsonBody();
            $credentials = [
                'email' => $data->email,
                'password' => $data->password
            ];

            # validate submitted data
            $validation = User::validateCredentials($credentials);
            if (!$validation['status']) {
                $this->return(401, false, $validation);
            }

            # check if user exists
            $entity = new User();
            $user = $entity->getUserByEmail($credentials['email']);
            if ($user === false) {
                $this->return(401, false, ['message' => "No account associated with email."]);
            }

            # retrieve user hashed password
            $hash = $entity->getUserPasswordById($user['password_id']);
            if (!password_verify($credentials['password'], $hash)) {
                $this->return(401, false, ['message' => "Wrong password sumbitted."]);
            }

            # save user data in session
            Auth::startSession();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['logged_in'] = true;

            # return ok response
            $this->return(200, true, ['msg' => 'Successfully logged in.']);
        }
    }

    public function logout()
    {
        # execute the logout
        Auth::logout();
        # redirect the user to login page
        header('Location: /users/login');
        exit();
    }
}

<?php

namespace App\Controllers;

use App\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Auth;
use App\Models\Request;
use App\Services\RoleService;
use App\Services\UserService;
use App\Services\PasswordService;
use LDAP\Result;

class UserController extends Controller
{
    private UserService $userService;
    private RoleService $roleService;
    private PasswordService $passwordService;

    public function __construct(UserService $userService, RoleService $roleService, PasswordService $passwordService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
        $this->passwordService = $passwordService;
    }

    public function showRegistrationForm()
    {
        # define the content of the page
        $content = ['page_title' => 'Register', 'view' => 'register'];
        # define the assets required
        $assets = ['css' => [], 'js' => ['index', 'users']];
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
            $errors = $this->userService->validateUserData($user);
            if ($errors['count'] > 0) {
                # bad user input
                $this->return(400, false, $errors);
            }

            # validate the password
            $errors = $this->passwordService->validatePassword($data->password, $data->password_check);
            if ($errors['count'] > 0) {
                # bad user input
                $this->return(400, false, $errors);
            }

            # store the user password
            $pswId = $this->passwordService->storePassword($data->password);
            if ($pswId) {
                $userId = $this->userService->createUser($user, $pswId);
                if ($userId) {
                    # assign user role
                    if ($this->roleService->addRoleToUser($userId, ['user'])) {
                        # delete csrf token to avoid reuse
                        Request::deleteTokenCSRF('register');
                        # user created correctly
                        $this->return(201, true, ['msg' => "User created correctly"]);
                    }
                }
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
        $header = Request::getCustomHeader();
        if ($header === 'login-user') {
            $data = Request::getJsonBody();
            # validate user inputs
            $res = $this->userService->validateUserCredentials(['email' => $data->email, 'password' => $data->password]);
            if (!$res['status']) {
                $this->return(401, false, ['message' => $res['message']]);
            }
            # match user in db
            $user = $this->userService->getUserByEmail($data->email, $data->password);
            if (!$user['status']) {
                $this->return(401, false, ['message' => $user['message']]);
            }
            # verify user password
            $password = $this->passwordService->matchUserPassword($user['data']['password_id'], $data->password);
            if (!$password['status']) {
                $this->return(401, false, ['message' => $password['message']]);
            }
            # delete csrf token to avoid reuse
            Request::deleteTokenCSRF('login');
            # set user data in session
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['data']['id'];
            # confirm login
            $this->return(200, true, ['message' => 'Logged in correctly.']);
        }
        $this->return(401, false, ['message' => 'Wrong request header.']);
    }

    public function logout()
    {
        # clear session data and logout
        if (isset($_SESSION['logged_in'])) {
            if ($_SESSION['logged_in'] === true) {
                unset($_SESSION['logged_in']);
                unset($_SESSION['user_id']);
            }
        }
        # delete csrf token to avoid reuse
        Request::deleteTokenCSRF('logout');
        # confirm logout
        http_response_code(200);
        header('Location: /users/login');
    }
}

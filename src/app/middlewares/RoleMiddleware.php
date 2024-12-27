<?php

namespace App\Middlewares;

use Closure;

class RoleMiddleware extends Middleware
{

    private array $requiredRoles;

    public function __construct(array $requiredRoles)
    {
        $this->requiredRoles = $requiredRoles;
    }

    public function handle($request, Closure $next)
    {
        # check if the user is logged in
        if (!auth()->check() || !isset($_SESSION['user_id'])) {
            # redirect unauth user to login form
            $this->redirect('/users/login');
        }

        if (!$this->hasRole(auth()->user()->getRoles(), $this->requiredRoles)) {
            # set error msg in session
            $message = "You don't have the required access scope to render the content of this page<br>";
            $message .= "Gain the correct role to view this page.";
            $_SESSION['error'] = [];
            $_SESSION['error']['title'] = 'Unauthorized - Access Denied';
            $_SESSION['error']['message'] = $message;
            # return unauthorized response
            $this->redirect('/unauthorized', 403);
        }

        # allow request
        $next();
    }

    private function hasRole($userRoles, $roles)
    {
        foreach ($roles as $role) {
            if (in_array($role, $userRoles)) {
                return true;
            }
        }
        return false;
    }
}

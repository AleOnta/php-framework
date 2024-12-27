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
            # return unauthorized response
            $this->return(403, false);
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

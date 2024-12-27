<?php

namespace App\Middlewares;

class AuthMiddleware extends Middleware
{

    public static function handle($request, $next)
    {
        if (!isset($_SESSION['logged_in'])) {
            Middleware::redirect('/users/login');
        }

        if ($_SESSION['logged_in'] === false) {
            Middleware::redirect('/users/login');
        }

        # allow the request
        $next();
    }
}

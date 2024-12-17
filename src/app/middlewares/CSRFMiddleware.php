<?php

namespace App\Middlewares;

use App\Models\Request;

class CSRFMiddleware extends Middleware
{

    public static function handle($request, $next)
    {
        # check csrf token for the POST request
        $csrf = Request::getTokenCSRF();
        # verify CSRF token id received
        if (!$csrf['id'] || !isset($_SESSION['csrf_tokens'][$csrf['id']])) {
            Middleware::return(403, false, ['message' => 'Invalid CSRF Token identifier.']);
        }

        # extract the expected CSRF token
        $expectedToken = $_SESSION['csrf_tokens'][$csrf['id']];

        # verify the token received
        if (!$csrf['token'] || $csrf['token'] !== $expectedToken) {
            Middleware::return(403, false, ['message' => 'Invalid CSRF Token submitted.']);
        }

        # delete CSRF token to prevent reuse
        unset($_SESSION['csrf_tokens'][$csrf['id']]);
        # allow the request
        $next();
    }
}

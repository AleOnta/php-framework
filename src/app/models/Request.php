<?php

namespace App\Models;

use App\Controllers\UserController;

class Request
{
    public static function getCustomHeader()
    {
        # return the custom header if exists
        return $_SERVER['HTTP_X_CUSTOM_HEADER'] ?? null;
    }

    public static function getJsonBody()
    {
        # decode json body
        $body = json_decode(file_get_contents('php://input', 1));
        # check for errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            return null;
        }
        return $body;
    }

    public static function getTokenCSRF()
    {
        # get csrf token from post data if exists
        $csrfToken = $_POST['csrf_token'] ?? null;
        $scrfTokenId = $_POST['csrf_token_id'] ?? null;

        # if its an AJAX req. then pick up the same values
        if (isset($_SERVER['HTTP_X_CSRF_TOKEN'])) {
            $csrfToken = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
            $scrfTokenId = $_SERVER['HTTP_X_CSRF_TOKEN_ID'] ?? null;
        }

        # return found token and id
        return ['id' => $scrfTokenId, 'token' => $csrfToken];
    }
}

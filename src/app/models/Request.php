<?php

namespace App\Models;

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
}

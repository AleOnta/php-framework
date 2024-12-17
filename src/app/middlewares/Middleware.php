<?php

namespace App\Middlewares;

class Middleware
{
    # return response to the client (if in error)
    public static function return($code, $status, $data = [])
    {
        http_response_code($code);
        echo json_encode(['status' => $status, 'data' => $data]);
        exit;
    }
}

<?php

namespace App\Models;

use App\Models\User;

class Auth
{
    # logged in user data storage
    public static ?array $cachedUser = null;

    private static function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function check(): bool
    {
        # check and returns if a user is logged in or not
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    public static function user(): ?array
    {
        # if user data is in cache returns it
        if (self::$cachedUser !== null) {
            return self::$cachedUser;
        }

        # if user isn't logged in returns null
        if (!self::check()) {
            return null;
        }

        # retrieve the logged in user
        $userId = $_SESSION['user_id'];
        $user = new User();
        $user = $user->findById($userId);

        # set the user data in cache
        foreach ($user as $key => $val) {
            if ($key === 'password_id') continue;
            self::$cachedUser[$key] = $val;
        }

        # returns the user data
        return self::$cachedUser;
    }

    public static function logout()
    {
        # check if a session exists - if not creates one
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        # unset session vars
        unset($_SESSION['user_id']);
        unset($_SESSION['logged_in']);
        # destroy the existing session
        session_destroy();
    }
}

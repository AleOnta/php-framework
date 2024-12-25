<?php

use App\Models\Auth;

function auth()
{
    static $authInstance = null;

    if ($authInstance === null) {
        $authInstance = new Auth();
    }

    return $authInstance;
}

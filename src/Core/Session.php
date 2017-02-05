<?php

namespace App\Core;

use App\Core\Abstracts\Singleton;

class Session
{
    use Singleton;
    protected function __construct()
    {
        session_start();
    }

    public function get($var, $default = null)
    {
        return
            isset($_SESSION[$var])
                ? $_SESSION[$var]
                : $default;
    }

    public function set($var, $value)
    {
        $_SESSION[$var] = $value;
    }
}
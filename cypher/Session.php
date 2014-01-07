<?php

namespace cypher;

class Session
{

    protected static $sessionStarted = false;
    protected static $sessionRegenerated = false;

    public function __construct()
    {
        if (!self::$sessionStarted) {
            session_start();

            self::$sessionStarted = true;
        }
    }

    public function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public function get($name, $default = null)
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
        return $default;
    }

    public function remove($name)
    {
        unset($_SESSION[$name]);
    }

    public function regenerate($destroy = true)
    {
        if (!self::$sessionRegenerated) {
            session_regenerate_id($destroy);

            self::$sessionRegenerated = true;
        }
    }
}

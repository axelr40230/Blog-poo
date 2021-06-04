<?php


namespace App;

use Singleton;

class Session
{
    private static $_instance = null;

    private function __construct()
    {
        session_start();
    }

    static public function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new Session();
        }

        return self::$_instance;
    }

    static public function getInstance(string $key)
    {
        self::instance();

        if (array_key_exists($key, $_SESSION)) {

            return $_SESSION[$key];
        }

        return null;
    }

    static public function setInstance(string $key, $value = null): void
    {
        self::instance();

        $_SESSION[$key] = $value;
    }

    static public function destroy()
    {
        self::setInstance('id');
        self::setInstance('first_name');
        self::setInstance('last_name');
        self::setInstance('email');
    }
}
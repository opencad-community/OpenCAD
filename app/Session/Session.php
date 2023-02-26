<?php

namespace Opencad\App\Session;

class Session
{
    /**
     * Constructor that automatically starts the session.
     */
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Stores a value in the session.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Retrieves a value from the session.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }

    /**
     * Removes a value from the session.
     *
     * @param string $key
     * @return void
     */
    public static function remove($key)
    {
        unset($_SESSION[$key]);
    }

    /**
     * Ends the current session.
     *
     * @return void
     */
    public static function end()
    {
        session_unset();
        session_destroy();
    }

     /**
     * Retrieves all set session variables.
     *
     * @return array
     */
    public static function getAll()
    {
        return $_SESSION;
    }
}

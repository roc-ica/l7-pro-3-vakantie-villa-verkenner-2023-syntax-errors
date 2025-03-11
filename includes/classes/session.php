<?php

class Session
{
    // start session
    public static function init()
    {
        if (version_compare(phpversion(), '5.4.0', '<')) {
            if (session_id() == '') {
                session_start();
            }
        } else {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
        }
    }

    // set session
    public static function set($key, $val)
    {
        $_SESSION[$key] = $val;
    }

    // session get
    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return false;
        }
    }

    // gebruiker uitloggen
    public static function destroy()
    {
        session_destroy();
        session_unset();
        header('Location:/admin/login.php');
    }

    //  gebruiker controleren
    public static function CheckSession()
    {
        if (self::get('login') == FALSE) {
            session_destroy();
            header('Location:/admin/login.php');
        }
    }

    // controleer of de gebruiker is ingelogd
    public static function CheckLogin()
    {
        if (self::get("login") == TRUE) {
            header("Location:/admin/");
        }
    }

}
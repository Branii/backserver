<?php

use Josantonius\Session\Session;
class SessionMan
{
    public function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            return session_start();
        }
    }

    public function isUserLoggedIn()
    {
        $this->startSession();
        return isset($_SESSION["isUserLoggedIn"]);
    }

    public function isSessionStarted()
    {
        if (session_status() === PHP_SESSION_NONE) {
            return false;
        }
        return true;
    }

    public function setSession($key, $value = '')
    {
        $_SESSION['isUserLoggedIn'] = true;
        return $_SESSION[$key] = $value;
    }

    public function destroySession()
    {
        return session_destroy();
    }

    public function checkSession()
    {
        $this->startSession();
        return isset($_SESSION["isUserLoggedIn"]);
    }

    public function getSession(?string $key)
    {
         return $_SESSION[$key];
    }

    public function updateUserData($key, $value)
    {
        return $_SESSION[$key] = $value;
    }

    public function getSessionID()
    {
        return session_id();
    }

    public function getSessionData()
    {
        return $_SESSION;
    }

    //generate session id
    public function regenerateId(){
        return session_regenerate_id(true);
    }

}
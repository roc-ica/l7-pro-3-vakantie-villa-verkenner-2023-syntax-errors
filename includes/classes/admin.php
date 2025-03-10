<?php

class Admin {
    private $username = "admin";
    private $password = "password";

    public function login($inputUsername, $inputPassword) {
        if ($inputUsername === $this->username && $inputPassword === $this->password) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $this->username;
            return true;
        } else {
            return false;
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
    }

    public function isLoggedIn() {
        return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
    }
}

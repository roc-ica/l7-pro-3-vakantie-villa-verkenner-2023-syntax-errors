<?php

class Admin {
    
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function login($input) {
        $username = "VillaAdmin";
        $password = "VA1234";
        
        if ($input['username'] == $username && $input['password'] == $password) {
            Session::set('login', true);
            Session::set('id', 1);
        } else {
            echo "Login failed";
        }
    }

}

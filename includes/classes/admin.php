<?php

class Admin {
    
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function login($input) {
        $email = "VillaAdmin";
        $password = "VA1234";
        
        if ($input['email'] == $email && $input['password'] == $password) {
            Session::set('login', true);
            Session::set('id', 1);
        } else {
            echo "Login failed";
        }
    }

}

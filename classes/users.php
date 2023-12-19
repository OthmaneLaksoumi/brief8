<?php

class users {
    private $email;
    private $username;
    private $pass;
    private $state;
    private $role;

    public function __construct($email, $username, $pass, $state, $role) {
        $this->email = $email;
        $this->username = $username;
        $this->pass = $pass;
        $this->state = $state;
        $this->role = $role;
    }
 
    public function getEmail()
    {
        return $this->email;
    }
 
    public function getUsername()
    {
        return $this->username;
    }
 
    public function getPass()
    {
        return $this->pass;
    }
 
    public function getState()
    {
        return $this->state;
    }
 
    public function getRole()
    {
        return $this->role;
    }
}


?>
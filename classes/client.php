<?php

class client
{
    private $full_name;
    private $username;
    private $email;
    private $password;
    private $adresse;
    private $ville;
    private $phone;

    public function __construct($full_name, $username, $email, $password, $adresse, $ville, $phone)
    {
        $this->full_name = $full_name;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->adresse = $adresse;
        $this->ville = $ville;
        $this->phone = $phone;
    }
    public function getFull_name()
    {
        return $this->full_name;
    }
 
    public function getUsername()
    {
        return $this->username;
    }
 
    public function getEmail()
    {
        return $this->email;
    }
 
    public function getPassword()
    {
        return $this->password;
    }
 
    public function getAdresse()
    {
        return $this->adresse;
    }
 
    public function getVille()
    {
        return $this->ville;
    }
 
    public function getPhone()
    {
        return $this->phone;
    }
}

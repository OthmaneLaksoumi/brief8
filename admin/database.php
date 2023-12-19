<?php
require_once('db_config.php');

class database
{

    private $conn;
    public function __construct()
    {
        $this->conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    }

    public function getConn()
    {
        return $this->conn;
    }
}
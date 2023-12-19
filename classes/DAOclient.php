<?php
require_once("database.php");
require_once("client.php");

class DAOclient
{
    private $db;

    public function __construct()
    {
        $conn = new database();
        $this->db = $conn->getConn();
    }

    public function get_client()
    {
        $query = "SELECT * FROM clients";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $client = array();
        foreach ($result as $row) {
            $client[] = new client($row["full_name"], $row["username"], $row["email"], $row["password"], $row["adresse"], $row["ville"], $row["phone"]);
        }
        return $client;
    }
}

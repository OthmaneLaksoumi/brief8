<?php
require_once("database.php");
require_once("panier.php");

class DAOpanier
{
    private $db;

    public function __construct()
    {
        $conn = new database();
        $this->db = $conn->getConn();
    }

    public function get_panier()
    {
        $query = "SELECT * FROM panier";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $panier = array();
        foreach ($result as $row) {
            $panier[] = new panier($row['client_username'], $row['product_ref'], $row['qnt']);
        }
        return $panier;
    }
}
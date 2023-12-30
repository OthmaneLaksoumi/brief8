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

    public function get_panier($client_username = 0, $product_ref = 0)
    {
        if ($client_username == 0) {
            $query = "SELECT * FROM panier";
        } else {
            if ($product_ref == 0) {
                $query = "SELECT * FROM panier WHERE client_username = '$client_username'";
            } else {
                $query = "SELECT * FROM panier WHERE client_username = '$client_username' AND product_ref = '$product_ref'";
            }
        }
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $panier = array();
        foreach ($result as $row) {
            $panier[] = new panier($row['client_username'], $row['product_ref'], $row['qnt']);
        }
        return $panier;
    }

    public function insert_panier($panier) {
        $query = 'INSERT INTO panier VALUES (?, ?, ?)';
        $stmt = $this->db->prepare($query);
        $stmt->execute([$panier->getClient_username(), $panier->getProduct_ref(), $panier->getQnt()]);
    }

    public function update_panier($panier) {
        $query = 'UPDATE panier SET qnt = ? WHERE product_ref = ? AND client_username = ?';
        $stmt = $this->db->prepare($query);
        $stmt->execute([$panier->getQnt(), $panier->getProduct_ref(), $panier->getClient_username()]);
    }

    public function delete_panier($panier) {
        $query = 'DELETE FROM panier WHERE client_username = ? AND product_ref = ?';
        $stmt = $this->db->prepare($query);
        $stmt->execute([$panier->getClient_username(), $panier->getProduct_ref()]);
    }

}

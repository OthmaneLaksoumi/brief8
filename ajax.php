<?php
session_start();
require("classes\DAOpanier.php");

$DAOpanier = new DAOpanier();

$conn = new PDO('mysql:host=localhost;dbname=brief8', 'root', '');
if (isset($_GET['ref'])) {
    $client1 = $_SESSION['client'];
    $ref = $_GET['ref'];
    $result = $DAOpanier->get_panier($client1, $ref);

    if (empty($result)) {
        $panier = new panier($client1, $ref, 1);
        $DAOpanier->insert_panier($panier);
    } else if (isset($_GET['qty'])) {
        $qnt = $_GET['qty'];
        $panier = new panier($client1, $ref, $qnt);
        $DAOpanier->update_panier($panier);
    }
}

if (isset($_GET["client"]) && isset($_GET["refProduct"]) && isset($_GET["qnt"])) {
    $client2 = $_GET["client"];
    $ref = $_GET["refProduct"];
    $qnt = $_GET["qnt"];
    $panier = new panier($client2, $ref, $qnt);
    if ($qnt > 0) {
        $DAOpanier->update_panier($panier);
    } else if ($qnt === 0) {
        $stmt2 = $conn->prepare("DELETE FROM panier WHERE client_username = '$client2' AND product_ref = '$ref'");
        $stmt2->execute();
    }
}

if (isset($_GET["clientRemove"]) && isset($_GET["refProductRemove"])) {
    $client = $_GET["clientRemove"];
    $ref = $_GET["refProductRemove"];
    $panier = new panier($client, $ref);
    $DAOpanier->delete_panier($panier);
}

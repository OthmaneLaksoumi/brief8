<?php
require_once('database.php');

class data
{
    private $connection;

    public function __construct()
    {
        $conn = new database();
        $this->connection = $conn->getConn();
    }

    public function get_data($table, $condition = "")
    {
        if (empty($condition)) {
            $sql = "SELECT * FROM `$table`";
        } else {
            $sql = "SELECT * FROM `$table` WHERE $condition";
        }

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert_product($title, $desc, $codeBar, $img, $prixAchat, $prixFinal, $prixOffre, $qntMin, $qntStock, $catg)
    {
        if (!$this->get_data("products", "codeBarres = '$codeBar'")) {
            $sql = "INSERT INTO products(etiquette, descpt, codeBarres, img, prixAchat, prixFinal, prixOffre, qntMin, qntStock, catg) VALUES
        ('$title', '$desc', '$codeBar', '$img', '$prixAchat', '$prixFinal', '$prixOffre', '$qntMin', '$qntStock', '$catg')";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
        }
    }

    public function update_product($ref, $title, $desc, $img, $prixAchat, $prixFinal, $prixOffre, $qntMin, $qntStock, $catg)
    {
        $sql = "UPDATE products SET 
        `etiquette` = '$title', `descpt` = '$desc', `prixAchat` = '$prixAchat', `prixFinal` = '$prixFinal', `prixOffre` = '$prixOffre',
        `qntMin` = '$qntMin', `qntStock` = '$qntStock', `catg` = '$catg', `img` = '$img' WHERE `reference` = '$ref'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
    }

    public function hide_product($ref, $hideValue)
    {
        $sql = "UPDATE products SET isHide = '$hideValue' WHERE reference = '$ref'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
    }

    public function insert_categorie($name, $descrt, $img)
    {
        if (!$this->get_data("categories", "name = '$name'")) {
            $sql = "INSERT INTO categories (name, descrt, img) VALUES ('$name', '$descrt', '$img')";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
        }
    }
    public function update_categorie($oldName, ...$data) {
        $name = $data[0];
        $descrt = $data[1];
        if(isset($data[2])) {
            $img = $data[2];
            $sql = "UPDATE categories SET `name` = '$name', `descrt` = '$descrt', `img` = '$img' WHERE `name` = '$oldName'";
        } else {
            $sql = "UPDATE categories SET `name` = '$name', `descrt` = '$descrt' WHERE `name` = '$oldName'";
        }
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
    }

    public function hide_categorie($name, $hide_value) {
        $sql = "UPDATE categories SET `isHide` = '$hide_value' WHERE `name` = '$name'";
        $stmt = $this->connection->prepare($sql);   
        $stmt->execute();
    }
    public function valide_user($username)
    {
        $sql = "UPDATE users SET state = 1 WHERE username = '$username'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
    }

    public function delete_user($username)
    {
        $sql = "DELETE FROM users WHERE username = '$username'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
    }

    public function update_user($username, $state, $role = 0)
    {
        $sql = "UPDATE users SET state = '$state', role = '$role' WHERE username = '$username'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
    }
}

$test = new data();
// $desc = "Module afficheur monochrome OLED 0,91” 128 x 32 pixels basé sur un circuit SSD1306. Ce module communique avec un microcontrôleur de type Arduino ou compatible via le bus I2C.";
// $img = "assets/images/Afficheur_img4.png";
// $test->update_product(1, "Afficheur Oled 0.91 I2C pour Arduino????", $desc, $img, 30, 55, 40, 55, 65, "Afficheur");

// $users = new data();
// $user = $users->get_data("products", "codeBarres = 'code44444'");
// echo '<pre>';
// print_r($user);
// echo '</pre>';



// $users->insert_product("test2", "description", "code555555", "assets/images/Afficheur_img8.png", 44, 55, 50, 50, 55, "Afficheur");

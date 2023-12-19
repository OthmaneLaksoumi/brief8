<?php
require_once("database.php");
require_once("categories.php");

class DAOcategorie
{
    private $db;

    public function __construct()
    {
        $conn = new database();
        $this->db = $conn->getConn();
    }

    public function get_categorie($isHide = 0)
    {
        $query = "SELECT * FROM categories WHERE isHide = '$isHide'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $categories_objects = array();
        foreach ($result as $category) {
            $categories_objects[] = new categories($category['name'], $category['descrt'], $category['img'], $category['isHide']);
        }
        return $categories_objects;
    }

    public function insert_categorie($categorie)
    {
        if (!in_array($categorie, array_merge($this->get_categorie(0), $this->get_categorie(1)))) {
            $query = "INSERT INTO categories (`name`, `descrt`, `img`) VALUES 
            ('" . $categorie->getName() . "', '" . $categorie->getDescrt() . "', '" . $categorie->getImg() . "')
        ";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
        }
    }

    public function update_categorie($old_categorie, $new_categorie)
    {
        $old_name = $old_categorie->getName();
        $name = $new_categorie->getName();
        $desct = $new_categorie->getDescrt();
        $img = $new_categorie->getImg();
        if ($new_categorie->getImg() == NULL) {
            $query = " UPDATE categories SET `name` = '$name', `descrt` = '$desct' WHERE `name` = '$old_name' ";
        } else {
            $query = " UPDATE categories SET `name` = '$name', `descrt` = '$desct', `img` = '$img' WHERE `name` = '$old_name' ";
        }
        $stmt = $this->db->prepare($query);
        $stmt->execute();
    }

    public function hide_catgeorie($catgeorie, $isHide)
    {
        $query = "UPDATE categories SET isHide = '$isHide' WHERE `name` = '" . $catgeorie->getName() . "'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
    }
}

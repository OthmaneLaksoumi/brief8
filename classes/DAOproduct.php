<?php
require_once("database.php");
require_once("product.php");

class DAOproduct
{
    private $db;

    public function __construct()
    {
        $db = new database();
        $this->db = $db->getConn();
    }

    public function get_product($isHide = 0)
    {
        $query = "SELECT * FROM products WHERE isHide = '$isHide'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $product_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $products_objects = array();

        foreach ($product_data as $p) {
            $products_objects[] = new product($p['reference'], $p['etiquette'], $p['descpt'], $p['codeBarres'], $p['img'], $p['prixAchat'], $p['prixFinal'], $p['prixOffre'], $p['qntMin'], $p['qntStock'], $p['catg'], $p['isHide']);
        }
        return $products_objects;
    }

    public function insert_product($product)
    {
        if (!in_array($product,array_merge($this->get_product(0), $this->get_product(1)))) {
            $query = "INSERT INTO products
        (etiquette, descpt, codeBarres, img, prixAchat, prixFinal, prixOffre, qntMin, qntStock, catg)
        VALUES 
        ('" . $product->getEtiquette() . "', '" . $product->getDescpt() . "', '" . $product->getCodeBarres() . "', '" . $product->getImg() . "', '" . $product->getPrixAchat() . "', 
        '" . $product->getPrixFinal() . "', '" . $product->getPrixOffre() . "', '" . $product->getQntMin() . "', '" . $product->getQntStock() . "', '" . $product->getCatg() . "')
        ";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
        }
    }

    public function update_product($product, $with_image)
    {
        $ref = $product->getReference();
        if ($with_image === true) {
            $query = "UPDATE products SET
            `etiquette` = '" . $product->getEtiquette() . "', descpt = '" . $product->getDescpt() . "', codeBarres = '" . $product->getCodeBarres() . "',
            img = '" . $product->getImg() . "', prixAchat = '" . $product->getPrixAchat() . "', prixFinal = '" . $product->getPrixFinal() . "', prixOffre = '" . $product->getPrixOffre() . "', qntMin = '" . $product->getQntMin() . "', qntStock = '" . $product->getQntStock() . "', catg = '" . $product->getCatg() . "' WHERE reference = '$ref';
            ";
        } else {
            $query = "UPDATE products SET
            `etiquette` = '" . $product->getEtiquette() . "', descpt = '" . $product->getDescpt() . "', codeBarres = '" . $product->getCodeBarres() . "',
            prixAchat = '" . $product->getPrixAchat() . "', prixFinal = '" . $product->getPrixFinal() . "', prixOffre = '" . $product->getPrixOffre() . "', qntMin = '" . $product->getQntMin() . "', qntStock = '" . $product->getQntStock() . "', catg = '" . $product->getCatg() . "' WHERE reference = '$ref';
            ";
        }
        $stmt = $this->db->prepare($query);
        $stmt->execute();
    }

    public function hide_product($product, $isHide) {
        $ref = $product->getReference();
        $query = "UPDATE products SET isHide = '$isHide' WHERE reference = '$ref'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
    }
}


// $data = new DAOproduct();
// $product = new product(98, "product test 2", "Description For produ test 2", "codetest1", "Image Path", 40, 50, 48, 150, 178, "Afficheur", 0);

// $data->update_product($product, true);

// echo '<pre>';
// // var_dump(in_array($product, $data->get_product()));
// // print_r($data->get_product());
// echo '</pre>';

// echo $product->getPrixAchat();

// $data->insert_product($product);

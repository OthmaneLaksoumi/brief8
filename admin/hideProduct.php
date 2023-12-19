<?php
session_start();    
require_once("../classes/DAOproduct.php");
require_once("../classes/DAOcategories.php");

$DAOproduct = new DAOproduct();
$DAOcategorie = new DAOcategorie();

$product = $DAOproduct->get_product();
$catgs = $DAOcategorie->get_categorie();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $reference_of_product = (int)$_POST["hided"];
    foreach ($product as $item) {
        if ($item->getReference() == $reference_of_product) {
            $product_hided = $item;
            break;
        }
    }
    $DAOproduct->hide_product($product_hided, 1);
    header("Location: hideProduct.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>



    </style>
</head>

<body>
    <?php include("head.php") ?>

    <section class="dashboard">
        <?php
        include("sideBar.html");
        ?>
        <div class="col-md-10">

            <h1>Masquer une Produit</h1>
            <?php
            if (count($product) > 0) {
            ?>
                <form action="" method="post" class="container">
                    <div class="mb-3">
                        <label for="catg" class="form-label">Choisir un Produit</label>
                        <select name="hided" id="catg" class="form-control">
                            <?php
                            foreach ($catgs as $catg) {
                                $temp = $catg->getName();
                                $res = array();
                                foreach ($product as $item) {
                                    if ($item->getCatg() == $temp && $item->getIsHide() == 0) {
                                        $res[] = $item;
                                    }
                                }
                                if (count($res) > 0) {
                                    echo "<optgroup label=" . $catg->getName() . ">" . $catg->getName();

                                    foreach ($product as $item) {
                                        if ($item->getCatg() === $catg->getName()) {
                                            $ref = $item->getReference();
                                            echo "<option value='$ref'>" . $item->getEtiquette() . "</option>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <input type="submit" class="btn btn-primary my-2" value="Masquer">
                </form>
            <?php } else {
                echo "<p class='all-valid'>Tous les produits sont masqués.</p>";
            } ?>

        </div>
    </section>
</body>

</html>
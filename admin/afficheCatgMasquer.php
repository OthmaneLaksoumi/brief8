<?php
session_start();
require_once("../classes/DAOcategories.php");
require_once("../classes/DAOproduct.php");

$DAOcategorie = new DAOcategorie();
$DAOproduct = new DAOproduct();

$catgs = $DAOcategorie->get_categorie(1);
$products = $DAOproduct->get_product(1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $afficheCatg = $_POST["affiche"];

    foreach($catgs as $catg) {
        if($catg->getName() == $afficheCatg) {
            $DAOcategorie->hide_catgeorie($catg, 0);
        }
    }

    foreach( $products as $product ) {
        if($product->getCatg() == $afficheCatg) {
            $DAOproduct->hide_product($product, 0);
        }
    }

    header("Refresh: 1; url=afficheCatgMasquer.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
            <h1>Afficher une Produit masqué</h1>
            <?php
            if (count($catgs) > 0) {
                ?>
                <form action="" method="post" class="container">
                    <div class="mb-3">
                        <label for="catg" class="form-label">Choisir une categorie</label>
                        <select name="affiche" id="" class="form-control">
                            <?php


                            foreach ($catgs as $row) {
                                echo "<option>" . $row->getName() . "</option>";

                            }


                            ?>
                        </select>
                    </div>



                    <input type="submit" class="btn btn-primary my-2" value="Afficher">
                </form>
            <?php } else {
                echo "<p class='all-valid'>Tous les categories sont affichés.</p>";
            } ?>
        </div>
    </section>

</body>

</html>
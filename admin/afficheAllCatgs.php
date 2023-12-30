<?php
session_start();
require_once("../classes/DAOcategories.php");


$DAOcategorie = new DAOcategorie();

if ($_SESSION["role"] == 1) {
    $catgs = array_merge($DAOcategorie->get_categorie(0), $DAOcategorie->get_categorie(1));
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <title>Dashboard</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <?php include('head.php') ?>

        <section class="dashboard">

            <?php
            include("sideBar.html");
            ?>
            <div class="col-md-10 product-menu">
                <?php
                foreach ($catgs as $catg) {
                    $img = $catg->getImg();
                    $title = $catg->getName();
                    $desc = $catg->getDescrt();
                    $card = "
             <div class='product-item card-pos'>
                 <img src= " . $img . ">
                 <h5>$title</h5>
                 <p><span class='fw-bold'>Description</span>: $desc</p>                 
             </div>
         ";
                    echo $card;
                }
                ?>
            </div>
        </section>

    </body>

    </html>

<?php } else {
    header('location: index.php');
    exit;
} ?>
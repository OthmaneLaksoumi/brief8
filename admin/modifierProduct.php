<?php
session_start();
// include("allData.php");
require_once("../classes/DAOproduct.php");
require_once("../classes/DAOcategories.php");
// $data = new data();
$productDAO = new DAOproduct();
$categorieDAO = new DAOcategorie();
if (isset($_SESSION["role"]) && $_SESSION["role"] == 1) {
    // $product = $data->get_data("products");
    // $catgs = $data->get_data("categories");
    $product = array_merge($productDAO->get_product(0), $productDAO->get_product(1));
    $catgs = array_merge($categorieDAO->get_categorie(0), $categorieDAO->get_categorie(1));
    $productModifier = NULL;


    // die();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        if (isset($_POST["hided"])) {
            $title_of_modified_product = $_POST["hided"];
            foreach ($product as $object) {
                if ($object->getEtiquette() == $title_of_modified_product) {
                    setcookie("ref", $object->getReference());
                    setcookie("img", $object->getImg());
                    setcookie("codeBarre", $object->getCodeBarres());
                    setcookie("isHide", $object->getIsHide());

                    $productModifier = $object;
                }
            }
        }




        if (isset($_POST["modifie"])) {
            $ref = (int)$_COOKIE["ref"];
            $title = $_POST['title'];
            $prixAchat = $_POST['prixAchat'];
            $prixFinal = $_POST['prixFinal'];
            $prixOffre = $_POST['prixOffre'];
            $desc = $_POST['desc'];
            $qntMin = $_POST['qntMin'];
            $qntStock = $_POST['qntStock'];
            $catg = $_POST['catg'];
            $img = "assets/images/" . $_FILES['img']['name'];

            $new_product = new product($ref, $title, $desc, $_COOKIE['codeBarre'], $img, $prixAchat, $prixFinal, $prixOffre, $qntMin, $qntStock, $catg, $$_COOKIE['isHide']);
            if (!empty($_FILES['img']['name'])) {
                move_uploaded_file($_FILES['img']['tmp_name'], 'C:\xampp\htdocs\brief8\admin\assets\images\\' . $_FILES['img']['name']);
                $productDAO->update_product($new_product, true);
            } else {
                $img = $_COOKIE['img'];
                $productDAO->update_product($new_product, false);
            }
            setcookie("ref", "", time() - 1);
            setcookie("img", "", time() - 1);
            setcookie("codeBarre", "", time() - 1);
            setcookie("isHide", "", time() - 1);
            header("Location: modifierProduct.php");
            exit;
        }
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
            <!-- </div> -->
            <!-- </div> -->



            <div class="col-md-10">
                <h1>Modifier une Produit</h1>
                <form action="" method="post" class="container">
                    <div class="mb-3">
                        <label for="catg" class="form-label">Choisir une Produit</label>
                        <select name="hided" id="" class="form-control">
                            <?php
                            foreach ($catgs as $catg) {
                                echo "<optgroup label=" . $catg->getName() . ">" . $catg->getName();
                                foreach ($product as $item) {
                                    if ($item->getCatg() === $catg->getName()) {
                                        if ($productModifie["etiquette"] === $item->getEtiquette()) {
                                            echo "<option selected>" . $item->getEtiquette() . "</option>";
                                        } else {
                                            echo "<option>" . $item->getEtiquette() . "</option>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>



                    <input type="submit" class="btn btn-primary my-2" value="Choisir">
                </form>

                <?php
                if ($_SERVER["REQUEST_METHOD"] === "POST") {
                ?>
                    <div class="mb-3 d-flex justify-content-center">
                        <img class="my-5" src='<?php echo $productModifier->getImg() ?>'>
                    </div>
                    <form action="" method="post" class="container modifie-pro d-flex align-items-center" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value='<?php echo $productModifier->getEtiquette() ?>' required>
                        </div>
                        <div class="mb-3">
                            <label for="img" class="form-label">Upload Image</label>
                            <input type="file" class="form-control" id="img" name="img">
                        </div>
                        <div class="mb-3">
                            <label for="prixAchat" class="form-label">Prix d'achat</label>
                            <input type="text" class="form-control" id="prixAchat" name="prixAchat" value='<?php echo $productModifier->getPrixAchat() ?>' required>
                        </div>
                        <div class="mb-3">
                            <label for="prixFinal" class="form-label">Prix Final</label>
                            <input type="text" class="form-control" id="prixFinal" name="prixFinal" value='<?php echo $productModifier->getPrixFinal() ?>' required>
                        </div>
                        <div class="mb-3">
                            <label for="prixOffre" class="form-label">Prix Offre</label>
                            <input type="text" class="form-control" id="prixOffre" name="prixOffre" value='<?php echo $productModifier->getPrixOffre() ?>' required>
                        </div>
                        <div class="mb-3">
                            <label for="desc" class="form-label">Description</label>
                            <textarea type="text" class="form-control" id="desc" name="desc" rows="4" required><?php echo $productModifier->getDescpt() ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="qntMin" class="form-label">Quantity Minimale</label>
                            <input type="text" class="form-control" id="qntMin" name="qntMin" value='<?php echo $productModifier->getQntMin() ?>' required>
                        </div>
                        <div class="mb-3">
                            <label for="qntStcok" class="form-label">Quantity Stock</label>
                            <input type="text" class="form-control" id="qntStock" name="qntStock" value='<?php echo $productModifier->getQntStock() ?>' required>
                        </div>

                        <div class="mb-3">
                            <label for="catg" class="form-label">Category</label>
                            <select name="catg" id="" class="form-control">
                                <?php
                                foreach ($catgs as $item) {
                                    if ($item->getName() === $productModifier->getCatg()) {
                                        echo "<option selected>" . $item->getName() . "</option>";
                                    } else {
                                        echo "<option>" . $item->getName() . "</option>";
                                    }
                                }
                                // 
                                ?>
                            </select>
                        </div>

                        <input type="submit" class="btn btn-primary my-2" name="modifie" value="Modifier">



                    </form>

                <?php } ?>
            </div>
        </section>

    </body>

    </html>
<?php } else {
    header("Location: index.php");
}    ?>
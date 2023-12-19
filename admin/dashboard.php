<?php
session_start();
require_once("../classes/DAOproduct.php");
require_once("../classes/DAOcategories.php");

$productDAO = new DAOproduct();
$categorieDAO = new DAOcategorie();

$catgs = $categorieDAO->get_categorie();



if ($_SESSION['role'] == 1) { ?>
    <?php

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        for ($i = 1; $i <= 10; $i++) {
            if (isset($_POST["title" . $i])) {
                $title = $_POST["title" . $i];
                $codeBar = $_POST["codeBar" . $i];
                $prixAchat = $_POST["prixAchat" . $i];
                $prixFinal = $_POST["prixFinal" . $i];
                $prixOffre = $prixFinal - 8;
                $desc = $_POST["desc" . $i];
                $qntMin = $_POST["qntMin" . $i];
                $qntStock = $_POST["qntStock" . $i];
                $img = "assets/images/" . str_replace(" ", "", $_FILES["img" . $i]["name"]);
                $catg = $_POST["catg" . $i];

                $product = new product(NULL, $title, $desc, $codeBar, $img, $prixAchat, $prixFinal, $prixOffre, $qntMin, $qntStock, $catg, 0);
                $productDAO->insert_product($product);

                // $data->insert_product($title, $desc, $codeBar, $img, $prixAchat, $prixFinal, $prixOffre, $qntMin, $qntStock, $catg);
                
                move_uploaded_file($_FILES["img" . $i]['tmp_name'], 'C:\xampp\htdocs\brief8\admin\assets\images\\' . str_replace(" ", "", $_FILES["img" . $i]["name"]));
            }
        }
        header("Location: dashboard.php");
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
        <style></style>
    </head>

    <body>
        <?php include("head.php") ?>
        <section class="dashboard">
            <?php
            include("sideBar.html");
            ?>

            <div class="col g-3 container-form">
                <h1>Ajouter un Produit</h1>

                <form class="container" id="nbrOfProductForm" onsubmit="event.preventDefault();">
                    <div class="mb-3">
                        <label for="title" class="form-label">Entre Le nombre de produit que vous pouvez ajouter</label>
                        <input type="number" class="form-control" id="nbrOfProduct" name="nbrOfProduct" required>
                    </div>
                    <input type="submit" class="btn btn-primary" id="nbrSubmit" value="Entrer">
                </form>

                <form method="post" class="container" id="allForm" enctype="multipart/form-data"></form>


            </div>

        </section>



        <script>
            let nbrOfProduct = document.getElementById('nbrOfProduct');
            let nbrSubmit = document.getElementById('nbrSubmit');
            let addForm = document.querySelector('#allForm');


            function createProductSection(nbr) {
                let productSection = document.createElement('div');
                productSection.className = 'container productInsert';
                productSection.style.background = '#eee';
                productSection.style.width = '75%';
                productSection.style.marginBottom = '20px';
                productSection.style.marginTop = '20px';
                productSection.style.padding = '10px';
                productSection.style.cursor = 'pointer';
                productSection.style.border = 'black 1px solid';
                productSection.innerText = 'Product ' + nbr;
                return productSection;
            }

            function createForm(nbr) {
                let formInsert = document.createElement('div');
                // formInsert.setAttribute('method', 'Post');
                // formInsert.setAttribute('enctype', 'multipart/form-data');
                formInsert.className = 'container';
                formInsert.id = 'formInser-' + nbr;
                formInsert.innerHTML = `
                        <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title${nbr}" required>
                            </div>
                            <div class="mb-3">
                                <label for="img" class="form-label">Upload Image</label>
                                <input type="file" class="form-control" id="img" name="img${nbr}" required>
                            </div>
                            <div class="mb-3">
                                <label for="codeBar" class="form-label">Code à Bare</label>
                                <input type="text" class="form-control" id="codeBar" name="codeBar${nbr}" required>
                            </div>
                            <div class="mb-3">
                                <label for="prixAchat" class="form-label">Prix d'achat</label>
                                <input type="text" class="form-control" id="prixAchat" name="prixAchat${nbr}" required>
                            </div>
                            <div class="mb-3">
                                <label for="prixFinal" class="form-label">Prix Final</label>
                                <input type="text" class="form-control" id="prixFinal" name="prixFinal${nbr}" required>
                            </div>
                            <div class="mb-3">
                                <label for="desc" class="form-label">Description</label>
                                <textarea type="text" class="form-control" id="desc" name="desc${nbr}" rows="4" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="qntMin" class="form-label">Quantity Minimale</label>
                                <input type="text" class="form-control" id="qntMin" name="qntMin${nbr}" required>
                            </div>
                            <div class="mb-3">
                                <label for="qntStcok" class="form-label">Quantity Stock</label>
                                <input type="text" class="form-control" id="qntStock" name="qntStock${nbr}" required>
                            </div>
                            <div class="mb-3">
                                <label for="catg" class="form-label">Category</label>
                                <select name="catg${nbr}" id="" class="form-control">
                                    <?php
                                    foreach ($catgs as $item) {
                                        echo "<option>" . $item->getName() . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        `;
                return formInsert;
            }

            let paragraph = document.createElement('p');

            nbrSubmit.addEventListener('click', function() {
            console.log(44);
                if (nbrOfProduct.value < 1 || nbrOfProduct.value > 10) {
                    paragraph.innerText = "Please Enter a number between 1 and 10";
                    document.getElementById("nbrOfProductForm").appendChild(paragraph);
                } else {
                    paragraph.style.display = 'none';
                    for (let i = 0; i < nbrOfProduct.value; i++) {
                        addForm.appendChild(createProductSection(i + 1));
                        addForm.appendChild(createForm(i + 1));
                        console.log(document.getElementById(`formInser-${i + 1}`));
                        document.getElementById(`formInser-${i + 1}`).style.display = 'none';
                    }
                    addForm.innerHTML += `
                    <div class="mb-3">
                    <input type="submit" class="btn btn-primary my-5 form-control" name="product" value="Ajouter">

                            </div>
                    `;
                    let productInsert = document.querySelectorAll('.productInsert');
                    productInsert.forEach(function(pro, i) {
                        pro.addEventListener('click', function() {
                            if (document.getElementById(`formInser-${i + 1}`).style.display === 'none') {
                                document.getElementById(`formInser-${i + 1}`).style.cssText = `
                                    display: flex;  
                                    flex-direction: column;
                                    align-items: center;
                                `;
                            } else {
                                document.getElementById(`formInser-${i + 1}`).style.display = 'none';
                            }

                        });
                    });

                }
            });
        </script>



    </body>

    </html>

<?php } else {
    header('Location: index.php');
}

?>
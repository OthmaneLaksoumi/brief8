<?php
session_start();
require_once("../classes/DAOcategories.php");

$DAOcategorie = new DAOcategorie();

if ($_SESSION['role'] == 1) {

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        for ($i = 1; $i <= 10; $i++) {
            if (isset($_POST["name" . $i])) {
                $name = $_POST["name" . $i];
                $desc = $_POST["desc" . $i];
                $img = "assets/catgImages/" . $_FILES["img" . $i]['name'];
                $categorie_to_add = new categories($name, $desc, $img, 0);
                $DAOcategorie->insert_categorie($categorie_to_add);
                // $data->insert_categorie($name, $desc, $img);
                move_uploaded_file($_FILES["img" . $i]['tmp_name'], 'C:\xampp\htdocs\brief8\admin\assets\catgImages\\' . $_FILES["img" . $i]['name']);
            }
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
        <style></style>
    </head>

    <body>
        <?php include("head.php") ?>
        <section class="dashboard">
            <?php
            include("sideBar.html");
            ?>
            <div class="col g-3 container-form">
                <h1>Ajouter une categorie</h1>

                <form class="container" id="nbrOfProductForm" onsubmit="event.preventDefault();">
                    <div class="mb-3">
                        <label for="title" class="form-label">Entrez Le nombre de categories que vous pouvez ajoter</label>
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
                productSection.innerText = 'Categorie ' + nbr;
                return productSection;
            }

            function createForm(nbr) {
                let formInsert = document.createElement('div');
                formInsert.className = 'container';
                formInsert.id = 'formInser-' + nbr;
                formInsert.innerHTML = `
                <div class="mb-3">
                    <label for="title" class="form-label">Name de categorie</label>
                    <input type="text" class="form-control" id="title" name="name${nbr}" required>
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Description de categorie</label>
                    <textarea type="text" class="form-control" id="title" name="desc${nbr}" rows="4" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="img" class="form-label">Upload Image</label>
                    <input type="file" class="form-control" id="img" name="img${nbr}" required>
                </div>
                           
                
                        `;
                return formInsert;
            }

            // console.log(createForm());
            // addForm.appendChild(createForm());

            // console.log(createProductSection(5));

            // addForm.appendChild(productSection);
            let paragraph = document.createElement('p');

            nbrSubmit.addEventListener('click', function() {
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
                        <input type="submit" class="btn btn-primary my-5 container" value="Ajouter">
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
    exit;
}

?>
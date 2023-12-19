<?php
session_start();
require_once("allData.php");


try {
    $data = new data();
    $products = $data->get_data("products", "isHide = 0");

} catch (Exception $e) {
    echo $e->getMessage();
}


if ($_SESSION["state"] == 1) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Products</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">

    </head>



    <body>

        <?php include("head.php") ?>

        <?php echo "<h1>Welcome " . $_COOKIE["username"] . "</h1>"; ?>



        <?php
        if (count($products) > 0) {
        ?>
            <div class="select">
                <select id="filter">
                    <option value="0">All</option>
                </select>

            </div>
        <?php } else {
            echo "<p class='all-valid bg-warning'>Tous les produits sont masqués.</p>";
        }
        ?>

        <div class="product-menu">

        </div>

        <ul class="pagination" id="pagination">

        </ul>


        <!-- <script src="script.js"></script> -->
        <script>
            function getData(tableName) {
                var result;
                let myRequest = new XMLHttpRequest();
                myRequest.open("GET", "ajaxConn.php?table=" + tableName, false);
                myRequest.onreadystatechange = function() {
                    if (this.readyState === 4 && this.status === 200) {
                        result = JSON.parse(this.responseText);
                    }
                }
                myRequest.send();
                return result;
            }

            function displayProducts(object) {
                let product_card = document.createElement('div');
                product_card.className = "product-item";
                product_card.id = Number(object['reference']);
                product_card.innerHTML = `
                <img src="${object['img']}" alt='Product'>
                <h5>${object['etiquette']}</h5>
                <p>${object['prixAchat']}</p>
                <p>${object['prixFinal']}</p>
                <p class='qntMin'>Quantity minimale: ${object['qntMin']}</p>
                <p class='qntStc'>Quantity en Stock: ${object['qntStock']}</p>
                <p>Categorie: ${object['catg']}</p>
            `;
                // product_card.style.display = 'none';
                document.querySelector('.product-menu').appendChild(product_card);
            }
            let categories = getData('categories');
            let products = getData('products');

            /* Debut Filter */

            let filterOfPro = document.getElementById('filter');

            for (let i = 0; i < categories.length; i++) {
                filterOfPro.innerHTML += `
                <option>${categories[i]['name']}</option>
            `;
                if (i === categories.length - 1) {
                    filterOfPro.innerHTML += `
                <option value=${1}>produits en rupture de stock</option>
            `;
                }
            }

            filterOfPro.addEventListener('change', function() {
                document.querySelector('.product-menu').innerHTML = '';

                for (let i = 0; i < products.length; i++) {

                    if (products[i]['catg'] === filterOfPro.value) {
                        displayProducts(products[i]);
                    }
                }
            });
            /* Fin Filter */


            /* Debut Pagination */
            let itemsPerPage = 4;
            let nbrOfPages = Math.ceil(products.length / itemsPerPage);
            let pagination = document.getElementById('pagination');
            for (let i = 0; i < nbrOfPages; i++) {
                const listNbr = document.createElement('li');
                listNbr.className = 'listPagination';
                listNbr.innerText = i + 1;
                pagination.appendChild(listNbr);
            }

            for (let i = 0; i < itemsPerPage; i++) {
                displayProducts(products[i]);
            }

            let allListNbr = document.querySelectorAll('.listPagination');


            allListNbr.forEach(function(list) {
                list.addEventListener('click', function() {
                    document.querySelector('.product-menu').innerHTML = '';
                    let nbr = Number(list.textContent);
                    for (let i = (nbr - 1) * itemsPerPage; i < (nbr - 1) * itemsPerPage + itemsPerPage; i++) {
                        displayProducts(products[i]);
                    }
                });
            });

            document.body.appendChild(pagination);



            /* Fin Pagination */
        </script>
    </body>

    </html>

<?php } else {
    header("Location: index.php");
    exit;
} ?>
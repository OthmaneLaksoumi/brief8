<?php
session_start();
require_once("../classes/DAOusers.php");

$DAOuser = new DAOuser();



$users = $DAOuser->get_users(1, 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = $_POST["toAdmin"];

    foreach( $users as $user ) {
        if($user->getUsername() == $username) {
            $DAOuser->change_role($user);
        }
    }
    header("Refresh: 1; url=toAdmin.php");
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
        <!-- </div> -->
        <!-- </div> -->



        <div class="col-md-10">
            <h1>Valider un utilisateur</h1>
            <?php if (count($users) > 0) { ?>
                <form action="" method="post" class="container">
                    <div class="mb-3">
                        <label for="catg" class="form-label text-success fw-bold">Choisir un utilisateur</label>
                        <select name="toAdmin" id="" class="form-control">
                            <?php
                            foreach ($users as $user) {
                                echo "<option>" . $user->getUsername() . "</option>";
                            }


                            ?>
                        </select>
                    </div>
                    <input type="submit" class="btn btn-primary m-2" value="Transformer en administrateur">
                </form>
            <?php } else {
                echo "<p class='all-valid'>Tous les utilisateurs sont administrateurs</p>";
            }
            ?>
        </div>
    </section>


</body>

</html>
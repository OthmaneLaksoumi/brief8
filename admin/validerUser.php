<?php
session_start();
require_once("../classes/DAOusers.php");

$DAOuser = new DAOuser();

$users = $DAOuser->get_users(0, 0);


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $noValide = $_POST["novlaid"];
    if (isset($_POST["valide"]) && $_POST["valide"] === "Valider") {

        foreach ($users as $user) {
            if ($user->getUsername() == $noValide) {
                $DAOuser->change_state($user);
                break;
            }
        }
        header("Refresh: 1; url=validerUser.php");
        exit;
    }
    if (isset($_POST["remove"]) && $_POST["remove"] === "Supprimer") {

        foreach ($users as $user) {
            if ($user->getUsername() == $noValide) {
                $DAOuser->delete_user($user);
                break;
            }
        }        header("Refresh: 1; url=validerUser.php");
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

        <div class="col-md-10">
            <h1>Valider un utilisateur</h1>
            <?php if (count($users) > 0) { ?>
                <form action="" method="post" class="container">
                    <div class="mb-3">
                        <label for="catg" class="form-label text-danger fw-bold">List des utilisateurs non valides</label>
                        <select name="novlaid" id="" class="form-control">
                            <?php
                            foreach ($users as $user) {
                                echo "<option>" . $user->getUsername() . "</option>";
                            }


                            ?>
                        </select>
                    </div>



                    <div class="d-flex justify-content-center">
                        <input type="submit" name="valide" class="btn btn-primary  m-2" value="Valider">
                        <input type="submit" name="remove" class="btn btn-primary m-2" value="Supprimer">
                    </div>
                </form>
            <?php } else {
                echo "<p class='all-valid'>Tout utilisateur est valider</p>";
            }
            ?>
        </div>
    </section>


</body>

</html>
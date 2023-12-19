<?php
session_start();
require_once("../classes/DAOusers.php");

$DAOusers = new DAOuser();

$users = array_merge($DAOusers->get_users(0, 0), $DAOusers->get_users(1, 0), $DAOusers->get_users(1, 1));
$result = count($users);
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
            <h1>Liste des utilisateurs
                <?php echo "(" . $result . " utilisateurs)"?>
            </h1>
            <table>
                <tr>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Statue</th>
                    <th>Role</th>
                </tr>

                <?php
                foreach ($users as $user) {
                    echo "<tr>";
                    echo "<td>" . $user->getEmail() . "</td>";
                    echo "<td>" . $user->getUsername() . "</td>";
                    echo "<td>" . ($user->getUsername() === 1 ? "Valider" : "Non Valider") . "</td>";
                    echo ($user->getRole() === 1 ? "<td class='admin'> Administrateur" : ($user->getState() === 0 ? "<td class='bg-danger text-white'> Non Valider" : "<td class='normal'> Utilisateur normal")) . "</td>";
                    echo "</tr>";
                }

                ?>

            </table>
        </div>
    </section>

</body>

</html>
<?php
session_start();
include_once('databaseInfo.php');
// echo "UserID = ".$_SESSION['UserID'];

// IF logout button is clicked log out
if (isset($_POST['btn_logout'])) {
    session_destroy();
    header("Location: http://localhost/EcomFinalProject/index.php?page=login");
    exit();
}

if (isset($_POST['btn_edit'])) {
    // header("Location: http://localhost/EcomFinalProject/index.php?page=login");
    // exit();
}

if (isset($_POST['btn_delete'])) {
    // session_destroy();
    // header("Location: http://localhost/EcomFinalProject/index.php?page=login");
    // exit();
}

// Get the user by his/her ID
$pdo = new PDO($dsn, $user, $passwd);
$command = $pdo->query("SELECT * FROM Customer WHERE ID = " . $_SESSION['UserID']);
$user = $command->fetch();
?>

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src='https://kit.fontawesome.com/a076d05399.js'></script>

<style>
    h1 {
        margin-left: 2%;
    }

    #user_info_header {
        position: relative;
        margin: 2% 0% 0% 2%;
        padding: 0;

    }

    .user_info_row {
        font-size: 20px;
    }
</style>

<h1>User Details</h1>
<div id="user_info_header">
    <?php
    echo "<h2>" . $user["First Name"] . " " . $user["Last Name"] . "</h2>";
    echo "<p class=\"user_info_row\"> <i class=\"material-icons\" style=\"font-size:25px\">email</i> " . $user["Email"] . "</p>";
    echo "<p class=\"user_info_row\"> <i class=\"fas fa-phone-alt\" style=\"font-size:25px\"></i> " . $user["Phone"] . "</p>";
    echo "<p class=\"user_info_row\"> <i class=\"fas fa-house-user\" style=\"font-size:25px\"></i> " . $user["Address"] . "</p>";
    ?>
    </br>

    <form action="<?php $_PHP_SELF ?>" method="POST">
        <button href="#" name="btn_edit"> Edit Details</button>
        <button href="#" name="btn_logout"> Log Out </button>
        <button href="#" name="btn_delete"> Delete Profile </button>
    </form>
</div>

<div id="courses_list">
    <?php

    ?>

</div>
<?php
    session_start();
    // echo "UserID = ".$_SESSION['UserID'];

    // IF logout button is clicked log out
    if(isset($_POST['btn_logout'])){
        session_destroy();
        header("Location: http://localhost/EcomFinalProject/index.php?page=login");
        exit();
    }

?>

<h1> THIS IS PROFILE </h1>

<form action="<?php $_PHP_SELF ?>" method="POST">
    <button href="#" name="btn_logout"> Log Out </button>
</form>
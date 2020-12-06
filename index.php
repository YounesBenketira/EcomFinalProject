<?php



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/navbar.css">
    <title>GetEducated</title>
</head>
<body>
    <?php
    // Generate Navbar
    include_once('navbar.php');
    // Determine which body to display to the user
    if(isset($_GET['page'])){
        $page = $_GET['page'];
        switch($page){
            case 'home':
                include_once('Pages/home.php');
                break;
            case 'search':
                include_once('Pages/search.php');
                break;
            case 'help':
                include_once('Pages/help.php');
                break;
            case 'login':
                include_once('Pages/login.php');
                break;
            case 'register':
                include_once('Pages/register.php');
                break;
            default:
                break;
        }
    }
    ?>
</body>
</html>
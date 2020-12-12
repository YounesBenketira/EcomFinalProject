<?php



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="CSS/navbar.css">
    <link rel="stylesheet" href="CSS/home.css">
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
            case 'courses':
                include_once('Pages/courses.php');
                break;
            case 'profile':
                include_once('Pages/Profile Page/profile.php');
                if(isset($_POST['btn_login'])){
                    echo "test ";
                }
                break;
            case 'login':
                include_once('Pages/Profile Page/login.php');
                break;
            case 'register':
                include_once('Pages/Profile Page/register.php');
                break;
            case 'help':
                include_once('Pages/help.php');
                break;
            case 'cart':
                include_once('Pages/cart.php');
                break;
            default:
                
                break;
        }
    }else{
        include_once('Pages/home.php');
    }
    ?>
</body>
</html>
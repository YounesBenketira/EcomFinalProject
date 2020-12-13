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


//Get user's Courses
$course_list = explode(',', $user["Course List"]);
$inQuery = implode(',', array_fill(0, count($course_list), '?'));
$command = $pdo->prepare("SELECT * FROM COURSES WHERE `Course ID` IN (" . $inQuery . ")");
foreach ($course_list as $k => $course_item) {
    $command->bindValue(($k + 1), $course_item);
}
$command->execute();
$rows = $command->fetchAll(PDO::FETCH_NUM);


// foreach ($rows as $row) {
//     echo "$row[0]";
// }
?>

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src='https://kit.fontawesome.com/a076d05399.js'></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<style>
    h1 {
        margin-left: 2%;
    }

    #course_list {
        margin-left: 70px;
        display: inline-block;
    }

    .card {
        position: relative;
        float: left;
        margin: 10px 10px 10px 10px;
    }

    #user_info_header {
        position: relative;
        margin: 2% 0% 0% 2%;
        padding: 0;

    }

    .user_info_row {
        font-size: 20px;
    }

    table {
        margin-top: 50px;
        margin-left: 120px;
    }

    th {
        text-align: center;
    }

    table,
    th,
    td {
        border: 0.5px solid lightgrey;
        border-collapse: collapse;
        padding: 10px 0px 10px 30px;
        font-size: 18px;
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

<table style="width:86%">
    <tr>
        <th>Purchased Courses</th>
    </tr>
    <tr>
        <th>
            <?php
            foreach ($rows as $row) {
                echo "<form method=\"POST\" class=\"card\" style=\"width: 18rem;\">";
                //echo '<div class="card" style="width: 18rem;">';
                echo "<input type = \"hidden\" name = \"id\" value = " . $row["0"] . " />";
                echo '<img class="card-img-top" src="data:image/jpeg;base64,' . base64_encode($row["5"]) . '" alt="Course Image" style="height: 12rem;">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title" name="title">';
                echo $row["1"];
                echo '</h5>';
                echo '<h6 class="card-title">';
                echo "Teacher: " . $row["4"];
                echo '</h5>';
                echo '</div>';
                // echo '</div>';
                echo "</form>";
            }
            ?>
        </th>
    </tr>
</table>
<br>
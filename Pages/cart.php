<?php
include_once('databaseInfo.php');
session_start();
$subtotal = 0;

if (isset($_SESSION['UserID'])) {
    $pdo = new PDO($dsn, $user, $passwd);

    // Get user's cart
    $command = $pdo->prepare("SELECT Cart FROM Customer WHERE ID =" . $_SESSION['UserID']);
    $command->execute();
    $cart = $command->fetchColumn();

    // echo $cart."</br>";

    $cart_list = explode(',', $cart); // Convert cart string into an Array
    // Modified query to support array
    $inQuery = implode(',', array_fill(0, count($cart_list), '?'));
    $command = $pdo->prepare("SELECT * FROM COURSES WHERE `Course ID` IN (" . $inQuery . ")");
    foreach ($cart_list as $k => $cart_item) {
        $command->bindValue(($k + 1), $cart_item);
    }
    $command->execute();
    $rows = $command->fetchAll(PDO::FETCH_NUM);

    foreach ($rows as $row) {
        $subtotal = $subtotal + floatval($row[3]);
    }
} else {
    header("Location: http://localhost/EcomFinalProject/index.php?page=login");
    exit();
}

if (isset($_POST['btn_remove'])) {
    // Get user's cart
    $command = $pdo->prepare("SELECT Cart FROM Customer WHERE ID =" . $_SESSION['UserID']);
    $command->execute();
    $cart = $command->fetchColumn();

    // Remove the given id from the cart
    $cart = str_replace($_POST["id"] . ", ", "", $cart); // if its followed by ,
    $cart = str_replace($_POST["id"], "", $cart); // if its not followed by it

    // Update the User's Cart in Database
    $sql = "UPDATE Customer SET cart=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$cart, $_SESSION['UserID']]);

    // Remove the item from the rows variable
    for ($i = 0; $i < count($rows); $i++) {
        $row = $rows[$i];
        if ($row['0'] == $_POST["id"]) {
            unset($rows[$i]);
        }
    }
}

if (isset($_POST['btn_purchase'])) {
    // Get user's Course List
    $command = $pdo->prepare("SELECT `Course List` FROM Customer WHERE ID =" . $_SESSION['UserID']);
    $command->execute();
    $userCourseList = $command->fetchColumn();

    // Get user's cart
    $command = $pdo->prepare("SELECT Cart FROM Customer WHERE ID =" . $_SESSION['UserID']);
    $command->execute();
    $cart = $command->fetchColumn();

    if (strlen($userCourseList) > 0) {
        $userCourseList = $userCourseList . ', ' . $cart;
    } else {
        $userCourseList = $cart;
    }
    $cart = "";

    // echo "COURSE LIST = ". $userCourseList;
    // echo "<br>";
    // echo 'CART = '.$cart;
    // echo "<br>";

    // Update the User's Cart & Course List in Database
    $sql = "UPDATE Customer SET `Course List`=? , Cart = ? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userCourseList, $cart, $_SESSION['UserID']]);

    header("Location: http://localhost/EcomFinalProject/index.php?page=profile");
    exit();
}
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<style>
    h1 {
        margin-top: 35px;
        text-align: center;
    }

    #course_list {
        margin-left: 70px;
        display: inline-block;
    }

    .card {
        display: inline-block;
        position: relative;
        margin-left: 50px;
        margin-top: 40px;
    }

    table {
        margin-left: 120px;
        width: 86%;
    }

    table,
    th,
    td {
        border: 0.5px solid lightgrey;
        border-collapse: collapse;
        padding: 10px 0px 10px 30px;
        font-size: 18px;
    }

    #emptyDiv {
        width: 1650px;
        height: 500px;
        border: 2px solid grey;
        background-color: lightgray;
        margin-top: 20px;
        margin-left: 50px;
        text-align: center;
        padding-top: 200px;
    }
</style>

<h1>Cart</h1>

<table>
    <tr>
        <th>Subtotal</th>
        <th><?php echo '<p class="card-text" style="color:red;text-align: right;margin-right:200px;">$' . $subtotal . "</p>"; ?></th>
    </tr>
</table>
<br>

<form action="<?php $_PHP_SELF ?>" method="POST">
    <button class="btn btn-primary" name="btn_purchase" style="float: right; margin-right: 150px;">Purchase</button>
</form>

<br>
<div id="course_list">
    <?php
    if (count($rows) > 0) {
        foreach ($rows as $row) {
            echo "<form method=\"POST\" class=\"card\" style=\"width: 18rem;\">";
            // echo '<div class="card" style="width: 18rem;">';
            echo "<input type = \"hidden\" name = \"id\" value = " . $row["0"] . " />";
            echo '<img class="card-img-top" src="data:image/jpeg;base64,' . base64_encode($row["5"]) . '" alt="Course Image" style="height: 12rem;">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title" name="title">';
            echo $row["1"];
            echo '</h5>';
            echo '<h6 class="card-title">';
            echo "Teacher: " . $row["4"];
            echo '</h5>';
            echo '<p class="card-text" style="height: 10rem">';
            echo $row["2"];
            echo '</p>';
            echo '<p class="card-text" style="color:red;">$';
            echo $row["3"];
            echo '</p>';
            echo '<button class="btn btn-primary" name="btn_remove">Remove</button>';
            echo '</div>';
            // echo '</div>';
            echo "</form>";
        }
    } else {
        echo "<div id='emptyDiv'>";
        echo "<h3>Your Cart is Empty!</h3>";
        echo "</div>";
    }


    ?>
</div>
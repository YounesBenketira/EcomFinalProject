<?php
include_once('databaseInfo.php');
$pdo = new PDO($dsn, $user, $passwd);


// Pagination Section
$countsql = $pdo->prepare("SELECT COUNT(`Course ID`) FROM COURSES");
$countsql->execute();
$row = $countsql->fetch();

$num_per_page = 5;
$num_records = $row[0];
$num_links = ceil($num_records / $num_per_page);

$page;
if (isset($_GET['index'])){
    $page = $_GET['index'];
}else{
    $page = 0;
}

$start = $page * $num_per_page;

// echo "Number per page: ". $num_per_page;
// echo "<br>";
// echo "Number of records: ". $num_records;
// echo "<br>";
// echo "Number of links: ". $num_links;
// echo "<br>";
// Pagination over

$command = $pdo->query("SELECT * FROM COURSES LIMIT $start, $num_per_page");
$rows = $command->fetchAll(PDO::FETCH_NUM);


if (isset($_POST['btn_search'])) {
    $search_text = $_POST['search'];
    $command = $pdo->query("SELECT * FROM COURSES WHERE 
    Name LIKE '%" . $search_text . "%' OR
    Description LIKE '%" . $search_text . "%' OR
    Teacher LIKE '%" . $search_text . "%'");
    $rows = $command->fetchAll(PDO::FETCH_NUM);
}


if (isset($_POST['btn_cart'])) {
    session_start();
    if (isset($_SESSION['UserID'])) {
        // Get user's Course List
        $command = $pdo->prepare("SELECT `Course List` FROM Customer WHERE ID =" . $_SESSION['UserID']);
        $command->execute();
        $userCourseList = $command->fetchColumn();

        // Retrieve the user's cart
        $command = $pdo->prepare("SELECT Cart FROM Customer WHERE ID =" . $_SESSION['UserID']);
        $command->execute();
        $cart = $command->fetchColumn();

        $isInCart = strpos($cart, $_POST["id"]) !== false;
        $isInCourses = strpos($userCourseList, $_POST["id"]) !== false;
        // Update cart with new course only if it's not in the cart AND not in the users purchased courses already
        if ($isInCart) {
            echo "This Course is already in your cart!";
        } else if ($isInCourses) {
            echo "This Course has already been purchased!";
        } else {
            if (strlen($cart) > 0) {
                $cart = $cart . ', ' . $_POST["id"];
            } else {
                $cart = $_POST["id"];
            }

            //Update the User's Cart in Database
            $sql = "UPDATE Customer SET cart=? WHERE id=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$cart, $_SESSION['UserID']]);

            header("Location: http://localhost/EcomFinalProject/index.php?page=cart");
            exit();
        }
    }else{
        echo "Must be logged in to purchase!!";
    }
}

if (isset($_POST['btn_edit'])) {
    session_start();
    if (isset($_SESSION['UserID'])) {
        header("Location: http://localhost/EcomFinalProject/index.php?page=edit_course&id=".$_POST["id"]);
        exit();
    }else{
        echo "Must be logged in to edit!";
        
    }
}

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<style>
    h1 {
        margin-top: 40px;
        text-align: center;
    }

    #course_list {
        margin-left: 70px;
        margin-bottom: 50px;
    }

    .card {
        display: inline-block;
        margin-left: 50px;
        margin-top: 50px;
    }

    * {
        box-sizing: border-box;
    }

    .example {
        margin: 30px 150px 0 150px;
    }

    form.example input[type=text] {
        padding: 10px;
        font-size: 17px;
        border: 1px solid grey;
        float: left;
        width: 80%;

    }

    form.example button {
        float: left;
        width: 20%;
        padding: 10px;
        background: #2196F3;
        color: white;
        font-size: 17px;
        border: 1px solid grey;
        border-left: none;
        cursor: pointer;
    }

    form.example button:hover {
        background: #0b7dda;
    }

    form.example::after {
        content: "";
        clear: both;
        display: table;
    }

    .edit_btn {
        background-color: grey;
        border-color: grey;
    }

    .edit_btn button:hover {
        background-color: lightgray;
        border-color: grey;
    }

    #page_links{
        text-align: center;
        margin-top: 20px;
        font-size: 25px;
    }
</style>

<h1>Course Catalog</h1>

<form class="example" action="<?php $_PHP_SELF ?>" method="POST">
    <input type="text" placeholder="Search.." name="search">
    <button type="submit" name="btn_search"><i class="fa fa-search"></i></button>
</form>

<div id="course_list">
    <!-- <form action="<?php $_PHP_SELF ?>" method="POST"> -->
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
        echo '<p class="card-text" style="height: 10rem">';
        echo $row["2"];
        echo '</p>';
        echo '<p class="card-text" style="color:red;">$';
        echo $row["3"];
        echo '</p>';
        echo '<button class="btn btn-primary" name="btn_cart">Add To Cart</button>';
        echo '        <button  class="btn btn-primary edit_btn" name="btn_edit">Edit</button>';
        echo '</div>';
        // echo '</div>';
        echo "</form>";
    }
    echo "<br>";
    echo '<div id="page_links">';
    for($i = 0; $i<$num_links; $i++){
        echo '<a href="index.php?page=courses&index='.$i.'">'.($i+1).' </a>';
    }
    echo '</div>';
    ?>
    <!-- </form> -->
</div>
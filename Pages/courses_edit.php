<?php
include_once('databaseInfo.php');
$pdo = new PDO($dsn, $user, $passwd);
if (isset($_GET['id'])) {
    $command = $pdo->query("SELECT * FROM Courses WHERE `Course ID` = " . $_GET['id']);
    $course = $command->fetch();
}

if (isset($_POST['change_btn'])) {
    $new_teacher = $_POST['teacher'];
    $new_title = $_POST['title'];
    $new_desc = $_POST['desc'];
    $new_price = $_POST['price'];

    $sql = "UPDATE Courses SET Name=?, Description=?, Price=?, Teacher=? WHERE `Course ID`=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$new_title, $new_desc, $new_price, $new_teacher, $_GET['id']]);

    header("Location: http://localhost/EcomFinalProject/index.php?page=courses");
    exit();

} else if (isset($_POST['cancel_btn'])) {
    header("Location: http://localhost/EcomFinalProject/index.php?page=courses");
    exit();
}


?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<style>
    h1,
    h3 {
        margin-left: 100px;
        margin-bottom: 20px;
    }

    #form_div {
        margin-left: 100px;
        margin-right: 1200px;
    }

    #desc {
        height: 200px;
    }
</style>

<h1>Edit Course</h1>

<div id="form_div">
    <form method="POST">
        <div class="form-group">
            <label for="teacher">Teacher:</label>
            <input required="required" type="text" class="form-control" name="teacher" placeholder=<?php echo $course[4]; ?>>
        </div>
        <div class="form-group">
            <label for="title">Title:</label>
            <input required="required" type="text" class="form-control" name="title" placeholder=<?php echo $course[1]; ?>>
        </div>
        <div class="form-group">
            <label for="desc">Description:</label>
            <textarea required="required" type="text" class="form-control" name="desc" placeholder=<?php echo $course[2]; ?>> </textarea>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input required="required" type="number" step="0.01" class="form-control" name="price" placeholder=<?php echo $course[3]; ?>>
        </div>
        <button type="submit" class="btn btn-default" name="cancel_btn" formnovalidate>Cancel</button>
        <button type="submit" class="btn btn-default" name="change_btn">Make changes</button>
    </form>
</div>
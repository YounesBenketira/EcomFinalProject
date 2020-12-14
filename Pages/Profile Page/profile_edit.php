<?php
session_start();
include_once('databaseInfo.php');
$pdo = new PDO($dsn, $user, $passwd);
$command = $pdo->query("SELECT * FROM Customer WHERE ID = " . $_SESSION['UserID']);
$user = $command->fetch();

if (isset($_POST['change_btn'])) {
    $new_fname = $_POST['fname'];
    $new_lname = $_POST['lname'];
    $new_email = $_POST['email'];
    $new_address = $_POST['address'];
    $new_phone = $_POST['phone'];

    $sql = "UPDATE Customer SET `First Name`=?, `Last Name`=?, `Email`=?, Address=?, Phone=? WHERE `ID`= ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$new_fname, $new_lname, $new_email, $new_address, $new_phone, $_SESSION['UserID']]);

    header("Location: http://localhost/EcomFinalProject/index.php?page=profile");
    exit();

} else if (isset($_POST['cancel_btn'])) {
    header("Location: http://localhost/EcomFinalProject/index.php?page=profile");
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

<h1>Edit Profile</h1>

<div id="form_div">
    <form method="POST">
        <div class="form-group">
            <label for="fname">First Name:</label>
            <input required="required" type="text" class="form-control" name="fname" placeholder=<?php echo $user[1]; ?>>
        </div>
        <div class="form-group">
            <label for="lname">Last Name:</label>
            <input required="required" type="text" class="form-control" name="lname" placeholder=<?php echo $user[2]; ?>>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input required="required" type="email" class="form-control" name="email" placeholder=<?php echo $user[3]; ?>>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <input required="required" type="text" class="form-control" name="address" placeholder=<?php echo $user[4]; ?>>
        </div>
        <div class="form-group">
            <label for="phone">Phone Number:</label>
            <input required="required" type="text" class="form-control" name="phone" placeholder=<?php echo $user[5]; ?>>
        </div>
        <button type="submit" class="btn btn-default" name="cancel_btn" formnovalidate>Cancel</button>
        <button type="submit" class="btn btn-default" name="change_btn">Make changes</button>
    </form>
</div>
<?php
    include_once('databaseInfo.php');
    
    if(isset($_POST['btn_create'])){
        $pdo = new PDO($dsn, $user, $passwd);
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $username = $_POST['user'];
        $password = $_POST['pass'];

        $command = $pdo->query("INSERT INTO CUSTOMER (`First Name`, `Last Name`, `Email`, `Phone`, `Address`, `Username`, `Password`) VALUES ('$fname', '$lname', '$email', '$phone', '$address', '$username', '$password')");

        // if($command){
        //     echo "Inserted! ROWS = ".$command->rowCount();
        // }else{
        //     echo "Failed!";
        //     die(var_export($pdo->errorinfo(), TRUE));
        // }

        // If user is found LOGIN
        header("Location: http://localhost/EcomFinalProject/index.php?page=login");
        exit();
    }
    
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.login-form {
    width: 340px;
    margin: 50px auto;
  	font-size: 15px;
}
.login-form form {
    margin-bottom: 15px;
    background: #f7f7f7;
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    padding: 30px;
}
.login-form h2 {
    margin: 0 0 15px;
}
.form-control, .btn {
    min-height: 38px;
    border-radius: 2px;
}
.btn {        
    font-size: 15px;
    font-weight: bold;
}
</style>

<div class="login-form">
    <form action="<?php $_PHP_SELF ?>" method="POST">
        <h2 class="text-center">Create An Account</h2>     
        <div class="form-group">
            <input type="text" class="form-control" placeholder="First Name" required="required" name="fname">
        </div>  
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Last Name" required="required" name="lname">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Email" required="required" name="email">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Phone" required="required" name="phone">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Address" required="required" name="address">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Username" required="required" name="user">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Password" required="required" name="pass">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block" name="btn_create">Create</button>
        </div>  
    </form>
    <p class="text-center"><a href="index.php?page=login">Already have an account? Log in</a></p>
</div>
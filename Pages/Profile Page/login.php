<?php
    include_once('databaseInfo.php');
    session_start();

    if(isset($_SESSION['UserID'])){
        header("Location: http://localhost/EcomFinalProject/index.php?page=profile");
        exit();
    } 
    
    if(isset($_POST['btn_login'])){
        $pdo = new PDO($dsn, $user, $passwd);
        $username = $_POST['user'];
        $password = $_POST['pass'];

        

        $command = $pdo->prepare("SELECT * FROM CUSTOMER WHERE Username = ? AND Password = ?");
        $command->bindValue(1, $username);
        $command->bindValue(2, $password);
        $command->execute();

        $row = $command->fetch();
        
        // If user is found LOGIN
        if($row){
            $_SESSION['UserID'] = $row['ID'];
            header("Location: http://localhost/EcomFinalProject/index.php?page=profile");
            exit();
        }else {
            echo "USER AND PASS DOES NOT EXIST";
        }
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
        <h2 class="text-center">Log in</h2>       
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Username" required="required" name="user">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Password" required="required" name="pass">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block" name="btn_login">Log in</button>
        </div>  
    </form>
    <p class="text-center"><a href="index.php?page=register">Create an Account</a></p>
</div>
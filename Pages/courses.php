<?php
    include_once('databaseInfo.php');
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<div>
    <?php
        $pdo = new PDO($dsn, $user, $passwd);

        $command = $pdo->query("SELECT * FROM COURSES");
        $rows = $command->fetchAll(PDO::FETCH_NUM);

        foreach($rows as $row){
            echo '<div class="card" style="width: 18rem;">';
            echo '<img class="card-img-top" src="data:image/jpeg;base64,'.base64_encode( $row["5"] ).'" alt="Course Image">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">'; echo $row["1"]; echo '</h5>';
            echo '<p class="card-text">'; echo $row["2"]; echo '</p>';
            echo '<p class="card-text" style="color:red;">$'; echo $row["3"]; echo '</p>';
            echo '<a href="#" class="btn btn-primary">Add To Cart</a>';
            echo '</div>';
            echo '</div>';
        }
    ?>
</div>
<?php
    include_once('databaseInfo.php');

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass);
    if(!$conn){
        die('could not connect: '.mysqli_error());
    }
    
    mysqli_select_db($conn, "geteducated");
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <div>

    <?php
        $result = mysqli_query($conn, "SELECT * FROM courses") or die(mysqli_error($conn));
        while($row = mysqli_fetch_array($result)){
            echo '<div class="card" style="width: 18rem;">';
            echo '<img class="card-img-top" src="data:image/jpeg;base64,'.base64_encode( $row["Image"] ).'" alt="Course Image">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">'; echo $row["Name"]; echo '</h5>';
            echo '<p class="card-text">'; echo $row["Description"]; echo '</p>';
            echo '<p class="card-text" style="color:red;">$'; echo $row["Price"]; echo '</p>';
            echo '<a href="#" class="btn btn-primary">Add To Cart</a>';
            echo '</div>';
            echo '</div>';
        }
    ?>

    </div>
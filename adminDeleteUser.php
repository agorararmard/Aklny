<?php
    session_start(); 
    $conn = mysqli_connect("localhost", "root", "", "db_proj"); 
    if(isset($_POST["acart"]))
	{
        $username = $_POST["deleted"];
        $deletequery = "UPDATE `usr` SET Deleted = 1 WHERE username = '".$username."'";
        if( mysqli_query($conn,$deletequery))
        { 
            
        $query1 = "INSERT INTO `delete_usr` (`adminId`, `userId`, `date_deleted`) VALUES ('".$_SESSION['login_user']."', '".$username."', curdate())";
        if( mysqli_query($conn,$query1))
        {
            header("location: adminDeleteUser.php");
        
        }
        else
        {
          header("location: Home.php"); 
        }    
    
        }
        else
        {
                    header("location: Home.php"); 
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

<link rel="icon" type="image/png" href="img/logo1.png"/>  <!--for icon-->

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>List Of Addresses</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
	<link href="style.css" rel="stylesheet">
</head>
<body>


<?php include "AdminNavHead.php";?>

<div class="container-fluid padding">
	<div class="row welcome text-center">
		<div class="col-12">
			<h1 class="display-4">Delete Users</h1>
		</div>
		<hr>
	</div>
</div>

<form class="" method="post" action="">
	<div class="justify-content-between align-items-center">


	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
		<p class="lead">Input Username:</p>
	</div>

	<div class="input-group mb-3">
	  <input type="text" class="form-control" placeholder="username" aria-label="Search1" aria-describedby="basic-addon2" name="deleted" id = "deleted">
	</div>

	<div class="form-group container-login100-form-btn m-t-32 col">
		<input  name="acart"  type = "submit" class="login100-form-btn" value = "Delete User">
	</div>

	</div>
</form>

</body>
</html>
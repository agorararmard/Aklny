<?php
    session_start(); 
    $conn = mysqli_connect("localhost", "root", "", "db_proj"); 
    if(isset($_POST["acart"]))
	{
        
        $username = $_POST["user"];
        $password = $_POST["pass"];
        $userinfoquery3 = "SELECT * from `usr` where username = '".$username."' LIMIT 1"; 
        $ses_sql = mysqli_query($conn, $userinfoquery3); 
        
        $userinfoArr;
        while($row = mysqli_fetch_assoc($ses_sql)) 	
        {
            $userinfoArr=$row;
        }
        if(!is_null($userinfoArr))
        {
            $passquery = "UPDATE `usr` SET password = '".$password."' WHERE username = '".$username."'";
            if( mysqli_query($conn,$passquery))
            { 
                if($userinfoArr["Deleted"] == 0)
                {
                    $orId = ((string)mt_rand());
                    $orId  .= ((string)mt_rand());
                    $orId  .= ((string)mt_rand());
                    $orId  .= ((string)mt_rand());
                    $orId  .= ((string)mt_rand());    
                    $query1 = "INSERT INTO `change_password` (`adminId`, `userId`,`cpId`, `date_changed`, `old_pass`) VALUES ('".$_SESSION['login_user']."', '".$username."', '".$orId."',curdate(),'".$userinfoArr["password"]."')";
                    if( mysqli_query($conn,$query1))
                    {
                        header("location: adminChangePassword.php");      
                    }
                    else
                    {
                        header("location: Home.php"); 
                    }    
                }
            }
            else
            {
                        header("location: Home.php"); 
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

<link rel="icon" type="image/png" href="img/logo1.png"/>  <!--for icon-->

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Change Password</title>
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
	  <input type="text" class="form-control" placeholder="username" aria-label="Search1" aria-describedby="basic-addon2" name="user" id = "user">
	</div>

	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
		<p class="lead">Input New Password:</p>
	</div>

	<div class="input-group mb-3">
	  <input type="text" class="form-control" placeholder="Password" name="pass" id = "pass">
	</div>

	<div class="form-group container-login100-form-btn m-t-32 col">
		<input  name="acart"  type = "submit" class="login100-form-btn" value = "Update Password">
	</div>

	</div>
</form>

</body>
</html>
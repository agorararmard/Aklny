<?php
//session_start(); // Starting Session 
$error = ''; // Variable To Store Error Message 
$conn = mysqli_connect("localhost", "root", "", "db_proj"); 
session_start();// Starting Session 
// Storing Session 
$user_check = $_SESSION['login_user']; 
// SQL Query To Fetch Complete Information Of User 
$query = "SELECT * from usr where username = '$user_check'"; 
$ses_sql = mysqli_query($conn, $query); 
$row = mysqli_fetch_assoc($ses_sql); 
$login_session = $row['username'];
$login_password = $row['password'];

if (isset($_POST['submit'])) { 
    if (empty($_POST['npassword']) || empty($_POST['password'])) { 
      $error = "Username or Password is invalid"; 
    } 
    else{ 
      // Define $username and $password 
      $npassword = $_POST['npassword']; 
      $password = $_POST['password']; 
      // mysqli_connect() function opens a new connection to the MySQL server. 
      if($login_password != $password)
      {
        header("location: changePassword.php");
      }
      else{
        $query = "UPDATE usr SET password = '".$npassword."' WHERE username = '".$login_session."'";
        // To protect MySQL injection for Security purpose 
        $ses_sql = mysqli_query($conn, $query); 
        header("location: profile.php"); // Redirecting To Profile Page 
    } 
    mysqli_close($conn); // Closing Connection 
    }  
} 
?> 

<!DOCTYPE html>
<html lang="en">


<head>
  <title>Change Password Page</title>
  <link href="style.css" rel="stylesheet" type="text/css">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	
  <link rel="icon" type="image/png" href="img/logo1.png"/>  <!--for icon-->
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="loginvendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="loginfonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="loginfonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="loginvendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="loginvendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="loginvendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="loginvendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="loginvendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="logincss/util.css">
	<link rel="stylesheet" type="text/css" href="logincss/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('img/loginbg.jpg');">
			<div class="wrap-login100 p-t-30 p-b-50">
				<span class="login100-form-title p-b-41">
					Change Password
				</span>
				<form class="login100-form validate-form p-b-33 p-t-5" method="post" action="">


                    <div class="wrap-input100 validate-input" data-validate="Enter New Password">
						<input class="input100" type="password" id= "npassword" name="npassword" placeholder="New Password">
						<span class="focus-input100" data-placeholder="&#xe80f;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter Password">
						<input class="input100" type="password" id= "password" name="password" placeholder="Old Password">
						<span class="focus-input100" data-placeholder="&#xe80f;"></span>
					</div>

					<div class="container-login100-form-btn m-t-32">
						<input  name="submit"  type = "submit" class="login100-form-btn" value = "Confirm Change">
          </div>
          

          <span><?php echo $error; ?></span>
					
      </div>
      
    </div>
    
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="loginvendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="loginvendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="loginvendor/bootstrap/js/popper.js"></script>
	<script src="loginvendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="loginvendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="loginvendor/daterangepicker/moment.min.js"></script>
	<script src="loginvendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="loginvendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="loginjs/main.js"></script>

</body>
</html>
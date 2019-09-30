<?php

$conn = mysqli_connect("localhost", "root", "", "db_proj"); 
session_start();// Starting Session 
// Storing Session 
$user_check = $_SESSION['login_user']; 
// SQL Query To Fetch Complete Information Of User 
$query = "SELECT * from usr where username = '$user_check'"; 
//$pre_query = mysqli_real_escape_string($conn,$query);
$ses_sql = mysqli_query($conn, $query); 
$row = mysqli_fetch_assoc($ses_sql); 
$login_session = $row['username'];

if (isset($_POST['submit'])) { 
    if(empty($_POST['password']))
    {
        header("location: EditUserInfo.php");
    }
    else if($_POST['password'] != $row['password'])
    {
        header("location: EditUserInfo.php");
    }
    else{
        
        if (empty($_POST['fn'])) { 
            $fn = $row['fn']; 
        }
        else{
            $fn = $_POST['fn']; 
        }

        if(empty($_POST['ln'])){
            $ln = $row['ln'];
        }
        else{
            $ln = $_POST['ln'];
        }
        if(empty($_POST['email'])){
            $email = $row['email'];
        }
        else{
            $email = $_POST['email'];
        }
        
        if(empty($_POST['bdate'])){
            $bdate = $row['bdate'];
        }
        else
        {
            $bdate = $_POST['bdate'];
       
        }

        if(empty($_POST['mnumber'])){
            $mnumber = $row['mnumber'];
        }
        else{
            $mnumber = $_POST['mnumber'];
        }
         
        $query = "UPDATE usr SET FName = '".$fn."', LName = '".$ln."', Email = '".$email."', Bdate = '".$bdate."', Mnumber= '".$mnumber."' WHERE username = '".$login_session."'";
        // To protect MySQL injection for Security purpose 
        $ses_sql = mysqli_query($conn, $query); 
        header("location: profile.php"); // Redirecting To Profile Page 
         
        mysqli_close($conn); // Closing Connection 
        
    }  
}




?> 

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Register</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="img/logo1.png"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body style="background-color: #999999;">

<?php include "navHead.php";?>

	<div class="limiter">
		<div class="container-login100">
			<div class="login100-more" style="background-image: url('img/bg-01.jpg');"></div>

			<div class="wrap-login100 p-l-50 p-r-50 p-t-72 p-b-50">
				<form class="login100-form validate-form" method="post" action="">
					<span class="login100-form-title p-b-59">
						Edit User Info
					</span>

					<div class="wrap-input100 ">
						<span class="label-input100">First Name</span>
						<input class="input100" type="text" id="fn" name="fn" placeholder="First Name...">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 ">
						<span class="label-input100">Last Name</span>
						<input class="input100" type="text" id="ln" name="ln" placeholder="Last Name...">
						<span class="focus-input100"></span>
                    </div>
          
					<div class="wrap-input100 ">
						<span class="label-input100">Email</span>
						<input class="input100" type="text"  id="email" name="email" placeholder="Email addess...">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 ">
						<span class="label-input100">Birth Date</span>
						<input class="input100" type="date" id="bdate" name="bdate" placeholder="1-1-2001">
						<span class="focus-input100"></span>
                    </div>
          
					<div class="wrap-input100 ">
						<span class="label-input100">Mobile Number</span>
						<input class="input100" type="text" id="mnumber" name="mnumber" placeholder="01000000000">
						<span class="focus-input100"></span>
					</div>

                    <div class="wrap-input100" >
						<span class="label-input100 validate-input" data-validate = "Password is required">Password</span>
						<input class="input100" type="password" id="password" name="password" placeholder="*************">
						<span class="focus-input100"></span>
                    </div>
                    
					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<input class="login100-form-btn"  name="submit" type="submit" value=" Update ">
						</div>
                    </div>
                    
				</form>
			</div>
		</div>
	</div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>
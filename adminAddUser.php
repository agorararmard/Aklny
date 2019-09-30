<?php
session_start(); // Starting Session 
/* $conn1 = mysqli_connect("localhost", "root", "", "db_proj"); 
// SQL query to fetch information of registerd users and finds user match. 
$query1 = "INSERT INTO usr (username, password, usertype, FName, LName, Email, Bdate, Mnumber, Deleted) VALUES ('aa', 'aa', '0', 'aa', 'aa','a@a.a','1-1-2001','01010','0')";
// To protect MySQL injection for Security purpose 
 if( mysqli_query($conn1,$query1))
  {}
  else{} */
   // $da = 'Hi';
    
$error = ''; // Variable To Store Error Message 
if (isset($_POST['submit'])) {
  $printable = 'Here';
  echo("<script>console.log('PHP: ".$printable."');</script>");


  if (empty($_POST['username']) || empty($_POST['password'])) { 
    $error = "Username or Password is invalid"; 
    echo("<script>console.log('PHP: ".$error."');</script>");

  } 
  else{ 
    // Define $username and $password 
    $username = $_POST['username']; 
    $password = $_POST['password'];
    $fn = $_POST['fn'];
    $ln = $_POST['ln'];
    $email = $_POST['email'];
    $bdate = $_POST['bdate'];
    $mnumber = $_POST['mnumber'];
    $deleted = 0;
    $usertype = $_POST['customRadio']; 
    
    // mysqli_connect() function opens a new connection to the MySQL server. 
    $conn = mysqli_connect("localhost", "root", "", "db_proj"); 
    // SQL query to fetch information of registerd users and finds user match. 
    $query = "INSERT INTO usr (`username`, `password`, `usertype`, `FName`, `LName`, `Email`, `Bdate`,`Mnumber`, `Deleted`) VALUES ('".$username."', '".$password."', '".$usertype."', '".$fn."', '".$ln."','".$email."','".$bdate."','".$mnumber."','".$deleted."')";
    // To protect MySQL injection for Security purpose 
    //echo("<script>console.log('PHP: ".$conn."');</script>");

  //  echo("<script>console.log('PHP: ".$query."');</script>");

    //sleep(10);
    if( mysqli_query($conn,$query))
    { 
     
        $query1 = "INSERT INTO `add_usr` (`adminId`, `userId`, `date_added`) VALUES ('".$_SESSION['login_user']."', '".$username."', curdate())";
        if( mysqli_query($conn,$query1))
        {
            header("location: adminAddUser.php");
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
/*       $stmt = $conn->prepare($query); 
    //$stmt->bind_param("ssisssssi", $username, $password,$usertype,$fn,$ln,$email,$bdate,$mnumber,$deleted); 
    $stmt->execute(); 
    $stmt->bind_result(); 
    $stmt->store_result(); 
    if($stmt->fetch()) //fetching the contents of the row { 
      $_SESSION['login_user'] = $username; // Initializing Session 
    header("location: profile.php"); // Redirecting To Profile Page */ 
  } 
  mysqli_close($conn); // Closing Connection 
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
<?php include "AdminNavHead.php";?>

	<div class="limiter">
		<div class="container-login100">
			<div class="login100-more" style="background-image: url('img/bg-01.jpg');"></div>

			<div class="wrap-login100 p-l-50 p-r-50 p-t-72 p-b-50">
				<form class="login100-form validate-form" method="post" action="">
					<span class="login100-form-title p-b-59">
						Sign Up A New User
					</span>

					<div class="wrap-input100 validate-input" data-validate="Name is required">
						<span class="label-input100">First Name</span>
						<input class="input100" type="text" id="fn" name="fn" placeholder="First Name...">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Name is required">
						<span class="label-input100">Last Name</span>
						<input class="input100" type="text" id="ln" name="ln" placeholder="Last Name...">
						<span class="focus-input100"></span>
          </div>
          
					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<span class="label-input100">Email</span>
						<input class="input100" type="text"  id="email" name="email" placeholder="Email addess...">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Username is required">
						<span class="label-input100">Username</span>
						<input class="input100" type="text" id="username" name="username" placeholder="Username...">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<span class="label-input100">Password</span>
						<input class="input100" type="password" id="password" name="password" placeholder="*************">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Birth Date is required">
						<span class="label-input100">Birth Date</span>
						<input class="input100" type="date" id="bdate" name="bdate" placeholder="2001-01-01">
						<span class="focus-input100"></span>
          </div>
          
					<div class="wrap-input100 validate-input" data-validate="Mobile Number is required">
						<span class="label-input100">Mobile Number</span>
						<input class="input100" type="text" id="mnumber" name="mnumber" placeholder="01000000000">
						<span class="focus-input100"></span>
					</div>


                	<div class="">
                    <span class="label-input100">User Type</span>

		<div class=" form-group custom-control custom-radio col">
			<input type="radio" id="customRadio1" name="customRadio" class="custom-control-input" value = "1" checked>
			<label class="custom-control-label justify-content-between align-items-center" for="customRadio1">Staff User</label>
		</div>
		
		<div class=" form-group custom-control custom-radio col">
			<input type="radio" id="customRadio2" name="customRadio" class="custom-control-input" value = "2">
			<label class="custom-control-label justify-content-between align-items-center" for="customRadio2">Admin User</label>
		</div>
        <span class="focus-input100"></span>
        </div>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<input class="login100-form-btn btn-primary"  name="submit" type="submit" value=" Sign Up ">
								
						
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
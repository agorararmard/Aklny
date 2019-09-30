<?php
include('session.php'); 
if(!isset($_SESSION['login_user'])){ 
  header("location: index.php"); // Redirecting To Home Page 
}
?>
<!DOCTYPE html>
<html>
  
<link rel="icon" type="image/png" href="img/logo1.png"/>  <!--for icon-->

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Profile</title>
 	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
	<link href="style.css" rel="stylesheet">
</head>

<body>

<?php include "navHead.php";?>

 <div id="profile">
    <b id="welcome">Welcome : <i><?php echo $row['FName']; echo " "; echo $row['LName']; ?></i></b>
    <hr>
    <p><b> Username:</b> <?php echo $row['username']; ?></p>
    <br>
    <p><b>Email:</b> <?php echo $row['Email']; ?> </p>
    <br>
    <p><b>Birth Date:</b> <?php echo $row['Bdate']; ?> </p>
    <br>
    <p><b>Mobile Number:</b> <?php echo $row['Mnumber']; ?> </p>
    <div>
    <button type ="button" class="btn btn-primary btn-lg" onclick="location.href='changePassword.php'">Change Password</button>
    </div>
    <br>
    <div>
    <button type ="button" class="btn btn-primary btn-lg" onclick="location.href='EditUserInfo.php'">Edit Profile</button>
    </div>
    <br>
    <div>
    <button type ="button" class="btn btn-primary btn-lg" onclick="location.href='user_address.php'">Your Addresses</button>
    </div>
 </div>
</body>
</html>
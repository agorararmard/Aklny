<?php
include('register2.php'); // Includes Login Script
if(isset($_SESSION['login_user'])){
header("location: profile.php"); // Redirecting To Profile Page
}
?> 
<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
  <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
 <div id="register">
  <h2>Register to Aklny</h2>
  <form action="" method="post">
   <label>UserName :</label>
   <input id="name" name="username" placeholder="username" type="text">
   <label>Password :</label>
   <input id="password" name="password" placeholder="**********" type="password"><br><br>
   
   <label>First Name :</label>
   <input id="fn" name="fn" placeholder="First Name" type="text"><br><br>
   
   <label>Last Name :</label>
   <input id="ln" name="ln" placeholder="Last Name" type="text"><br><br>

   <label>Email :</label>
   <input id="email" name="email" placeholder="***@aklny.com" type="text"><br><br>

   <label>Birth Date :</label>
   <input id="bdate" name="bdate" placeholder="1-1-2000" type="text"><br><br>

   <label>Mobile Number :</label>
   <input id="mnumber" name="mnumber" placeholder="000" type="text"><br><br>

   <input name="submit" type="submit" value=" Register ">
   
   <span><?php echo $error; ?></span>
  </form>
 </div>
</body>
</html>
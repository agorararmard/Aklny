<?php
include('login.php'); // Includes Login Script
if(isset($_SESSION['login_user'])){
header("location: Home.php"); // Redirecting To Profile Page
}
?> 
<!DOCTYPE html>
<html>
<head>
  <title>Login Form in PHP with Session</title>
  <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<style type="text/css">
   body { background: #848ddb !important; } /* Adding !important forces the browser to overwrite the default style applied by Bootstrap */
</style>
 <div id="login">
  <a href="register.php"><img class="login-brand rounded mx-auto d-block"  src ="img/logo1.png"/></a> 

  <h2>Login to Aklny</h2>
  <form action="" method="post">
   <label>UserName :</label>
   <input id="name" name="username" placeholder="username" type="text">
   <label>Password :</label>
   <input id="password" name="password" placeholder="**********" type="password"><br><br>
   <input name="submit" type="submit" class="btn btn-primary btn-lg" value=" Login ">
   
   <input name="submit1" type="submit" class="btn btn-primary btn-lg" value=" Register " href= "register.php">
   
   <span><?php echo $error; ?></span>
  </form>
 </div>
</body>
</html>
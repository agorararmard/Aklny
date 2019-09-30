<?php
session_start(); // Starting Session 
$error = ''; // Variable To Store Error Message 

if (isset($_POST['submit'])) { 
  if (empty($_POST['username']) || empty($_POST['password'])) { 
    $error = "Username or Password is invalid"; 
  } 
  else{ 
    // Define $username and $password 
    $username = $_POST['username']; 
    $password = $_POST['password']; 
    // mysqli_connect() function opens a new connection to the MySQL server. 
    $conn = mysqli_connect("localhost", "root", "", "db_proj"); 
    // SQL query to fetch information of registerd users and finds user match. 
    $query = "SELECT username, password from usr where username=? AND password=? LIMIT 1"; 
    // To protect MySQL injection for Security purpose 
    $stmt = $conn->prepare($query); 
    $stmt->bind_param("ss", $username, $password); 
    $stmt->execute(); 
    $stmt->bind_result($username, $password); 
    $stmt->store_result(); 
    
    //$pre_query = mysqli_real_escape_string($conn,$query);
    if($stmt->fetch()) //fetching the contents of the row { 
      {
        $query2 = "SELECT Deleted from usr where  username = '".$username."' AND password= '".$password."' LIMIT 1"; 
        $ses_sql = mysqli_query($conn, $query2); 
        $row = mysqli_fetch_assoc($ses_sql);
        if($row["Deleted"] == 0)
        {
          $_SESSION['login_user'] = $username; // Initializing Session 
          header("location: profile.php"); // Redirecting To Profile Page 
        }
        else 
         $error = "Username or Password is invalid"; 
      }
   
  } 
  mysqli_close($conn); // Closing Connection 
} 
else if(isset($_POST['submit1']))
{
    header("location: register.php");
}
?>
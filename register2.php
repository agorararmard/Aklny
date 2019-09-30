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

  echo("will start evaluating"); 
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
    $usertype = 0; 
    
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
      $_SESSION['login_user'] = $username;
      header("location: Home.php");
    }
    else
    {
      header("location: index.php"); 
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
<?php

$conn = mysqli_connect("localhost", "root", "", "db_proj"); 

// SQL Query To Fetch Complete Information Of User 
$query = "SELECT DISTINCT city from `restaurant_branch`"; 
//$pre_query = mysqli_real_escape_string($conn,$query);
$ses_sql = mysqli_query($conn, $query); 

$array = [];
while($row = mysqli_fetch_assoc($ses_sql)) 
{
    $array[]=$row;
}


if(isset($_POST["bsearch"]))
{
    $city = $_POST["city"];
    header("location: restaurants.php?city=$city");
}
?>

<!DOCTYPE html>
<html lang="en">

<link rel="icon" type="image/png" href="img/logo1.png"/>  <!--for icon-->

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>List Of Restaurants</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
	<link href="style.css" rel="stylesheet">
</head>
<body>


<?php include "navHead.php";?>

<div class="container-fluid padding">
	<div class="row welcome text-center">
		<div class="col-12">
			<h1 class="display-4">Select Your City and Area</h1>
		</div>
		<hr>
	</div>
</div>

<div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Select City
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
  <?php foreach($array as $subarray): ?>
    <a class="dropdown-item" href="restaurants.php?searchval=x1b2&city=<?php echo $subarray["city"];?>&area=x1b2"> <?php echo $subarray["city"]; ?> </a>
   <?php endforeach; ?>
  </div>
</div>





</body>
</html>
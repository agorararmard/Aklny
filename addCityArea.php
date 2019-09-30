
<?php

session_start(); 
$conn = mysqli_connect("localhost", "root", "", "db_proj"); 
if($_GET)
{
	$cityX = $_GET["city"];
    
    $cityArr = [];
	
    if(	$_GET["city"] != "x1b2v1z4")
	{
		$query1 = "SELECT city from city"; 
		$ses_sql = mysqli_query($conn, $query1); 
	
		while($row = mysqli_fetch_assoc($ses_sql)) 	
		{
			$cityArr[]=$row;
		}
	}
}


if(isset($_POST["acity"]))
{
		$ncity = $_POST["city"];
        $padquery1 = "INSERT INTO `city`(`city`,`deleted`) VALUES ('".$ncity."', 0)";
    
        if( mysqli_query($conn,$padquery1))
        { 
            header("location: addCityArea.php?city=$cityX");
        }
        else
        {
            header("location: Home.php"); 
        }
}


if(isset($_POST["aarea"]))
{
    if($cityX == "x1b2v1z4")
        header("location: addCityArea.php?city=$cityX");
    
		$narea = $_POST["area"];
        $padquery2 = "INSERT INTO `area`(`city`,`area_name`,`deleted`) VALUES ('".$cityX."','".$narea."', 0)";
    
        if( mysqli_query($conn,$padquery2))
        { 
            header("location: addCityArea.php?city=$cityX");
        }
        else
        {
            header("location: Home.php"); 
        }
}

?>

<!DOCTYPE html>
<html lang="en">

<link rel="icon" type="image/png" href="img/logo1.png"/>  <!--for icon-->

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Citys And Areas</title>
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
			<h1 class="display-4">Add New City</h1>
		</div>
		<hr>
	</div>
</div>

                <form class="" method="post" action="">
                	<div class="justify-content-between align-items-center">

                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
                            <p class="lead">City Name:</p>
                        </div>
        
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="city" name="city" id = "city">
                        </div>

                        <div class="form-group container-login100-form-btn m-t-32 col">
                            <input  name="acity"  type = "submit" class="login100-form-btn" value = "Add City">
                        </div>

                	</div>
                </form>




<div class="container-fluid padding">
	<div class="row welcome text-center">
		<div class="col-12">
			<h1 class="display-4">Add New Area</h1>
		</div>
		<hr>
	</div>
</div>

<div class="container-fluid text-center">
<div class="btn-group">
  <button class="btn btn-primary btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<?php if($cityX=="x1b2v1z4"){?>Select City<?php }else{ echo $cityX;}?>
  </button>
  <div class="dropdown-menu">
  <?php foreach($cityArr as $subarray): ?>
    <a class="dropdown-item" href="addCityArea.php?city=<?php echo $subarray["city"];?>"> <?php echo $subarray["city"]; ?> </a>
   <?php endforeach; ?>  </div>
</div>

                <form class="" method="post" action="">
                	<div class="justify-content-between align-items-center">

                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
                            <p class="lead">Area Name:</p>
                        </div>
        
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Area" name="area" id = "area">
                        </div>

                        <div class="form-group container-login100-form-btn m-t-32 col">
                            <input  name="aarea"  type = "submit" class="login100-form-btn" value = "Add Area">
                        </div>

                	</div>
                </form>

</body>
</html>
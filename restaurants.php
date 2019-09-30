
<?php

session_start(); 
$conn = mysqli_connect("localhost", "root", "", "db_proj"); 
if($_GET)
{
	$cityX = $_GET["city"];
	$areaX = $_GET["area"];
	$cuisX = $_GET["cuis"];
	if(	$_GET["city"] != "x1b2v1z4")
	{
		$query1 = "SELECT DISTINCT city from `branch_darea`"; 
		$ses_sql = mysqli_query($conn, $query1); 
	
		$cityArr = [];
		while($row = mysqli_fetch_assoc($ses_sql)) 	
		{
				$cityArr[]=$row;
		}
		
		$query2 = "SELECT DISTINCT city, area_name from `branch_darea` WHERE city = '".$cityX."'"; 
		$ses_sql = mysqli_query($conn, $query2); 
	
		$areaArr = [];
		while($row = mysqli_fetch_assoc($ses_sql)) 	
		{
				$areaArr[]=$row;
		}


		
		$query6 = "SELECT DISTINCT cname from `restaurant_cuisine` rc WHERE EXISTS ( SELECT * from  `restaurant_branch` rb where rc.rId = rb.rId and rb.city = '".$cityX."' and rb.area_name ='".$areaX."')"; 
		$ses_sql = mysqli_query($conn, $query6); 
	
		$cuisArr = [];
		while($row = mysqli_fetch_assoc($ses_sql)) 	
		{
				$cuisArr[]=$row;
		}

	}
	if(	$_GET["city"] == "x1b2v1z4")
	{
		$query1 = "SELECT DISTINCT city from `branch_darea`"; 
		$ses_sql = mysqli_query($conn, $query1); 
	
		$cityArr = [];
		while($row = mysqli_fetch_assoc($ses_sql)) 	
		{
				$cityArr[]=$row;
		}
	}
	else
	if(  $_GET["area"] == "x1b2v1z4")
	{
		$cityX = $_GET["city"];
		$query2 = "SELECT DISTINCT city, area_name from `branch_darea` WHERE city = '".$cityX."'"; 
		$ses_sql = mysqli_query($conn, $query2); 
	
		$areaArr = [];
		while($row = mysqli_fetch_assoc($ses_sql)) 	
		{
				$areaArr[]=$row;
		}
	}
	else if($_GET["cuis"] == "x1b2v1z4")
	{
		$cityX = $_GET["city"];
		$query6 = "SELECT DISTINCT cname from `restaurant_cuisine` rc WHERE EXISTS ( SELECT * from  `branch_darea` rb where rc.rId = rb.rId and rb.city = '".$cityX."' and rb.area_name ='".$areaX."')"; 
		$ses_sql = mysqli_query($conn, $query6); 
	
		$cuisArr = [];
		while($row = mysqli_fetch_assoc($ses_sql)) 	
		{
				$cuisArr[]=$row;
		}
	}
	else if($_GET["searchval"] != "x1b2v1z4")
	{
		$cityX = $_GET["city"];
		$areaX = $_GET["area"];
	
		$searchVal = $_GET["searchval"];
		$query3 = "SELECT * from `restaurant` r,`restaurant_branch` rb  WHERE rb.rId = r.rId AND `rname` like '%".$searchVal."%' AND EXISTS(SELECT * from `branch_darea` bd where bd.rId = r.rId AND bd.bId = rb.bId AND bd.city = '".$cityX."' AND bd.area_name = '".$areaX."') AND EXISTS(SELECT * from `restaurant_cuisine` rc WHERE r.rId = rc.rId AND cname = '".$cuisX."')"; 
		
		//$pre_query = mysqli_real_escape_string($conn,$query);
		$ses_sql = mysqli_query($conn, $query3); 
		
		$array = [];
		while($row = mysqli_fetch_assoc($ses_sql)) 
		{
			if($row["active"] == 1)
				$array[]=$row;
		}
		
	}
	else
	{
		$cityX = $_GET["city"];
		$areaX = $_GET["area"];
		// SQL Query To Fetch Complete Information Of User 
		//		WHERE city = '".$cityX."' AND area_name = '".$areaX."'
		$query4 = "SELECT * from `restaurant` r, `restaurant_branch` rb WHERE  rb.rId = r.rId AND EXISTS(SELECT * from `branch_darea` bd where bd.rId = r.rId AND bd.bId = rb.bId AND bd.city = '".$cityX."' AND bd.area_name = '".$areaX."') AND EXISTS(SELECT * from `restaurant_cuisine` rc WHERE r.rId = rc.rId AND cname = '".$cuisX."')"; 
		//$pre_query = mysqli_real_escape_string($conn,$query);
		$ses_sql = mysqli_query($conn, $query4); 

		$array = [];
		while($row = mysqli_fetch_assoc($ses_sql)) 
		{
			if($row["active"] == 1)
				$array[]=$row;
		}

	}
}
else
{	
	header("location: restaurants.php?searchval=x1b2v1z4&city=x1b2v1z4&area=x1b2v1z4&cuis=x1b2v1z4");
}



if(isset($_POST["bsearch"]))
{
	if($cityX != "x1b2v1z4" && $areaX != "x1b2v1z4" && $cuisX != "x1b2v1z4")
	{
		$serval = $_POST["search"];
    	header("location: restaurants.php?searchval=$serval&city=$cityX&area=$areaX&cuis=$cuisX");
	}
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
<form class="login100-form p-b-33 p-t-5" method="post" action="">
<div class="input-group mb-3">
  <input type="text" class="form-control" placeholder="Search By Name" aria-label="Search" aria-describedby="basic-addon1" name="search" id = "search">
  <div class="container-login100-form-btn m-t-32">
			<input  name="bsearch"  type = "submit" class="login100-form-btn" value = "Search">
	</div>
</div>
</form>

<div class="container-fluid padding">
	<div class="row welcome text-center">
		<div class="col-12">
			<h1 class="display-4">Select Your City and Area</h1>
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
    <a class="dropdown-item" href="restaurants.php?searchval=x1b2v1z4&city=<?php echo $subarray["city"];?>&area=x1b2v1z4&cuis=x1b2v1z4"> <?php echo $subarray["city"]; ?> </a>
   <?php endforeach; ?>  </div>
</div>


<div class="btn-group">
<button class="btn btn-primary btn-lg dropdown-toggle text-center" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	<?php if($areaX=="x1b2v1z4"){?>Select Area<?php }else{ echo $areaX;}?>
  </button>
  <div class="dropdown-menu">
	<?php if($cityX == "x1b2v1z4"){?>
		<a class="dropdown-item" href="#"> Select City First </a>
	<?php }else{ foreach($areaArr as $subarray): ?>
    <a class="dropdown-item" href="restaurants.php?searchval=x1b2v1z4&city=<?php echo $subarray["city"], "&area=", $subarray["area_name"], "&cuis=x1b2v1z4";?>"> <?php echo $subarray["area_name"]; ?> </a>
   <?php endforeach; }?>  </div>
</div>

<div class="btn-group">
<button class="btn btn-primary btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	<?php if($cuisX=="x1b2v1z4"){?>Select Cuisine<?php }else{ echo $cuisX;}?>
  </button>
  <div class="dropdown-menu">
	<?php if($cityX == "x1b2v1z4" || $areaX == "x1b2v1z4"){?>
		<a class="dropdown-item" href="#"> Select City and Area First </a>
	<?php }else{ foreach($cuisArr as $subarray): ?>
    <a class="dropdown-item" href="restaurants.php?searchval=x1b2v1z4&city=<?php echo $cityX, "&area=", $areaX, "&cuis=",$subarray["cname"];?>"> <?php echo $subarray["cname"]; ?> </a>
   <?php endforeach; }?>  </div>
	
</div>
</div>


<div class="container-fluid padding">
	<div class="row welcome text-center">
		<div class="col-12">
			<h1 class="display-4">Select Your Restaurant</h1>
		</div>
		<hr>
	</div>
</div>

<?php if($cuisX !="x1b2v1z4"):?>
<div class="container-fluid padding">
	<div class="row padding">
	
    <?php foreach($array as $subarray): ?>
    <div class="col-md-4">
			<div class="card">
				<img class="card-img-top" src="<?php if(is_null ($subarray["imgurl"])) {echo  "img\home1.jpg";}else{ echo $subarray["imgurl"];}?>">
				<div class="card-body">
                <h4 class="card-title"><?php echo $subarray["rname"]; ?></h4>
					
    <?php foreach($subarray as $key=>$value): ?>
                    <?php if(($key != "rId")&& ($key != "bId") && ($key != "active")&& ($key != "deleted") && ($key != "rname") && $key != "imgurl"){?>
					    <p><?php echo $value;?></p>
					    <br>
                    <?php }?>
    <?php endforeach; ?>
        <a href="restaurant.php?cart=x1b2v1z4&menu=x1b2v1z4&rest=<?php echo $subarray["rId"],"&branch=",$subarray["bId"],"&city=",$subarray["city"],"&area=",$subarray["area_name"];?>" class="btn btn-outline-secondary">Visit restaurant</a>
				</div>
			</div>
		</div>

    <?php endforeach; ?>


	</div>
	
</div>
<?php endif; ?>

</body>
</html>
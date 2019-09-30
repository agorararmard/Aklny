
<?php

    session_start(); 
    $conn = mysqli_connect("localhost", "root", "", "db_proj"); 

	$query4 = "SELECT * from `restaurant` r"; 
		//$pre_query = mysqli_real_escape_string($conn,$query);
	$ses_sql = mysqli_query($conn, $query4); 

	$array = [];
	while($row = mysqli_fetch_assoc($ses_sql)) 
	{
		if($row["active"] == 1)
			$array[]=$row;
	}

if(isset($_POST["bsearch"]))
{
		$serval = $_POST["search"];
    	
        $query3 = "SELECT * from `restaurant` r WHERE `rname` like '%".$serval."%' "; 
		
		//$pre_query = mysqli_real_escape_string($conn,$query);
		$ses_sql = mysqli_query($conn, $query3); 
		
		$array = [];
		while($row = mysqli_fetch_assoc($ses_sql)) 
		{
			if($row["active"] == 1)
				$array[]=$row;
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


<?php include "AdminNavHead.php";?>
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
			<h1 class="display-4">Select Restaurant To Apply Promocode To</h1>
		</div>
		<hr>
	</div>
</div>

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
        <a href="restPromocode.php?rest=<?php echo $subarray["rId"];?>" class="btn btn-outline-secondary">Edit Promocodes</a>
				</div>
			</div>
		</div>

    <?php endforeach; ?>


	</div>
	
</div>

</body>
</html>
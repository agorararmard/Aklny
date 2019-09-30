
<?php

session_start(); 
	$conn = mysqli_connect("localhost", "root", "", "db_proj"); 
	if($_GET)
	{
		$branchX = $_GET["branch"];
		$cityX = $_GET["city"];
		$areaX = $_GET["area"];
		$restX = $_GET["rest"];
		$menuX = $_GET["menu"];
		$itemX = $_GET["item"];
		$cartX = $_GET["cart"];
		$userX = $_SESSION['login_user'];
 
		$query1 = "SELECT i.* from `item` i WHERE i.rId = '".$restX."' AND i.menu = '".$menuX."' AND i.itemId = '".$itemX."'"; 
		//$pre_query = mysqli_real_escape_string($conn,$query);
		$ses_sql = mysqli_query($conn, $query1); 

		while($row = mysqli_fetch_assoc($ses_sql)) 
		{
			if($row["deleted"] == 0)
				$itemArr=$row;
			else
				header("location: restaurant.php?menu=$menuX&rest=$restX&branch=$branchX&city=$cityX&area=$areaX");
		}

		$query2 = "SELECT ic.* from `item_custom` ic WHERE ic.rId = '".$restX."' AND ic.menu = '".$menuX."' AND ic.itemId = '".$itemX."' ORDER BY ic.price"; 
		//$pre_query = mysqli_real_escape_string($conn,$query);
		$ses_sql = mysqli_query($conn, $query2); 

		$customArr = [];
		while($row = mysqli_fetch_assoc($ses_sql)) 
		{
			if($row["deleted"] == 0)
				$customArr[]=$row;
		}
	}
	else
	{	
		header("location: restaurants.php?searchval=x1b2v1z4&city=x1b2v1z4&area=x1b2v1z4&cuis=x1b2v1z4");
	}



	if(isset($_POST["acart"]))
	{
		$customX = $_POST["customRadio"];
		$cntX = $_POST["amount"];
		$spcust = $_POST["customization"];

		if(is_null($spcust))
			$query = "INSERT INTO cart_item (`username`, `cartId`, `rId`,`menu`,`itemId`,`customId`,`cnt`,`deleted`) VALUES ('".$userX."', '".$cartX."', '".$restX."', '".$menuX."', '".$itemX."', '".$customX."', '".$cntX."', 0)";
		else 
			$query = "INSERT INTO cart_item (`username`, `cartId`, `rId`,`menu`,`itemId`,`customId`,`cnt`,`customization`,`deleted`) VALUES ('".$userX."', '".$cartX."', '".$restX."', '".$menuX."', '".$itemX."', '".$customX."', '".$cntX."','".$spcust."', 0)";
       
        if( mysqli_query($conn,$query))
        { 
            
        }
        else
        {
          header("location: Home.php"); 
        }


		header("location: restaurant.php?menu=$menuX&rest=$restX&branch=$branchX&city=$cityX&area=$areaX&cart=$cartX");
	}

	if(isset($_POST["cancel"]))
	{
		header("location: restaurant.php?menu=$menuX&rest=$restX&branch=$branchX&city=$cityX&area=$areaX&cart=$cartX");
	}
?>

<!DOCTYPE html>
<html lang="en">

<link rel="icon" type="image/png" href="img/logo1.png"/>  <!--for icon-->

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Order <?php echo $itemArr["item_name"];?></title>
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
			<h1 class="display-4"><?php echo $itemArr["item_name"];?></h1>
		</div>
		<hr>
	</div>
</div>

<div class="container-fluid">
	<div class="row jumbotron">
		<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
			<p class="lead">Description: <?php echo $itemArr["description"];?></p>
		</div>
	</div>
</div>


<form class="" method="post" action="">
	<div class="justify-content-between align-items-center">

	<?php foreach($customArr as $subArr):?>
		<div class=" form-group custom-control custom-radio col">
			<input type="radio" id="customRadio<?php echo $subArr["customId"];?>" name="customRadio" class="custom-control-input" value = "<?php echo $subArr["customId"];?>" checked>
			<label class="custom-control-label justify-content-between align-items-center" for="customRadio<?php echo $subArr["customId"];?>"><?php echo $subArr["description"]?> <span class="badge badge-secondary"><?php echo $subArr["price"]," EGP";?></span></label>
		</div>
		<hr>
	<?php endforeach;?>
		
	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
		<p class="lead">Amount:</p>
	</div>

	<div class="input-group mb-3">
	  <input type="text" class="form-control" value="0" aria-label="Search" aria-describedby="basic-addon1" name="amount" id = "amount">
	</div>


	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
		<p class="lead">Special Customization:</p>
	</div>

	<div class="input-group mb-3">
	  <input type="text" class="form-control" placeholder="Special Customization" aria-label="Search1" aria-describedby="basic-addon2" name="customization" id = "customization">
	</div>

	<div class="form-group container-login100-form-btn m-t-32 col">
		<input  name="acart"  type = "submit" class="login100-form-btn" value = "Add to Cart">
	</div>

	
	<div class="form-group container-login100-form-btn m-t-32 col">
		<input  name="cancel"  type = "submit" class="login100-form-btn btn-danger" value = "Cancel">
	</div>

	</div>
</form>

</body>
</html>
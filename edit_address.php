
<?php

session_start(); 
	$conn = mysqli_connect("localhost", "root", "", "db_proj"); 
	if($_GET)
	{
		$cityX = $_GET["city"];
		$areaX = $_GET["area"];
        $add_ID = $_GET["addId"];
        

        $userX = $_SESSION['login_user'];
 
        $addtrig = 0;
        $catrig = 0;

		$query1 = "SELECT * from `city`"; 
		//$pre_query = mysqli_real_escape_string($conn,$query);
		$ses_sql = mysqli_query($conn, $query1); 
        $cityArr = [];
		while($row = mysqli_fetch_assoc($ses_sql)) 
		{
			if($row["deleted"] == 0)
				$cityArr[]=$row;
		}
     
        if($cityX != "x1b2v1z4")
        {
    		$query2 = "SELECT * from `area` WHERE city = '".$cityX."'"; 
    		//$pre_query = mysqli_real_escape_string($conn,$query);
    		$ses_sql = mysqli_query($conn, $query2); 

	    	$areaArr = [];
	    	while($row = mysqli_fetch_assoc($ses_sql)) 
	    	{
			    if($row["deleted"] == 0)
		    		$areaArr[]=$row;
            }
        }

        
    		$query3 = "SELECT * from `usr_address`  WHERE username = '".$userX."' AND city = '".$cityX."'  AND area_name = '".$areaX."' AND addressID = '".$add_ID."'"; 
    		//$pre_query = mysqli_real_escape_string($conn,$query);
    		$ses_sql = mysqli_query($conn, $query3); 

	    	
	    	while($row = mysqli_fetch_assoc($ses_sql)) 
	    	{
			    if($row["Deleted"] == 0)
                    $editArr=$row;
                else
                    header("location: user_address.php");
            }
	}
	else
	{	
		header("location: user_address.php");
	}



	if(isset($_POST["acart"]))
	{
        $addX = $_POST["address"];
        $apnumX = $_POST["apnum"];
        $fnumX = $_POST["fnum"];
        $ecommX = $_POST["ecomm"];

        if($cityX == "x1b2v1z4" || $areaX == "x1b2v1z4")
        {
             $catrig = 1;
        }
        else
        {
           
            if(is_null($addX)||$addX == "")
            {
                $addtrig = 1;
            }
            else
            {   
                $query = "UPDATE `usr_address` SET city = '".$cityX."', area_name = '".$areaX."',address =  '".$addX."', apartmentNo ='".$apnumX."', floorNo ='".$fnumX."', comment ='".$ecommX."' WHERE username = '".$userX."' AND addressID = '".$add_ID."'";
                
                if( mysqli_query($conn,$query))
                { 
                    
                }
                else
                {
                header("location: Home.php"); 
                }

                header("location: user_address.php");
            }
        }
    }
    
    if(isset($_POST["delete"]))
	{
        $delquery = "UPDATE `usr_address` SET Deleted = 1 WHERE username = '".$userX."' AND addressID = '".$add_ID."'";
       
        if( mysqli_query($conn,$delquery))
        { 
            
        }
        else
        {
          header("location: Home.php"); 
        }
        header("location: user_address.php");
    }

	if(isset($_POST["cancel"]))
	{
		header("location: user_address.php");
	}
?>

<!DOCTYPE html>
<html lang="en">

<link rel="icon" type="image/png" href="img/logo1.png"/>  <!--for icon-->

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Address</title>
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
			<h1 class="display-4">Add New Address</h1>
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
    <a class="dropdown-item" href="add_address.php?city=<?php echo $subarray["city"];?>&area=x1b2v1z4"> <?php echo $subarray["city"]; ?> </a>
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
    <a class="dropdown-item" href="add_address.php?&city=<?php echo $subarray["city"], "&area=", $subarray["area_name"];?>"> <?php echo $subarray["area_name"]; ?> </a>
   <?php endforeach; }?>  </div>
</div>

    <?php  if($catrig==1): ?> <div> <p class = "text-danger"> You must select City and Area first</p> </div><?php endif;?>



<form class="" method="post" action="">
	<div class="justify-content-between align-items-center">
		
	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
		<p class="lead">Address:</p>
	</div>

	<div class="input-group mb-3">
	  <input type="text" class="form-control" value="<?php echo $editArr["address"];?>" name="address" id = "address">
  </div>
    <?php if($addtrig == 1):?><div><small id="addHelpBlock" class="form-text text-danger">
       This field cannot be left empty
        </small></div> <?php endif;?>

	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
		<p class="lead">Apartment Number:</p>
	</div>

	<div class="input-group mb-3">
	  <input type="text" class="form-control" value="<?php echo $editArr["apartmentNo"];?>" name="apnum" id = "apnum">
  </div>
  
	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
		<p class="lead">Floor Number:</p>
	</div>
	
	<div class="input-group mb-3">
	  <input type="text" class="form-control" value="<?php echo $editArr["floorNo"]?>" name="fnum" id = "fnum">
  </div>
  

	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
		<p class="lead">Extra Comments:</p>
	</div>

	<div class="input-group mb-3">
	  <input type="text" class="form-control" value="<?php echo $editArr["comment"];?>" name="ecomm" id = "ecomm">
  </div>
  

	<div class="form-group container-login100-form-btn m-t-32 col">
		<input  name="acart"  type = "submit" class="login100-form-btn" value = "Apply Changes">
	</div>

	<div class="form-group container-login100-form-btn m-t-32 col">
		<input  name="delete"  type = "submit" class="login100-form-btn btn-danger" value = "Delete Address">
	</div>

	<div class="form-group container-login100-form-btn m-t-32 col">
		<input  name="cancel"  type = "submit" class="login100-form-btn btn-danger" value = "Cancel">
	</div>

	</div>
</form>

</body>
</html>
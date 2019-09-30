
<?php

session_start(); 
	$conn = mysqli_connect("localhost", "root", "", "db_proj"); 
	if($_GET)
	{
		$cityX = $_GET["city"];
		$areaX = $_GET["area"];
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
	}
	else
	{	
		header("location: user_addresss.php");
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
                
                $adId = ((string)mt_rand());
                $adId  .= ((string)mt_rand());
                $adId  .= ((string)mt_rand());
                $adId  .= ((string)mt_rand());
                $adId  .= ((string)mt_rand());

               /*  if(is_null($apnumX))
                {
                    $apnumX = NULL;
                }   
*/
/*                if(is_null($POST["fnum"]))
                { $fnumX = NULL;   }
                else
                {
                    $fnumX = $POST["fnum"];
                }
*/
      
  //              if(is_null($ecommX))
    //                {    $ecommX = NULL; }  
        

                $query = "INSERT INTO usr_address (`username`, `city`, `area_name`,`addressID`,`address`,`apartmentNo`,`floorNo`,`comment`,`Deleted`) VALUES ('".$userX."', '".$cityX."', '".$areaX."', '".$adId."', '".$addX."', '".$apnumX."', '".$fnumX."','".$ecommX."', 0)";
            
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
	<title>Add Address</title>
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
	  <input type="text" class="form-control" placeholder="Street .., building number .." name="address" id = "address">
  </div>
    <?php if($addtrig == 1):?><div><small id="addHelpBlock" class="form-text text-danger">
       This field cannot be left empty
        </small></div> <?php endif;?>

	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
		<p class="lead">Apartment Number:</p>
	</div>

	<div class="input-group mb-3">
	  <input type="text" class="form-control" placeholder="Apartment Number.." name="apnum" id = "apnum">
  </div>
  
	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
		<p class="lead">Floor Number:</p>
	</div>
	
	<div class="input-group mb-3">
	  <input type="text" class="form-control" placeholder="Floor Number.." name="fnum" id = "fnum">
  </div>
  

	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
		<p class="lead">Extra Comments:</p>
	</div>

	<div class="input-group mb-3">
	  <input type="text" class="form-control" placeholder="Extra Comments.." name="ecomm" id = "ecomm">
  </div>
  

	<div class="form-group container-login100-form-btn m-t-32 col">
		<input  name="acart"  type = "submit" class="login100-form-btn" value = "Add Address">
	</div>

	
	<div class="form-group container-login100-form-btn m-t-32 col">
		<input  name="cancel"  type = "submit" class="login100-form-btn btn-danger" value = "Cancel">
	</div>

	</div>
</form>

</body>
</html>
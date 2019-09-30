
<?php

session_start(); 
$conn = mysqli_connect("localhost", "root", "", "db_proj"); 
if($_GET)
{
    $restX = $_GET["rest"];
    $query1 = "SELECT * from `restaurant_cuisine` where rId = '".$restX."'"; 
    //$pre_query = mysqli_real_escape_string($conn,$query);
    $ses_sql = mysqli_query($conn, $query1); 

    $cuisArr=[];
    while($row = mysqli_fetch_assoc($ses_sql)) 
    {
        if($row["deleted"] == 0)
            $cuisArr[]=$row;
     
    }
}
else
{
    header("location: adminViewRest.php");
}


    if(isset($_POST["apromo"]))
    {
        $cname = $_POST["cname"];

        $padquery = "INSERT INTO `restaurant_cuisine`(`rId`,`cname`,`deleted`) VALUES ('".$restX."', '".$cname."', 0)";
    
        if( mysqli_query($conn,$padquery))
        { 
            header("location: editCuis.php?rest=$restX");
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
<title>List Of Cuisines</title>
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
			<h1 class="display-4">Active Cuisines</h1>
		</div>
		<hr>
	</div>
</div>



<div class="container-fluid padding">
	<div class="row padding">
	
    <?php $cnti = 1; foreach($cuisArr as $subarray):     
            $upo = "orderz";
            $upo .=(string)$cnti;
            if(isset($_POST[$upo]))
	        {
                $newName = $_POST["pass"];
                $posupquery = "UPDATE `restaurant_cuisine` SET cname = '".$newName."' WHERE cname = '".$subarray["cname"]."' and rId = '".$restX."'";
                if( mysqli_query($conn,$posupquery))
                { 
                    header("location: editCuis.php?rest=$restX");
                }
                else
                {
                    header("location: Home.php"); 
                }
            }

            $can = "cancelz";
            $can .=(string)$cnti;
            if(isset($_POST[$can]))
	        {
                $negupquery = "UPDATE `restaurant_cuisine` SET deleted = 1 WHERE cname = '".$subarray["cname"]."' and rId = '".$restX."'";
                if( mysqli_query($conn,$negupquery))
                { 
                    header("location: editCuis.php?rest=$restX");
                }
                else
                {
                    header("location: Home.php"); 
                }
            }
        ?>
    <div class="col-md-4">
			<div class="card">
				<div class="card-body">
                <h4 class="card-title">Cuisine <?php echo $cnti; $cnti = $cnti+1;?></h4>				
                
                  <div><h4 class = "d-flex justify-content-between align-items-center">Cuisine: <?php echo $subarray["cname"];?></h3>
                  </div>
                
                <form class="" method="post" action="">
                	<div class="justify-content-between align-items-center">

                    <div class="input-group mb-3">
	                    <input type="text" class="form-control" placeholder="New Name For the Cuisine" name="pass" id = "pass">
	                </div>

                    <div class="form-group container-login100-form-btn m-t-32 col">
	                	<input  name="<?php echo $upo;?>"  type = "submit" class="login100-form-btn" value = "Update Name">
	                </div>

                	<div class="form-group container-login100-form-btn m-t-32 col">
		                <input  name="<?php echo $can;?>"  type = "submit" class="login100-form-btn btn-danger" value = "Delete Cuisine">
                	</div>

                	</div>
                </form>
                
                </div>
			</div>
		</div>
    
    <?php endforeach; ?>


	</div>
	
</div>







<div class="container-fluid padding">
	<div class="row welcome text-center">
		<div class="col-12">
			<h1 class="display-4">Add New Cuisine</h1>
		</div>
		<hr>
	</div>
</div>




                <form class="" method="post" action="">
                	<div class="justify-content-between align-items-center">

                	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
                		<p class="lead">Cuisine Name:</p>
	                </div>
    
                    <div class="input-group mb-3">
	                    <input type="text" class="form-control" placeholder="Cuisine" name="cname" id = "cname">
	                </div>


                    <div class="form-group container-login100-form-btn m-t-32 col">
	                	<input  name="apromo"  type = "submit" class="login100-form-btn" value = "Add New cuisine">
	                </div>

                	</div>
                </form>
</body>
</html>
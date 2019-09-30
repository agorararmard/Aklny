<?php
session_start(); 
$conn = mysqli_connect("localhost", "root", "", "db_proj"); 
if($_GET)
{
    $restX = $_GET["rest"];
    $promoquery2 = "SELECT * from `promocode` p, `promocode_restaurant` pr WHERE p.promoId = pr.promoId AND p.sdate <= NOW() AND p.edate >= NOW() AND pr.rId = '".$restX."' AND p.deleted = 0"; 
    $ses_sql = mysqli_query($conn, $promoquery2); 
        
    $promoArr2=[];
    while($row = mysqli_fetch_assoc($ses_sql)) 
    {
        if($row["times"] > 0)
            $promoArr2[]=$row;
    }
}
else
{
    header("location: Home.php");
}

if(isset($_POST["apromo"]))
{
    $nTimes = $_POST["ntimes"];
    $prId = $_POST["promo"];
   

    $promoquery3 = "SELECT * from `promocode_restaurant` WHERE promoId = '".$prId."' AND rId = '".$restX."'"; 
    $ses_sql = mysqli_query($conn, $promoquery3); 
        
    $promoArr3;
    while($row = mysqli_fetch_assoc($ses_sql)) 
    {
            $promoArr3=$row;
    }
    if(is_null($promoArr3))
    {
        $promoquery4 = "SELECT * from `promocode` WHERE promoId = '".$prId."'"; 
        $ses_sql = mysqli_query($conn, $promoquery4); 
            
        $promoArr4;
        while($row = mysqli_fetch_assoc($ses_sql)) 
        {
                $promoArr4=$row;
        }
        if(!is_null($promoArr3)){
            $padquery = "INSERT INTO `promocode_restaurant`(`promoId`, `rId`, `times`) VALUES ('".$prId."', '".$restX."','".$nTimes."')";
        
            if( mysqli_query($conn,$padquery))
            { 
                header("location: restPromocode.php?rest=$restX");
            }
            else
            {
                header("location: Home.php"); 
            }
        }
    }
    else
    {
        $pupquery = "UPDATE `promocode_restaurant` SET times = '".$nTimes."' WHERE promoId = '".$prId."' and rId = '".$restX."'";
        if( mysqli_query($conn,$pupquery))
        { 
            header("location: restPromocode.php?rest=$restX");
        }
        else
        {
            header("location: Home.php"); 
        }
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<link rel="icon" type="image/png" href="img/logo1.png"/>  <!--for icon-->

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>List Of Promocodes</title>
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
			<h1 class="display-4">Active Promocodes</h1>
		</div>
		<hr>
	</div>
</div>



<div class="container-fluid padding">
	<div class="row padding">
	
    <?php $cnti = 1; foreach($promoArr2 as $subarray):     
            $upo = "orderz";
            $upo .=(string)$cnti;
            if(isset($_POST[$upo]))
	        {
                $newTimes = $_POST["pass"];
                $posupquery = "UPDATE `promocode_restaurant` SET times = '".$newTimes."' WHERE promoId = '".$subarray["promoId"]."' and rId = '".$restX."'";
                if( mysqli_query($conn,$posupquery))
                { 
                    header("location: restPromocode.php?rest=$restX");
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
                $negupquery = "UPDATE `promocode_restaurant` SET times = 0 WHERE promoId = '".$subarray["promoId"]."' and rId = '".$restX."'";
                if( mysqli_query($conn,$negupquery))
                { 
                    header("location: restPromocode.php?rest=$restX");
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
                <h4 class="card-title">Promocode <?php echo $cnti; $cnti = $cnti+1;?></h4>				
                
                  <div><h4 class = "d-flex justify-content-between align-items-center">User Info:</h3>
                  </div>
                  <br>
                  <div>
                  <p> Promocode: <?php echo $subarray["promoId"];?></p>
                  </div>
                  <div>
                  <p> Number of Times Allowed: <?php echo $subarray["times"];?></p>
                  </div>
                  <div>
                  <p> Start Date: <?php echo $subarray["sdate"];?></p>
                  </div>
                  <div>
                  <p> End Date: <?php echo $subarray["edate"];?></p>
                  </div>
                  <div>
                  <p> Discount: <?php echo $subarray["discount"]*100, "%";?></p>
                  </div>
                
                <form class="" method="post" action="">
                	<div class="justify-content-between align-items-center">

                    <div class="input-group mb-3">
	                    <input type="text" class="form-control" placeholder="New Number of Times Allowed" name="pass" id = "pass">
	                </div>

                    <div class="form-group container-login100-form-btn m-t-32 col">
	                	<input  name="<?php echo $upo;?>"  type = "submit" class="login100-form-btn" value = "Update Number of Times">
	                </div>

                	<div class="form-group container-login100-form-btn m-t-32 col">
		                <input  name="<?php echo $can;?>"  type = "submit" class="login100-form-btn btn-danger" value = "Delete Promocode">
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
			<h1 class="display-4">Apply New Promocode</h1>
		</div>
		<hr>
	</div>
</div>


                <form class="" method="post" action="">
                	<div class="justify-content-between align-items-center">

                	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
                		<p class="lead">Input Promocode:</p>
	                </div>
    
                    <div class="input-group mb-3">
	                    <input type="text" class="form-control" placeholder="Promocode" name="promo" id = "promo">
	                </div>

                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
                		<p class="lead">Input Number of Times Allowed:</p>
                	</div>
                	
                    <div class="input-group mb-3">
	                    <input type="text" class="form-control" placeholder="New Number of Times Allowed" name="ntimes" id = "ntimes">
	                </div>

                    <div class="form-group container-login100-form-btn m-t-32 col">
	                	<input  name="apromo"  type = "submit" class="login100-form-btn" value = "Apply New Promo">
	                </div>

                	</div>
                </form>




</body>
</html>
















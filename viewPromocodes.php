<?php
session_start(); 
$conn = mysqli_connect("localhost", "root", "", "db_proj"); 
    $promoquery2 = "SELECT * from `promocode` p where p.deleted = 0"; 
    $ses_sql = mysqli_query($conn, $promoquery2); 
        
    $promoArr2=[];
    while($row = mysqli_fetch_assoc($ses_sql)) 
    {
        $promoArr2[]=$row;
    }


    if(isset($_POST["apromo"]))
    {
    $ndisc = $_POST["ndisc"];
    $prId = $_POST["promo"];
    $edate = $_POST["edate"];
    $sdate = $_POST["sdate"];

            $padquery = "INSERT INTO `promocode`(`promoId`,`discount`,`sdate`,`edate`, `deleted`) VALUES ('".$prId."', '".$ndisc."','".$sdate."','".$edate."',0)";
        
            if( mysqli_query($conn,$padquery))
            { 
                header("location: viewPromocodes.php");
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
			<h1 class="display-4">Existing Promocodes</h1>
		</div>
		<hr>
	</div>
</div>



<div class="container-fluid padding">
	<div class="row padding">
	
    <?php $cnti = 1; foreach($promoArr2 as $subarray):   ?>
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
                  <p> Start Date: <?php echo $subarray["sdate"];?></p>
                  </div>
                  <div>
                  <p> End Date: <?php echo $subarray["edate"];?></p>
                  </div>
                  <div>
                  <p> Discount: <?php echo $subarray["discount"]*100, "%";?></p>
                  </div>
                  <a href="editPromocode.php?promocode=<?php echo $subarray["promoId"];?>" class="btn btn-outline-secondary">Modify Promocode</a>                
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
                		<p class="lead">Input Start Date:</p>
	                </div>

                    <div class="input-group mb-3">
                        <input class="form-control" type="date" id="sdate" name="sdate" placeholder="2001-01-01">
                    </div>

                	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
                		<p class="lead">Input End Date:</p>
	                </div>

                    <div class="input-group mb-3">
                        <input class="form-control" type="date" id="edate" name="edate" placeholder="2001-01-01">
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
                		<p class="lead">Input Discount in Decimal Points: 0.15 means 15%</p>
                	</div>
                	
                    <div class="input-group mb-3">
	                    <input type="text" class="form-control" placeholder="Discount" name="ndisc" id = "ndisc">
	                </div>

                    <div class="form-group container-login100-form-btn m-t-32 col">
	                	<input  name="apromo"  type = "submit" class="login100-form-btn" value = "Add New Promo">
	                </div>

                	</div>
                </form>




</body>
</html>
















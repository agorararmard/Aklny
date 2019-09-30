<?php
session_start(); 
$conn = mysqli_connect("localhost", "root", "", "db_proj"); 
if($_GET)
{
    $promoX = $_GET["promocode"];

    $promoquery2 = "SELECT * from `promocode` p where p.promoId = '".$promoX."' LIMIT 1"; 
    $ses_sql = mysqli_query($conn, $promoquery2); 
        
    $promoArr2;
    while($row = mysqli_fetch_assoc($ses_sql)) 
    {   
        if($row["deleted"] ==0)
           $promoArr2=$row;
        else
          header("location: viewPromocodes.php");         
    }


    if(isset($_POST["apromo"]))
    {
        $ndisc = $_POST["ndisc"];
        $edate = $_POST["edate"];
        $sdate = $_POST["sdate"];

        $padquery = "UPDATE `promocode` SET `discount` = '".$ndisc."',`sdate` = '".$sdate."', `edate` = '".$edate."' WHERE `promoId` = '".$promoX."'";
        
        if( mysqli_query($conn,$padquery))
        { 
            header("location: viewPromocodes.php");
        }
        else
        {
            header("location: Home.php"); 
        }
        
    }
    if(isset($_POST["delete"]))
    {

        $padquery = "UPDATE `promocode` SET `deleted` = 1 WHERE `promoId` = '".$promoX."'";
        
        if( mysqli_query($conn,$padquery))
        { 
            header("location: viewPromocodes.php");
        }
        else
        {
            header("location: Home.php"); 
        }
        
    }
    if(isset($_POST["cancel"]))
    {
        header("location: viewPromocodes.php");
    }
}
else
{
    header("location: viewPromocodes.php");
}
?>



<!DOCTYPE html>
<html lang="en">

<link rel="icon" type="image/png" href="img/logo1.png"/>  <!--for icon-->

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Promocode</title>
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
			<h1 class="display-4">Edit Promocode</h1>
		</div>
		<hr>
	</div>
</div>


                <form class="" method="post" action="">
                	<div class="justify-content-between align-items-center">

                	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
                		<h4 class="lead">Promocode: <?php echo $promoX;?></h4>
	                </div>
    
                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
                		<p class="lead">Input Start Date:</p>
	                </div>

                    <div class="input-group mb-3">
                        <input class="form-control" type="date" id="sdate" name="sdate" value="<?php echo $promoArr2["sdate"];?>">
                    </div>

                	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
                		<p class="lead">Input End Date:</p>
	                </div>

                    <div class="input-group mb-3">
                        <input class="form-control" type="date" id="edate" name="edate" value="<?php echo $promoArr2["edate"];?>">
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
                		<p class="lead">Input Discount in Decimal Points: 0.15 means 15%</p>
                	</div>
                	
                    <div class="input-group mb-3">
	                    <input type="text" class="form-control" value="<?php echo $promoArr2["discount"];?>" name="ndisc" id = "ndisc">
	                </div>

                    <div class="form-group container-login100-form-btn m-t-32 col">
	                	<input  name="apromo"  type = "submit" class="login100-form-btn" value = "Apply Changes">
	                </div>

                    <div class="form-group container-login100-form-btn m-t-32 col">
	                	<input  name="delete"  type = "submit" class="login100-form-btn" value = "Delete Promocode">
	                </div>

                    <div class="form-group container-login100-form-btn m-t-32 col">
	                	<input  name="cancel"  type = "submit" class="login100-form-btn" value = "Cancel Changes">
	                </div>

                	</div>
                </form>


</body>
</html>
















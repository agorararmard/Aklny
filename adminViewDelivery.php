
<?php

session_start(); 
$conn = mysqli_connect("localhost", "root", "", "db_proj"); 
if($_GET)
{
    $restX = $_GET["rest"];
    $cityX = $_GET["city"];
    $areaX = $_GET["area"];
    $branchX = $_GET["branch"];
    
    
        $query1 = "SELECT * from `branch_darea` where rId = '".$restX."' and bId = '".$branchX."'"; 
        //$pre_query = mysqli_real_escape_string($conn,$query);
        $ses_sql = mysqli_query($conn, $query1); 

        $dlArr = [];
        while($row = mysqli_fetch_assoc($ses_sql)) 
        {
            if($row["deleted"] == 0)
                $dlArr[]=$row;
        }

            $query2 = "SELECT DISTINCT city from `area`"; 
            $ses_sql = mysqli_query($conn, $query2); 
        
            $cityArr = [];
            while($row = mysqli_fetch_assoc($ses_sql)) 	
            {
                    $cityArr[]=$row;
            }
        if(  $_GET["city"] != "x1b2v1z4")
        {
            $query3 = "SELECT DISTINCT city, area_name from `area` WHERE city = '".$cityX."'"; 
            $ses_sql = mysqli_query($conn, $query3); 
        
            $areaArr = [];
            while($row = mysqli_fetch_assoc($ses_sql)) 	
            {
                    $areaArr[]=$row;
            }
        }

    
        if(isset($_POST["apromo"]))
        {
            if($cityX == "x1b2v1z4" || $areaX == "x1b2v1z4")
            {
                header("location: adminViewDelivery.php?city=x1b2v1z4&area=x1b2v1z4&rest=$restX&branch=$branchX");
            }
                $delcharge = $_POST["charge"];
                
                $padquery = "INSERT INTO `branch_darea`(`rId`,`bId`,`city`,`area_name`,`delivery_charge`, `deleted`) VALUES ('".$restX."', '".$branchX."','".$cityX."','".$areaX."','".$delcharge."', 0)";
                    
                if( mysqli_query($conn,$padquery))
                { 
                    header("location: adminViewDelivery.php?city=x1b2v1z4&area=x1b2v1z4&rest=$restX&branch=$branchX");
                }
                else
                {
                    $trypadquery = "UPDATE  `branch_darea` SET `delivery_charge` = '".$delcharge."', `deleted` = 0 WHERE `rId` = '".$restX."'and`bId` = '".$branchX."'and`city` = '".$cityX."' and `area_name` = '".$areaX."'";
                    if( mysqli_query($conn,$trypadquery))
                { 
                
                    header("location: adminViewDelivery.php?city=x1b2v1z4&area=x1b2v1z4&rest=$restX&branch=$branchX");
                }
                else
                {
                    header("location: adminViewDelivery.php?city=x1b2v1z4&area=x1b2v1z4&rest=$restX&branch=$branchX"); 
                }
            }       
        }
}
else{
    header("location: adminViewRest.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<link rel="icon" type="image/png" href="img/logo1.png"/>  <!--for icon-->

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>List Of Delivery Addresses</title>
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
        <h1 class="display-4">Select Branch</h1>
    </div>
    <hr>
</div>
</div>

<div class="container-fluid padding">
<div class="row padding">

<?php $cnti = 1; foreach($dlArr as $subarray): 
     $upo = "orderz";
     $upo .=(string)$cnti;
     if(isset($_POST[$upo]))
     {
         $newTimes = $_POST["pass"];
         $posupquery = "UPDATE `branch_darea` SET delivery_charge = '".$newTimes."' WHERE rId = '".$subarray["rId"]."' and bId = '".$subarray["bId"]."'and city = '".$subarray["city"]."' and area_name = '".$subarray["area_name"]."'";
         if( mysqli_query($conn,$posupquery))
         { 
            header("location: adminViewDelivery.php?city=x1b2v1z4&area=x1b2v1z4&rest=$restX&branch=$branchX");
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
         $negupquery = "UPDATE `branch_darea` SET deleted = 1 WHERE rId = '".$subarray["rId"]."' and bId = '".$subarray["bId"]."'and city = '".$subarray["city"]."' and area_name = '".$subarray["area_name"]."'";
         if( mysqli_query($conn,$negupquery))
         { 
            header("location: adminViewDelivery.php?city=x1b2v1z4&area=x1b2v1z4&rest=$restX&branch=$branchX");
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
            <h4 class="card-title">Delivery Address <?php echo $cnti; $cnti = $cnti+1?></h4>
                    <p>City: <?php echo $subarray["city"];?></p>
                    <br>
                    <p>Area: <?php echo $subarray["area_name"];?></p>
                    <br>
                    <p>Delivery Charge: <?php echo $subarray["delivery_charge"];?></p>
                    <br>

                    <form class="" method="post" action="">
                	<div class="justify-content-between align-items-center">

                    <div class="input-group mb-3">
	                    <input type="text" class="form-control" placeholder="New Delivery Charge" name="pass" id = "pass">
	                </div>

                    <div class="form-group container-login100-form-btn m-t-32 col">
	                	<input  name="<?php echo $upo;?>"  type = "submit" class="login100-form-btn" value = "Update Delivery Charge">
	                </div>

                	<div class="form-group container-login100-form-btn m-t-32 col">
		                <input  name="<?php echo $can;?>"  type = "submit" class="login100-form-btn btn-danger" value = "Delete Delivery Charge">
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
			<h1 class="display-4">Add Delivery Area</h1>
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
    <a class="dropdown-item" href="adminViewDelivery.php?area=x1b2v1z4<?php echo "&city=",$subarray["city"],"&rest=",$restX, "&branch=", $branchX;?>"> <?php echo $subarray["city"]; ?> </a>
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
    <a class="dropdown-item" href="adminViewDelivery.php?area=<?php echo $subarray["area_name"],"&city=",$subarray["city"],"&rest=",$restX, "&branch=", $branchX;?>"> <?php echo $subarray["area_name"]; ?> </a>
   <?php endforeach; }?>  </div>
</div>
</div>



                <form class="" method="post" action="">
                	<div class="justify-content-between align-items-center">

                	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
                		<p class="lead">Input Delivery Charge:</p>
	                </div>
    
                    <div class="input-group mb-3">
	                    <input type="text" class="form-control" placeholder="Delivery Cost" name="charge" id = "charge">
	                </div>


                    <div class="form-group container-login100-form-btn m-t-32 col">
	                	<input  name="apromo"  type = "submit" class="login100-form-btn" value = "Add New Delivery Area">
	                </div>

                	</div>
                </form>


</body>
</html>
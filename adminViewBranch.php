
<?php

session_start(); 
$conn = mysqli_connect("localhost", "root", "", "db_proj"); 
if($_GET)
{
    $restX = $_GET["rest"];
    $cityX = $_GET["city"];
    $areaX = $_GET["area"];

        $query1 = "SELECT * from `restaurant_branch` where rId = '".$restX."'"; 
        //$pre_query = mysqli_real_escape_string($conn,$query);
        $ses_sql = mysqli_query($conn, $query1); 

        $brArr = [];
        while($row = mysqli_fetch_assoc($ses_sql)) 
        {
            if($row["deleted"] == 0)
                $brArr[]=$row;
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
                header("location: adminViewBranch.php?city=x1b2v1z4&area=x1b2v1z4&rest=$restX");
            }
                $open = $_POST["open"];
                $address = $_POST["address"];
                
                $orId = ((string)mt_rand());
                $orId  .= ((string)mt_rand());
                $orId  .= ((string)mt_rand());
                $orId  .= ((string)mt_rand());
                $orId  .= ((string)mt_rand());

                $padquery = "INSERT INTO `restaurant_branch`(`rId`,`bId`,`city`,`area_name`,`address`,`opening_Hours`, `deleted`) VALUES ('".$restX."', '".$orId."','".$cityX."','".$areaX."','".$address."','".$open."', 0)";
                    
                if( mysqli_query($conn,$padquery))
                { 
                    header("location: adminViewBranch.php?city=x1b2v1z4&area=x1b2v1z4&rest=$restX");
                }
                else
                {
                    header("location: Home.php"); 
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
<title>List Of Branches</title>
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

<?php $cnti = 1; foreach($brArr as $subarray): ?>
<div class="col-md-4">
        <div class="card">
            <div class="card-body">
            <h4 class="card-title">Branch <?php echo $cnti; $cnti = $cnti+1?></h4>
                
<?php foreach($subarray as $key=>$value): ?>
                <?php if(($key != "rId")&& ($key != "bId") && ($key != "active")&& ($key != "deleted") && ($key != "rname") && $key != "imgurl"){?>
                    <p><?php echo $value;?></p>
                    <br>
                <?php }?>
<?php endforeach; ?>
    <a href="editBranch.php?rest=<?php echo $subarray["rId"],"&city=",$subarray["city"],"&area=",$subarray["area_name"],"&branch=",$subarray["bId"] ;?>" class="btn btn-outline-secondary">Edit Branch</a>
            </div>
        </div>
    </div>

<?php endforeach; ?>


</div>

</div>

<div class="container-fluid padding">
	<div class="row welcome text-center">
		<div class="col-12">
			<h1 class="display-4">Add Branch</h1>
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
    <a class="dropdown-item" href="adminViewBranch.php?<?php echo "city=",$subarray["city"],"&area=x1b2v1z4","&rest=" , $restX;?>"> <?php echo $subarray["city"]; ?> </a>
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
    <a class="dropdown-item" href="adminViewBranch.php?<?php echo "city=",$subarray["city"],"&area=",$subarray["area_name"],"&rest=" , $restX;?>"> <?php echo $subarray["area_name"]; ?> </a>
   <?php endforeach; }?>  </div>
</div>
</div>



                <form class="" method="post" action="">
                	<div class="justify-content-between align-items-center">

                	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
                		<p class="lead">Input Branch Address:</p>
	                </div>
    
                    <div class="input-group mb-3">
	                    <input type="text" class="form-control" placeholder="Branch Address" name="address" id = "address">
	                </div>

                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
                		<p class="lead">Input Opening Hours:</p>
                	</div>
                	
                    <div class="input-group mb-3">
	                    <input type="text" class="form-control" placeholder="10:00 AM to 2:00 AM" name="open" id = "open">
	                </div>

                    <div class="form-group container-login100-form-btn m-t-32 col">
	                	<input  name="apromo"  type = "submit" class="login100-form-btn" value = "Add New Branch">
	                </div>

                	</div>
                </form>


</body>
</html>
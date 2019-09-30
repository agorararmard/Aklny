
<?php

session_start(); 
$conn = mysqli_connect("localhost", "root", "", "db_proj"); 
if($_GET)
{
    $restX = $_GET["rest"];
    $cityX = $_GET["city"];
    $areaX = $_GET["area"];
    $branchX = $_GET["branch"];

    if($cityX != "x1b2v1z4" && $areaX == "x1b2v1z4")
    {

        $quickquery1 = "SELECT * from `area` where city = '".$cityX."'"; 
        //$pre_query = mysqli_real_escape_string($conn,$query);
        $ses_sql = mysqli_query($conn, $quickquery1); 
    
        while($row = mysqli_fetch_assoc($ses_sql)) 
        {
            if($row["deleted"] == 0)
                $areaX=$row["area_name"];
            else
            header("location: adminViewBranch.php?city=x1b2v1z4&area=x1b2v1z4&rest=$restX");
        }
    }

    $query1 = "SELECT * from `restaurant_branch` where rId = '".$restX."' and city = '".$cityX."' and area_name = '".$areaX."' and bId = '".$branchX."' LIMIT 1"; 
    //$pre_query = mysqli_real_escape_string($conn,$query);
    $ses_sql = mysqli_query($conn, $query1); 

    $brArr;
    while($row = mysqli_fetch_assoc($ses_sql)) 
    {
        if($row["deleted"] == 0)
            $brArr=$row;
        else
        header("location: adminViewBranch.php?city=x1b2v1z4&area=x1b2v1z4&rest=$restX");
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

}
else
{
    header("location: adminViewRest.php");
}


if(isset($_POST["apromo"]))
    {
        $address = $_POST["address"];
        $open = $_POST["open"];

        $padquery = "UPDATE `restaurant_branch` SET `city` = '".$cityX."',`area_name` = '".$areaX."', `address` = '".$address."' , `opening_Hours` = '".$open."'  WHERE `rId` = '".$restX."' and `bId` = '".$branchX."'";
        
            if( mysqli_query($conn,$padquery))
            { 
                header("location: editBranch.php?city=$cityX&area=$areaX&branch=$branchX&rest=$restX");
            }
            else
            {
                header("location: Home.php"); 
            }
    }

    if(isset($_POST["delete"]))
    {
    
        $padquery = "UPDATE `restaurant_branch` SET `deleted` = 1 WHERE `rId` = '".$restX."' and `bId` = '".$branchX."'";
        
            if( mysqli_query($conn,$padquery))
            { 
                header("location: editBranch.php?city=$cityX&area=$areaX&branch=$branchX&rest=$restX");
            }
            else
            {
                header("location: Home.php"); 
            }
    }

    if(isset($_POST["cancel"]))
    {
        header("location: editBranch.php?city=$cityX&area=$areaX&branch=$branchX&rest=$restX");
            
    }

?>

<!DOCTYPE html>
<html lang="en">

<link rel="icon" type="image/png" href="img/logo1.png"/>  <!--for icon-->

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Edit Branch</title>
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
			<h1 class="display-4">Edit Branch Info</h1>
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
    <a class="dropdown-item" href="editBranch.php?rest=<?php echo $restX,"&city=",$subarray["city"],"&area=x1b2v1z4","&branch=",$branchX ;?>"> <?php echo $subarray["city"]; ?> </a>
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
    <a class="dropdown-item" href="editBranch.php?rest=<?php echo $restX,"&city=",$subarray["city"],"&area=",$subarray["area_name"],"&branch=",$branchX ;?>"> <?php echo $subarray["area_name"]; ?> </a>
   <?php endforeach; }?>  </div>
</div>
</div>



                <form class="" method="post" action="">
                	<div class="justify-content-between align-items-center">

                	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
                		<p class="lead">Branch Address:</p>
	                </div>
    
                    <div class="input-group mb-3">
	                    <input type="text" class="form-control" value="<?php echo $brArr["address"]?>" name="address" id = "address">
	                </div>

                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
                		<p class="lead">Opening Hours:</p>
                	</div>
                	
                    <div class="input-group mb-3">
	                    <input type="text" class="form-control" value="<?php echo $brArr["opening_Hours"]?>" name="open" id = "open">
	                </div>

                    <div class="form-group container-login100-form-btn m-t-32 col">
	                	<input  name="apromo"  type = "submit" class="login100-form-btn" value = "Apply Changes">
	                </div>

                    <div class="form-group container-login100-form-btn m-t-32 col">
	                	<input  name="delete"  type = "submit" class="login100-form-btn" value = "Delete Entire Restaurant">
	                </div>
                    
                    <div class="form-group container-login100-form-btn m-t-32 col">
	                	<input  name="cancel"  type = "submit" class="login100-form-btn" value = "Cancel Changes">
	                </div>
                	</div>
                </form>








<div class="container-fluid padding">
<div class="row welcome text-center">
    <div class="col-12">
        <h1 class="display-4">Other Modifications</h1>
    </div>
    <hr>
</div>
</div>



<div class="container-fluid justify-content-between align-items-center">

    <a type="button" class="btn btn-primary btn-lg" href= "adminViewDelivery.php?city=x1b2v1z4&area=x1b2v1z4&rest=<?php echo $restX, "&branch=", $branchX;?>">Modify Delivery Areas and Costs</a>

</div>

</body>
</html>
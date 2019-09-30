
<?php

session_start(); 
$conn = mysqli_connect("localhost", "root", "", "db_proj"); 
if($_GET)
{
    $restX = $_GET["rest"];
    $query1 = "SELECT * from `restaurant` where rId = '".$restX."' LIMIT 1"; 
    //$pre_query = mysqli_real_escape_string($conn,$query);
    $ses_sql = mysqli_query($conn, $query1); 

    $restArr;
    while($row = mysqli_fetch_assoc($ses_sql)) 
    {
        if($row["active"] == 1)
            $restArr=$row;
        else
            header("location: adminViewRest.php");
    }
}
else
{
    header("location: adminViewRest.php");
}


if(isset($_POST["apromo"]))
    {
        $rname = $_POST["rname"];
        $nmn = $_POST["nmn"];
        $imgu = $_POST["imgu"];

        $padquery = "UPDATE `restaurant` SET `rname` = '".$rname."',`mnumber` = '".$nmn."', `imgurl` = '".$imgu."'  WHERE `rId` = '".$restX."'";
        
            if( mysqli_query($conn,$padquery))
            { 
                header("location: editRestaurant.php?rest=$restX");
            }
            else
            {
                header("location: Home.php"); 
            }
    }

    if(isset($_POST["delete"]))
    {
    
        $padquery = "UPDATE `restaurant` SET `active` = 0 WHERE `rId` = '".$restX."'";
        
            if( mysqli_query($conn,$padquery))
            { 
                header("location: adminViewRest.php");
            }
            else
            {
                header("location: Home.php"); 
            }
    }

    if(isset($_POST["cancel"]))
    {
        header("location: editRestaurant.php?rest=$restX");
    }

?>

<!DOCTYPE html>
<html lang="en">

<link rel="icon" type="image/png" href="img/logo1.png"/>  <!--for icon-->

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>List Of Restaurants</title>
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
			<h1 class="display-4">Edit Restaurant Info</h1>
		</div>
		<hr>
	</div>
</div>




                <form class="" method="post" action="">
                	<div class="justify-content-between align-items-center">

                	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
                		<p class="lead">Restaurant Name:</p>
	                </div>
    
                    <div class="input-group mb-3">
	                    <input type="text" class="form-control" value="<?php echo $restArr["rname"]?>" name="rname" id = "rname">
	                </div>

                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
                		<p class="lead">Input Mobile Number:</p>
                	</div>
                	
                    <div class="input-group mb-3">
	                    <input type="text" class="form-control" value="<?php echo $restArr["mnumber"]?>" name="nmn" id = "nmn">
	                </div>

                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
                		<p class="lead">Image URL:</p>
                	</div>
                	
                    <div class="input-group mb-3">
	                    <input type="text" class="form-control" value="<?php echo $restArr["imgurl"]?>" name="imgu" id = "imgu">
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

    <a type="button" class="btn btn-primary btn-lg" href= "adminViewBranch.php?city=x1b2v1z4&area=x1b2v1z4&rest=<?php echo $restX;?>">Modify Branches and Delivery</a>
    <a type="button" class="btn btn-primary btn-lg" href= "adminViewMenus.php?rest=<?php echo $restX;?>">Modify Menus and Items</a>
    <a type="button" class="btn btn-primary btn-lg" href= "editCuis.php?rest=<?php echo $restX;?>">Modify Cuisines</a>

</div>

</body>
</html>
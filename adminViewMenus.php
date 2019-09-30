
<?php

session_start(); 
$conn = mysqli_connect("localhost", "root", "", "db_proj"); 
if($_GET)
{
    $restX = $_GET["rest"];
    $query1 = "SELECT * from `menu` where rId = '".$restX."'"; 
    //$pre_query = mysqli_real_escape_string($conn,$query);
    $ses_sql = mysqli_query($conn, $query1); 

    $menuArr=[];
    while($row = mysqli_fetch_assoc($ses_sql)) 
    {
        if($row["deleted"] == 0)
            $menuArr[]=$row;
     
    }
}
else
{
    header("location: adminViewRest.php");
}


    if(isset($_POST["apromo"]))
    {
        $cname = $_POST["cname"];

        $padquery = "INSERT INTO `menu`(`rId`,`menu`,`deleted`) VALUES ('".$restX."', '".$cname."', 0)";
    
        if( mysqli_query($conn,$padquery))
        { 
            header("location: adminViewMenus.php?rest=$restX");
        }
        else
        {
            $posupquery = "UPDATE `menu` SET deleted = 0 WHERE menu = '".$cname."' and rId = '".$restX."'";
                if( mysqli_query($conn,$posupquery))
                { 
                    header("location: adminViewMenus.php?rest=$restX");
                }
                else
                {
                    header("location: adminViewMenus.php?rest=$restX");
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
<title>List Of Menus</title>
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
			<h1 class="display-4">Active Menus</h1>
		</div>
		<hr>
	</div>
</div>



<div class="container-fluid padding">
	<div class="row padding">
	
    <?php $cnti = 1; foreach($menuArr as $subarray):     
            $upo = "orderz";
            $upo .=(string)$cnti;
            if(isset($_POST[$upo]))
	        {
                $newName = $_POST["pass"];
                $posupquery = "UPDATE `menu` SET menu = '".$newName."' WHERE menu = '".$subarray["menu"]."' and rId = '".$restX."'";
                if( mysqli_query($conn,$posupquery))
                { 
                    header("location: adminViewMenus.php?rest=$restX");
                }
                else
                {
                    header("location: adminViewMenus.php?rest=$restX");
                }
            }

            $can = "cancelz";
            $can .=(string)$cnti;
            if(isset($_POST[$can]))
	        {
                $negupquery = "UPDATE `menu` SET deleted = 1 WHERE menu = '".$subarray["menu"]."' and rId = '".$restX."'";
                if( mysqli_query($conn,$negupquery))
                { 
                    header("location: adminViewMenus.php?rest=$restX");
                }
                else
                {
                    header("location: adminViewMenus.php?rest=$restX"); 
                }
            }
        ?>
    <div class="col-md-4">
			<div class="card">
				<div class="card-body">
                <h4 class="card-title">Menu <?php echo $cnti; $cnti = $cnti+1;?></h4>				
                
                  <div><h4 class = "d-flex justify-content-between align-items-center">Menu: <?php echo $subarray["menu"];?></h3>
                  </div>
                
                <form class="" method="post" action="">
                	<div class="justify-content-between align-items-center">

                    <div class="input-group mb-3">
	                    <input type="text" class="form-control" placeholder="New Name For the Menu" name="pass" id = "pass">
	                </div>

                    <div class="form-group container-login100-form-btn m-t-32 col">
	                	<input  name="<?php echo $upo;?>"  type = "submit" class="login100-form-btn" value = "Update Name">
	                </div>

                	<div class="form-group container-login100-form-btn m-t-32 col">
		                <input  name="<?php echo $can;?>"  type = "submit" class="login100-form-btn btn-danger" value = "Delete Menu">
                	</div>

                	</div>
                </form>
                <a href="editMenuItems.php?&rest=<?php echo $subarray["rId"],"&menu=",$subarray["menu"];?>" class="btn btn-primary">Modify Menu Items</a>
                </div>
			</div>
		</div>
    
    <?php endforeach; ?>


	</div>
	
</div>







<div class="container-fluid padding">
	<div class="row welcome text-center">
		<div class="col-12">
			<h1 class="display-4">Add New Menu</h1>
		</div>
		<hr>
	</div>
</div>




                <form class="" method="post" action="">
                	<div class="justify-content-between align-items-center">

                	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
                		<p class="lead">Menu Name:</p>
	                </div>
    
                    <div class="input-group mb-3">
	                    <input type="text" class="form-control" placeholder="Menu" name="cname" id = "cname">
	                </div>


                    <div class="form-group container-login100-form-btn m-t-32 col">
	                	<input  name="apromo"  type = "submit" class="login100-form-btn" value = "Add New Menu">
	                </div>

                	</div>
                </form>
</body>
</html>
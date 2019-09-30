
<?php

session_start(); 
$conn = mysqli_connect("localhost", "root", "", "db_proj"); 
if($_GET)
{
    $restX = $_GET["rest"];
    $menuX = $_GET["menu"];
    $itemX = $_GET["item"];

    $query1 = "SELECT * from `item_custom` where rId = '".$restX."' and menu = '".$menuX."' and itemId = '".$itemX."'"; 
    //$pre_query = mysqli_real_escape_string($conn,$query);
    $ses_sql = mysqli_query($conn, $query1); 

    $customArr=[];
    while($row = mysqli_fetch_assoc($ses_sql)) 
    {
        if($row["deleted"] == 0)
            $customArr[]=$row;
    }
}
else
{
    header("location: adminViewRest.php");
}


    if(isset($_POST["apromo"]))
    {
        $desc = $_POST["cname"];
        $price = $_POST["desc"];
        
        $orId = ((string)mt_rand());
        $orId  .= ((string)mt_rand());
        $orId  .= ((string)mt_rand());
        $orId  .= ((string)mt_rand());
        $orId  .= ((string)mt_rand());

        $padquery = "INSERT INTO `item_custom`(`rId`,`menu`,itemId,`customId`,`description`,`price`,`deleted`) VALUES ('".$restX."','".$menuX."','".$itemX."','".$orId."' , '".$desc."','".$price."', 0)";
    
        if( mysqli_query($conn,$padquery))
        { 
            header("location: editItemCustoms.php?&rest=$restX&menu=$menuX&item=$itemX");
        }
        else
        {
            header("location: editItemCustoms.php?&rest=$restX&menu=$menuX&item=$itemX");
        
        }
} 
?>



<!DOCTYPE html>
<html lang="en">

<link rel="icon" type="image/png" href="img/logo1.png"/>  <!--for icon-->

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>List Of Customizations</title>
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
			<h1 class="display-4">Active Customizations</h1>
		</div>
		<hr>
	</div>
</div>



<div class="container-fluid padding">
	<div class="row padding">
	
    <?php $cnti = 1; foreach($customArr as $subarray):     
            $upo = "orderz";
            $upo .=(string)$cnti;
            if(isset($_POST[$upo]))
	        {
                $newdesc = $_POST["pass"];
                $newprice = $_POST["desc2"];
                $posupquery = "UPDATE `item_custom` SET description = '".$newdesc."', price = '".$newprice."' WHERE itemId = '".$subarray["itemId"]."' and customId = '".$subarray["customId"]."' and menu = '".$menuX."' and rId = '".$restX."'";
                if( mysqli_query($conn,$posupquery))
                { 
                    header("location: editItemCustoms.php?&rest=$restX&menu=$menuX&item=$itemX");   
                }
                else
                {
                    header("location: editItemCustoms.php?&rest=$restX&menu=$menuX&item=$itemX");
                                }
            }

            $can = "cancelz";
            $can .=(string)$cnti;
            if(isset($_POST[$can]))
	        {
                $negupquery = "UPDATE `item_custom` SET deleted = 1 WHERE itemId = '".$subarray["itemId"]."' and customId = '".$subarray["customId"]."' and menu = '".$menuX."' and rId = '".$restX."'";
                if( mysqli_query($conn,$negupquery))
                { 
                    header("location: editItemCustoms.php?&rest=$restX&menu=$menuX&item=$itemX");
                }
                else
                {
                    header("location: editItemCustoms.php?&rest=$restX&menu=$menuX&item=$itemX"); 
                }
            }
        ?>
    <div class="col-md-4">
			<div class="card">
				<div class="card-body">
                <h4 class="card-title">Custom <?php echo $cnti; $cnti = $cnti+1;?></h4>				
                
                
                <form class="" method="post" action="">
                	<div class="justify-content-between align-items-center">
                
                    <div><h4 class = "d-flex justify-content-between align-items-center">Custom Description: </h3>
                  </div>
                
                    <div class="input-group mb-3">
	                    <input type="text" class="form-control" value="<?php echo $subarray["description"];?>" name="pass" id = "pass">
	                </div>

                    <div><h4 class = "d-flex justify-content-between align-items-center">Price: </h3>
                  </div>
                
                    <div class="input-group mb-3">
	                    <input type="text" class="form-control" value="<?php echo $subarray["price"];?>" name="desc2" id = "desc2">
	                </div>

                    <div class="form-group container-login100-form-btn m-t-32 col">
	                	<input  name="<?php echo $upo;?>"  type = "submit" class="login100-form-btn" value = "Update Info">
	                </div>

                	<div class="form-group container-login100-form-btn m-t-32 col">
		                <input  name="<?php echo $can;?>"  type = "submit" class="login100-form-btn btn-danger" value = "Delete Custom">
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
			<h1 class="display-4">Add New Custom</h1>
		</div>
		<hr>
	</div>
</div>




                <form class="" method="post" action="">
                	<div class="justify-content-between align-items-center">

                	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
                		<p class="lead">Custom Description:</p>
	                </div>
    
                    <div class="input-group mb-3">
	                    <input type="text" class="form-control" placeholder="Custom Description" name="cname" id = "cname">
	                </div>

                	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
                		<p class="lead">Price:</p>
	                </div>
                    <div class="input-group mb-3">
	                    <input type="text" class="form-control" placeholder="price" name="desc" id = "desc">
	                </div>

                    <div class="form-group container-login100-form-btn m-t-32 col">
	                	<input  name="apromo"  type = "submit" class="login100-form-btn" value = "Add Customization to Item">
	                </div>

                	</div>
                </form>
</body>
</html>
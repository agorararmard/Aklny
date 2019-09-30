
<?php

session_start(); 
$conn = mysqli_connect("localhost", "root", "", "db_proj"); 
$userX = $_SESSION['login_user'];    

$querysr = "SELECT * from `staff_rest` where username = '".$userX."' LIMIT 1"; 
$ses_sql = mysqli_query($conn, $querysr); 
	
$staffrestArr;
while($row = mysqli_fetch_assoc($ses_sql)) 	
{
    if($row["deleted"] == 0)
	    $staffrestArr=$row;
}
if(is_null($staffrestArr))
{
    header("location: Home.php");
}

$restX = $staffrestArr["rId"];

$query1 = "SELECT * from `ordr` o where exists (SELECT * from `cart_item` ci where ci.username = o.username AND ci.cartId = o.cartId AND ci.rId = '".$restX."')"; 
$ses_sql = mysqli_query($conn, $query1); 
	
$orArr = [];
while($row = mysqli_fetch_assoc($ses_sql)) 	
{
    if($row["deleted"] == 0)
	    $orArr[]=$row;
}
?>

<!DOCTYPE html>
<html lang="en">

<link rel="icon" type="image/png" href="img/logo1.png"/>  <!--for icon-->

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>List Of Orders</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
	<link href="style.css" rel="stylesheet">
</head>
<body>


<?php include "navHead.php";?>

<div class="container-fluid padding">
	<div class="row welcome text-center">
		<div class="col-12">
			<h1 class="display-4">Orders Pending Approval</h1>
		</div>
		<hr>
	</div>
</div>



<?php if(count($orArr) > 0):?>



<div class="container-fluid padding">
	<div class="row padding">
	
    <?php $cnti = 1; foreach($orArr as $subarray): 
        if($subarray["status"] == "Pending Approval")
        {
            $delcharge = 0;

            $query5 = "SELECT ci.*, i.item_name, i.description AS itdes ,ic.description AS itcustom ,ic.price from `cart_item` ci, `item` i, `item_custom` ic WHERE ci.username = '".$subarray["username"]."' AND ci.cartId = '".$subarray["cartId"]."'  AND ic.rId = ci.rId AND ic.menu = ci.menu AND ic.itemId = ci.itemId AND ic.customId = ci.customId AND i.itemId = ci.itemId AND i.rId = ci.rId AND i.menu = ci.menu"; 
            //$pre_query = mysqli_real_escape_string($conn,$query);
            $ses_sql = mysqli_query($conn, $query5); 
        
            $cartArr = [];
            while($row = mysqli_fetch_assoc($ses_sql)) 
            {
                if($row["deleted"] == 0)
                    $cartArr[]=$row;
            }      
            $forpromoX = $subarray["promocode"];
            if(is_null($forpromoX) ||$forpromoX=="x1b2v1z4" )
            {
                $disc = 0;
            }
            else
            {
            $promoquery2 = "SELECT * from `promocode` p WHERE p.promoId = '".$forpromoX."'"; 
            //$pre_query = mysqli_real_escape_string($conn,$query);
            $ses_sql = mysqli_query($conn, $promoquery2); 
        
            $promoArr2;
            while($row = mysqli_fetch_assoc($ses_sql)) 
            {
                    $promoArr2=$row;
            }
            if(is_null($promoArr2) || $promoArr2 == "")
            {$disc = 0;} 
            else 
            {$disc = $promoArr2["discount"];}
            }

            $query3 = "SELECT * from `usr_address` where username = '".$subarray["username"]."' AND addressID= '".$subarray["addressID"]."' LIMIT 1"; 
            $ses_sql = mysqli_query($conn, $query3); 
            
            $thisaddArr;
            while($row = mysqli_fetch_assoc($ses_sql)) 	
            {
                $thisaddArr=$row;
            }
            $userinfoquery3 = "SELECT * from `usr` where username = '".$subarray["username"]."' LIMIT 1"; 
            $ses_sql = mysqli_query($conn, $userinfoquery3); 
            
            $userinfoArr;
            while($row = mysqli_fetch_assoc($ses_sql)) 	
            {
                $userinfoArr=$row;
            }

            if(!is_null($thisaddArr))
            { 
                $forcityX = $thisaddArr["city"];
                $forareaX = $thisaddArr["area_name"];
    
            $forcartX = $subarray["cartId"];
            $queryX = "SELECT DISTINCT rId from `cart_item` where username = '".$subarray["username"]."' AND cartId= '".$forcartX."' LIMIT 1"; 
            $ses_sql = mysqli_query($conn, $queryX); 
            
            $thisrestArr;
            while($row = mysqli_fetch_assoc($ses_sql)) 	
            {
                $thisrestArr=$row;
            }

            $forrestX = $thisrestArr["rId"];

                $query4 = "SELECT * from  `branch_darea` where rId = '".$forrestX."' and city = '".$forcityX."' and area_name ='".$forareaX."' ORDER BY delivery_charge LIMIT 1"; 
                $ses_sql = mysqli_query($conn, $query4); 
            
                while($row = mysqli_fetch_assoc($ses_sql)) 	
                {
                        $delArr =$row;
                }
                $delcharge = $delArr["delivery_charge"];
            }



            
            $upo = "orderx";
            $upo .=(string)$cnti;
            if(isset($_POST[$upo]))
	        {
                $posupquery = "UPDATE `ordr` SET status = 'Preparing Order' WHERE username = '".$subarray["username"]."' and cartId = '".$subarray["cartId"]."' and orderId = '".$subarray["orderId"]."'";
                if( mysqli_query($conn,$posupquery))
                { 
                    header("location: staff_carts.php");
                }
                else
                {
                    header("location: Home.php"); 
                }
            }

            $can = "cancelx";
            $can .=(string)$cnti;
            if(isset($_POST[$can]))
	        {
                $negupquery = "UPDATE `ordr` SET status = 'Cancelled' WHERE username = '".$subarray["username"]."' and cartId = '".$subarray["cartId"]."' and orderId = '".$subarray["orderId"]."'";
                if( mysqli_query($conn,$negupquery))
                { 
                    header("location: staff_carts.php");
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
                <h4 class="card-title">Order <?php echo $cnti; $cnti = $cnti+1;?></h4>				
                <ul class="list-group">
  			
                <?php $allTot= 0; foreach($cartArr as $smarr): ?>
                <a  class="list-group-item list-group-item-action">
                  <div><h4 class = "d-flex justify-content-between align-items-center"><?php echo $smarr["item_name"];?> <span class="badge badge-primary badge-pill"><?php $tot = $smarr["price"]*$smarr["cnt"]; $allTot= $allTot + $tot; echo $tot, "EGP";?></span></h3>
                  </div>
                  <br>
                  <div>
                  <p> Number of items: <?php echo $smarr["cnt"];?></p>
                  </div>
                  <div>
                  <p> Item Description: <?php echo $smarr["itdes"];?></p>
                  </div>
                  <div>
                  <p> Custom Description: <?php echo $smarr["itcustom"];?></p>
                  </div>
                  <div>
                  <p> Special Customization: <?php echo $smarr["customization"];?></p>
                  </div>
              </a>
              <?php endforeach; ?>
              <a  class="list-group-item list-group-item-action">
                  <div><h4 class = "d-flex justify-content-between align-items-center">User Info:</h3>
                  </div>
                  <br>
                  <div>
                  <p> Name: <?php echo $userinfoArr["FName"], " ", $userinfoArr["LName"];?></p>
                  </div>
                  <div>
                  <p> Phone Number: <?php echo $userinfoArr["Mnumber"];?></p>
                  </div>
                  <div>
                  <p> City: <?php echo $thisaddArr["city"];?></p>
                  </div>
                  <div>
                  <p> Area: <?php echo $thisaddArr["area_name"];?></p>
                  </div>
                  <div>
                  <p> Address: <?php echo $thisaddArr["address"];?></p>
                  </div>
                  <div>
                  <p> Apartment Number: <?php echo $thisaddArr["apartmentNo"];?></p>
                  </div>
                  <div>
                  <p> Floor Number: <?php echo $thisaddArr["floorNo"];?></p>
                  </div>
                  <div>
                  <p> Extra Comments: <?php echo $thisaddArr["comment"];?></p>
                  </div>
                  </a>
              </ul>
              <div>
                <h4> Initial Total: <?php  echo $allTot; ?></h4>
               </div>
                     
              <div>
                <h4> After Discount: <?php $allTot = $allTot- $allTot*$disc; echo $allTot; ?></h4>
               </div>
                
                <div>
					<h4> Taxes 14%: <?php echo $allTot*0.14, " EGP";?></h4>
				</div>
                
                <div>
                    <h4> Delivery Cost: <?php echo $delcharge;?></h4>
				</div>

                <div>
					<h4> Total Cost: <?php $TotCost= $allTot + $allTot*0.14 + $delcharge; echo $TotCost, " EGP";?></h4>
                </div>
                <div>           
                  <a  class="btn btn-outline-secondary">Status: <?php echo $subarray["status"];?></a>
                </div>

                
                <form class="" method="post" action="">
                	<div class="justify-content-between align-items-center">

                    <div class="form-group container-login100-form-btn m-t-32 col">
	                	<input  name="<?php echo $upo;?>"  type = "submit" class="login100-form-btn" value = "Approve">
	                </div>

	
                	<div class="form-group container-login100-form-btn m-t-32 col">
		                <input  name="<?php echo $can;?>"  type = "submit" class="login100-form-btn btn-danger" value = "Cancel">
                	</div>

                	</div>
                </form>
                
                </div>
			</div>
		</div>
    
    <?php } endforeach; ?>


	</div>
	
</div>





<div class="container-fluid padding">
	<div class="row welcome text-center">
		<div class="col-12">
			<h1 class="display-4">Orders Pending Preperation</h1>
		</div>
		<hr>
	</div>
</div>



<div class="container-fluid padding">
	<div class="row padding">
	
    <?php $cnti = 1; foreach($orArr as $subarray): 
        if($subarray["status"] == "Preparing Order")
        {
            $delcharge = 0;

            $query5 = "SELECT ci.*, i.item_name, i.description AS itdes ,ic.description AS itcustom ,ic.price from `cart_item` ci, `item` i, `item_custom` ic WHERE ci.username = '".$subarray["username"]."' AND ci.cartId = '".$subarray["cartId"]."'  AND ic.rId = ci.rId AND ic.menu = ci.menu AND ic.itemId = ci.itemId AND ic.customId = ci.customId AND i.itemId = ci.itemId AND i.rId = ci.rId AND i.menu = ci.menu"; 
            //$pre_query = mysqli_real_escape_string($conn,$query);
            $ses_sql = mysqli_query($conn, $query5); 
        
            $cartArr = [];
            while($row = mysqli_fetch_assoc($ses_sql)) 
            {
                if($row["deleted"] == 0)
                    $cartArr[]=$row;
            }      
            $forpromoX = $subarray["promocode"];
            if(is_null($forpromoX) ||$forpromoX=="x1b2v1z4" )
            {
                $disc = 0;
            }
            else
            {
            $promoquery2 = "SELECT * from `promocode` p WHERE p.promoId = '".$forpromoX."'"; 
            //$pre_query = mysqli_real_escape_string($conn,$query);
            $ses_sql = mysqli_query($conn, $promoquery2); 
        
            $promoArr2;
            while($row = mysqli_fetch_assoc($ses_sql)) 
            {
                    $promoArr2=$row;
            }
            if(is_null($promoArr2) || $promoArr2 == "")
            {$disc = 0;} 
            else 
            {$disc = $promoArr2["discount"];}
            }

            $query3 = "SELECT * from `usr_address` where username = '".$subarray["username"]."' AND addressID= '".$subarray["addressID"]."' LIMIT 1"; 
            $ses_sql = mysqli_query($conn, $query3); 
            
            $thisaddArr;
            while($row = mysqli_fetch_assoc($ses_sql)) 	
            {
                $thisaddArr=$row;
            }
            $userinfoquery3 = "SELECT * from `usr` where username = '".$subarray["username"]."' LIMIT 1"; 
            $ses_sql = mysqli_query($conn, $userinfoquery3); 
            
            $userinfoArr;
            while($row = mysqli_fetch_assoc($ses_sql)) 	
            {
                $userinfoArr=$row;
            }

            if(!is_null($thisaddArr))
            { 
                $forcityX = $thisaddArr["city"];
                $forareaX = $thisaddArr["area_name"];
    
            $forcartX = $subarray["cartId"];
            $queryX = "SELECT DISTINCT rId from `cart_item` where username = '".$subarray["username"]."' AND cartId= '".$forcartX."' LIMIT 1"; 
            $ses_sql = mysqli_query($conn, $queryX); 
            
            $thisrestArr;
            while($row = mysqli_fetch_assoc($ses_sql)) 	
            {
                $thisrestArr=$row;
            }

            $forrestX = $thisrestArr["rId"];

                $query4 = "SELECT * from  `branch_darea` where rId = '".$forrestX."' and city = '".$forcityX."' and area_name ='".$forareaX."' ORDER BY delivery_charge LIMIT 1"; 
                $ses_sql = mysqli_query($conn, $query4); 
            
                while($row = mysqli_fetch_assoc($ses_sql)) 	
                {
                        $delArr =$row;
                }
                $delcharge = $delArr["delivery_charge"];
            }



            
            $upo = "ordery";
            $upo .=(string)$cnti;
            if(isset($_POST[$upo]))
	        {
                $posupquery = "UPDATE `ordr` SET status = 'Delivering' WHERE username = '".$subarray["username"]."' and cartId = '".$subarray["cartId"]."' and orderId = '".$subarray["orderId"]."'";
                if( mysqli_query($conn,$posupquery))
                { 
                    header("location: staff_carts.php");
                }
                else
                {
                    header("location: Home.php"); 
                }
            }

            $can = "cancely";
            $can .=(string)$cnti;
            if(isset($_POST[$can]))
	        {
                $negupquery = "UPDATE `ordr` SET status = 'Cancelled' WHERE username = '".$subarray["username"]."' and cartId = '".$subarray["cartId"]."' and orderId = '".$subarray["orderId"]."'";
                if( mysqli_query($conn,$negupquery))
                { 
                    header("location: staff_carts.php");
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
                <h4 class="card-title">Order <?php echo $cnti; $cnti = $cnti+1;?></h4>				
                <ul class="list-group">
  			
                <?php $allTot= 0; foreach($cartArr as $smarr): ?>
                <a  class="list-group-item list-group-item-action">
                  <div><h4 class = "d-flex justify-content-between align-items-center"><?php echo $smarr["item_name"];?> <span class="badge badge-primary badge-pill"><?php $tot = $smarr["price"]*$smarr["cnt"]; $allTot= $allTot + $tot; echo $tot, "EGP";?></span></h3>
                  </div>
                  <br>
                  <div>
                  <p> Number of items: <?php echo $smarr["cnt"];?></p>
                  </div>
                  <div>
                  <p> Item Description: <?php echo $smarr["itdes"];?></p>
                  </div>
                  <div>
                  <p> Custom Description: <?php echo $smarr["itcustom"];?></p>
                  </div>
                  <div>
                  <p> Special Customization: <?php echo $smarr["customization"];?></p>
                  </div>
              </a>
              <?php endforeach; ?>
              <a  class="list-group-item list-group-item-action">
                  <div><h4 class = "d-flex justify-content-between align-items-center">User Info:</h3>
                  </div>
                  <br>
                  <div>
                  <p> Name: <?php echo $userinfoArr["FName"], " ", $userinfoArr["LName"];?></p>
                  </div>
                  <div>
                  <p> Phone Number: <?php echo $userinfoArr["Mnumber"];?></p>
                  </div>
                  <div>
                  <p> City: <?php echo $thisaddArr["city"];?></p>
                  </div>
                  <div>
                  <p> Area: <?php echo $thisaddArr["area_name"];?></p>
                  </div>
                  <div>
                  <p> Address: <?php echo $thisaddArr["address"];?></p>
                  </div>
                  <div>
                  <p> Apartment Number: <?php echo $thisaddArr["apartmentNo"];?></p>
                  </div>
                  <div>
                  <p> Floor Number: <?php echo $thisaddArr["floorNo"];?></p>
                  </div>
                  <div>
                  <p> Extra Comments: <?php echo $thisaddArr["comment"];?></p>
                  </div>
                  </a>
              </ul>
              <div>
                <h4> Initial Total: <?php  echo $allTot; ?></h4>
               </div>
                     
              <div>
                <h4> After Discount: <?php $allTot = $allTot- $allTot*$disc; echo $allTot; ?></h4>
               </div>
                
                <div>
					<h4> Taxes 14%: <?php echo $allTot*0.14, " EGP";?></h4>
				</div>
                
                <div>
                    <h4> Delivery Cost: <?php echo $delcharge;?></h4>
				</div>

                <div>
					<h4> Total Cost: <?php $TotCost= $allTot + $allTot*0.14 + $delcharge; echo $TotCost, " EGP";?></h4>
                </div>
                <div>           
                  <a  class="btn btn-outline-secondary">Status: <?php echo $subarray["status"];?></a>
                </div>

                
                <form class="" method="post" action="">
                	<div class="justify-content-between align-items-center">

                    <div class="form-group container-login100-form-btn m-t-32 col">
	                	<input  name="<?php echo $upo;?>"  type = "submit" class="login100-form-btn" value = "Deliver">
	                </div>

	
                	<div class="form-group container-login100-form-btn m-t-32 col">
		                <input  name="<?php echo $can;?>"  type = "submit" class="login100-form-btn btn-danger" value = "Cancel">
                	</div>

                	</div>
                </form>
                
                </div>
			</div>
		</div>
    
    <?php } endforeach; ?>


	</div>
	
</div>


<div class="container-fluid padding">
	<div class="row welcome text-center">
		<div class="col-12">
			<h1 class="display-4">Orders Pending Delivery</h1>
		</div>
		<hr>
	</div>
</div>



<div class="container-fluid padding">
	<div class="row padding">
	
    <?php $cnti = 1; foreach($orArr as $subarray): 
        if($subarray["status"] == "Delivering")
        {
            $delcharge = 0;

            $query5 = "SELECT ci.*, i.item_name, i.description AS itdes ,ic.description AS itcustom ,ic.price from `cart_item` ci, `item` i, `item_custom` ic WHERE ci.username = '".$subarray["username"]."' AND ci.cartId = '".$subarray["cartId"]."'  AND ic.rId = ci.rId AND ic.menu = ci.menu AND ic.itemId = ci.itemId AND ic.customId = ci.customId AND i.itemId = ci.itemId AND i.rId = ci.rId AND i.menu = ci.menu"; 
            //$pre_query = mysqli_real_escape_string($conn,$query);
            $ses_sql = mysqli_query($conn, $query5); 
        
            $cartArr = [];
            while($row = mysqli_fetch_assoc($ses_sql)) 
            {
                if($row["deleted"] == 0)
                    $cartArr[]=$row;
            }      
            $forpromoX = $subarray["promocode"];
            if(is_null($forpromoX) ||$forpromoX=="x1b2v1z4" )
            {
                $disc = 0;
            }
            else
            {
            $promoquery2 = "SELECT * from `promocode` p WHERE p.promoId = '".$forpromoX."'"; 
            //$pre_query = mysqli_real_escape_string($conn,$query);
            $ses_sql = mysqli_query($conn, $promoquery2); 
        
            $promoArr2;
            while($row = mysqli_fetch_assoc($ses_sql)) 
            {
                    $promoArr2=$row;
            }
            if(is_null($promoArr2) || $promoArr2 == "")
            {$disc = 0;} 
            else 
            {$disc = $promoArr2["discount"];}
            }

            $query3 = "SELECT * from `usr_address` where username = '".$subarray["username"]."' AND addressID= '".$subarray["addressID"]."' LIMIT 1"; 
            $ses_sql = mysqli_query($conn, $query3); 
            
            $thisaddArr;
            while($row = mysqli_fetch_assoc($ses_sql)) 	
            {
                $thisaddArr=$row;
            }
            $userinfoquery3 = "SELECT * from `usr` where username = '".$subarray["username"]."' LIMIT 1"; 
            $ses_sql = mysqli_query($conn, $userinfoquery3); 
            
            $userinfoArr;
            while($row = mysqli_fetch_assoc($ses_sql)) 	
            {
                $userinfoArr=$row;
            }

            if(!is_null($thisaddArr))
            { 
                $forcityX = $thisaddArr["city"];
                $forareaX = $thisaddArr["area_name"];
    
            $forcartX = $subarray["cartId"];
            $queryX = "SELECT DISTINCT rId from `cart_item` where username = '".$subarray["username"]."' AND cartId= '".$forcartX."' LIMIT 1"; 
            $ses_sql = mysqli_query($conn, $queryX); 
            
            $thisrestArr;
            while($row = mysqli_fetch_assoc($ses_sql)) 	
            {
                $thisrestArr=$row;
            }

            $forrestX = $thisrestArr["rId"];

                $query4 = "SELECT * from  `branch_darea` where rId = '".$forrestX."' and city = '".$forcityX."' and area_name ='".$forareaX."' ORDER BY delivery_charge LIMIT 1"; 
                $ses_sql = mysqli_query($conn, $query4); 
            
                while($row = mysqli_fetch_assoc($ses_sql)) 	
                {
                        $delArr =$row;
                }
                $delcharge = $delArr["delivery_charge"];
            }



            
            $upo = "orderz";
            $upo .=(string)$cnti;
            if(isset($_POST[$upo]))
	        {
                $posupquery = "UPDATE `ordr` SET status = 'Delivered' WHERE username = '".$subarray["username"]."' and cartId = '".$subarray["cartId"]."' and orderId = '".$subarray["orderId"]."'";
                if( mysqli_query($conn,$posupquery))
                { 
                    header("location: staff_carts.php");
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
                $negupquery = "UPDATE `ordr` SET status = 'Cancelled' WHERE username = '".$subarray["username"]."' and cartId = '".$subarray["cartId"]."' and orderId = '".$subarray["orderId"]."'";
                if( mysqli_query($conn,$negupquery))
                { 
                    header("location: staff_carts.php");
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
                <h4 class="card-title">Order <?php echo $cnti; $cnti = $cnti+1;?></h4>				
                <ul class="list-group">
  			
                <?php $allTot= 0; foreach($cartArr as $smarr): ?>
                <a  class="list-group-item list-group-item-action">
                  <div><h4 class = "d-flex justify-content-between align-items-center"><?php echo $smarr["item_name"];?> <span class="badge badge-primary badge-pill"><?php $tot = $smarr["price"]*$smarr["cnt"]; $allTot= $allTot + $tot; echo $tot, "EGP";?></span></h3>
                  </div>
                  <br>
                  <div>
                  <p> Number of items: <?php echo $smarr["cnt"];?></p>
                  </div>
                  <div>
                  <p> Item Description: <?php echo $smarr["itdes"];?></p>
                  </div>
                  <div>
                  <p> Custom Description: <?php echo $smarr["itcustom"];?></p>
                  </div>
                  <div>
                  <p> Special Customization: <?php echo $smarr["customization"];?></p>
                  </div>
              </a>
              <?php endforeach; ?>
              <a  class="list-group-item list-group-item-action">
                  <div><h4 class = "d-flex justify-content-between align-items-center">User Info:</h3>
                  </div>
                  <br>
                  <div>
                  <p> Name: <?php echo $userinfoArr["FName"], " ", $userinfoArr["LName"];?></p>
                  </div>
                  <div>
                  <p> Phone Number: <?php echo $userinfoArr["Mnumber"];?></p>
                  </div>
                  <div>
                  <p> City: <?php echo $thisaddArr["city"];?></p>
                  </div>
                  <div>
                  <p> Area: <?php echo $thisaddArr["area_name"];?></p>
                  </div>
                  <div>
                  <p> Address: <?php echo $thisaddArr["address"];?></p>
                  </div>
                  <div>
                  <p> Apartment Number: <?php echo $thisaddArr["apartmentNo"];?></p>
                  </div>
                  <div>
                  <p> Floor Number: <?php echo $thisaddArr["floorNo"];?></p>
                  </div>
                  <div>
                  <p> Extra Comments: <?php echo $thisaddArr["comment"];?></p>
                  </div>
                  </a>
              </ul>
              <div>
                <h4> Initial Total: <?php  echo $allTot; ?></h4>
               </div>
                     
              <div>
                <h4> After Discount: <?php $allTot = $allTot- $allTot*$disc; echo $allTot; ?></h4>
               </div>
                
                <div>
					<h4> Taxes 14%: <?php echo $allTot*0.14, " EGP";?></h4>
				</div>
                
                <div>
                    <h4> Delivery Cost: <?php echo $delcharge;?></h4>
				</div>

                <div>
					<h4> Total Cost: <?php $TotCost= $allTot + $allTot*0.14 + $delcharge; echo $TotCost, " EGP";?></h4>
                </div>
                <div>           
                  <a  class="btn btn-outline-secondary">Status: <?php echo $subarray["status"];?></a>
                </div>

                
                <form class="" method="post" action="">
                	<div class="justify-content-between align-items-center">

                    <div class="form-group container-login100-form-btn m-t-32 col">
	                	<input  name="<?php echo $upo;?>"  type = "submit" class="login100-form-btn" value = "Delivered">
	                </div>

	
                	<div class="form-group container-login100-form-btn m-t-32 col">
		                <input  name="<?php echo $can;?>"  type = "submit" class="login100-form-btn btn-danger" value = "Cancel">
                	</div>

                	</div>
                </form>
                
                </div>
			</div>
		</div>
    
    <?php } endforeach; ?>


	</div>
	
</div>



<div class="container-fluid padding">
	<div class="row welcome text-center">
		<div class="col-12">
			<h1 class="display-4">Orders History</h1>
		</div>
		<hr>
	</div>
</div>



<div class="container-fluid padding">
	<div class="row padding">
	
    <?php $cnti = 1; foreach($orArr as $subarray): 
        if($subarray["status"] == "Cancelled" || $subarray["status"] == "Delivered")
        {
            $delcharge = 0;

            $query5 = "SELECT ci.*, i.item_name, i.description AS itdes ,ic.description AS itcustom ,ic.price from `cart_item` ci, `item` i, `item_custom` ic WHERE ci.username = '".$subarray["username"]."' AND ci.cartId = '".$subarray["cartId"]."'  AND ic.rId = ci.rId AND ic.menu = ci.menu AND ic.itemId = ci.itemId AND ic.customId = ci.customId AND i.itemId = ci.itemId AND i.rId = ci.rId AND i.menu = ci.menu"; 
            //$pre_query = mysqli_real_escape_string($conn,$query);
            $ses_sql = mysqli_query($conn, $query5); 
        
            $cartArr = [];
            while($row = mysqli_fetch_assoc($ses_sql)) 
            {
                if($row["deleted"] == 0)
                    $cartArr[]=$row;
            }      
            $forpromoX = $subarray["promocode"];
            if(is_null($forpromoX) ||$forpromoX=="x1b2v1z4" )
            {
                $disc = 0;
            }
            else
            {
            $promoquery2 = "SELECT * from `promocode` p WHERE p.promoId = '".$forpromoX."'"; 
            //$pre_query = mysqli_real_escape_string($conn,$query);
            $ses_sql = mysqli_query($conn, $promoquery2); 
        
            $promoArr2;
            while($row = mysqli_fetch_assoc($ses_sql)) 
            {
                    $promoArr2=$row;
            }
            if(is_null($promoArr2) || $promoArr2 == "")
            {$disc = 0;} 
            else 
            {$disc = $promoArr2["discount"];}
            }

            $query3 = "SELECT * from `usr_address` where username = '".$subarray["username"]."' AND addressID= '".$subarray["addressID"]."' LIMIT 1"; 
            $ses_sql = mysqli_query($conn, $query3); 
            
            $thisaddArr;
            while($row = mysqli_fetch_assoc($ses_sql)) 	
            {
                $thisaddArr=$row;
            }
            $userinfoquery3 = "SELECT * from `usr` where username = '".$subarray["username"]."' LIMIT 1"; 
            $ses_sql = mysqli_query($conn, $userinfoquery3); 
            
            $userinfoArr;
            while($row = mysqli_fetch_assoc($ses_sql)) 	
            {
                $userinfoArr=$row;
            }

            if(!is_null($thisaddArr))
            { 
                $forcityX = $thisaddArr["city"];
                $forareaX = $thisaddArr["area_name"];
    
            $forcartX = $subarray["cartId"];
            $queryX = "SELECT DISTINCT rId from `cart_item` where username = '".$subarray["username"]."' AND cartId= '".$forcartX."' LIMIT 1"; 
            $ses_sql = mysqli_query($conn, $queryX); 
            
            $thisrestArr;
            while($row = mysqli_fetch_assoc($ses_sql)) 	
            {
                $thisrestArr=$row;
            }

            $forrestX = $thisrestArr["rId"];

                $query4 = "SELECT * from  `branch_darea` where rId = '".$forrestX."' and city = '".$forcityX."' and area_name ='".$forareaX."' ORDER BY delivery_charge LIMIT 1"; 
                $ses_sql = mysqli_query($conn, $query4); 
            
                while($row = mysqli_fetch_assoc($ses_sql)) 	
                {
                        $delArr =$row;
                }
                $delcharge = $delArr["delivery_charge"];
            }


        ?>
    <div class="col-md-4">
			<div class="card">
				<div class="card-body">
                <h4 class="card-title">Order <?php echo $cnti; $cnti = $cnti+1;?></h4>				
                <ul class="list-group">
  			
                <?php $allTot= 0; foreach($cartArr as $smarr): ?>
                <a  class="list-group-item list-group-item-action">
                  <div><h4 class = "d-flex justify-content-between align-items-center"><?php echo $smarr["item_name"];?> <span class="badge badge-primary badge-pill"><?php $tot = $smarr["price"]*$smarr["cnt"]; $allTot= $allTot + $tot; echo $tot, "EGP";?></span></h3>
                  </div>
                  <br>
                  <div>
                  <p> Number of items: <?php echo $smarr["cnt"];?></p>
                  </div>
                  <div>
                  <p> Item Description: <?php echo $smarr["itdes"];?></p>
                  </div>
                  <div>
                  <p> Custom Description: <?php echo $smarr["itcustom"];?></p>
                  </div>
                  <div>
                  <p> Special Customization: <?php echo $smarr["customization"];?></p>
                  </div>
              </a>
              <?php endforeach; ?>
              <a  class="list-group-item list-group-item-action">
                  <div><h4 class = "d-flex justify-content-between align-items-center">User Info:</h3>
                  </div>
                  <br>
                  <div>
                  <p> Name: <?php echo $userinfoArr["FName"], " ", $userinfoArr["LName"];?></p>
                  </div>
                  <div>
                  <p> Phone Number: <?php echo $userinfoArr["Mnumber"];?></p>
                  </div>
                  <div>
                  <p> City: <?php echo $thisaddArr["city"];?></p>
                  </div>
                  <div>
                  <p> Area: <?php echo $thisaddArr["area_name"];?></p>
                  </div>
                  <div>
                  <p> Address: <?php echo $thisaddArr["address"];?></p>
                  </div>
                  <div>
                  <p> Apartment Number: <?php echo $thisaddArr["apartmentNo"];?></p>
                  </div>
                  <div>
                  <p> Floor Number: <?php echo $thisaddArr["floorNo"];?></p>
                  </div>
                  <div>
                  <p> Extra Comments: <?php echo $thisaddArr["comment"];?></p>
                  </div>
                  </a>
              </ul>
              <div>
                <h4> Initial Total: <?php  echo $allTot; ?></h4>
               </div>
                     
              <div>
                <h4> After Discount: <?php $allTot = $allTot- $allTot*$disc; echo $allTot; ?></h4>
               </div>
                
                <div>
					<h4> Taxes 14%: <?php echo $allTot*0.14, " EGP";?></h4>
				</div>
                
                <div>
                    <h4> Delivery Cost: <?php echo $delcharge;?></h4>
				</div>

                <div>
					<h4> Total Cost: <?php $TotCost= $allTot + $allTot*0.14 + $delcharge; echo $TotCost, " EGP";?></h4>
                </div>
                <div>           
                  <a  class="btn btn-outline-secondary">Status: <?php echo $subarray["status"];?></a>
                </div>

                
                
                </div>
			</div>
		</div>
    
    <?php } endforeach; ?>


	</div>
	
</div>



<?php endif;?>

</body>
</html>
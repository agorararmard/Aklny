
<?php

session_start(); 
$conn = mysqli_connect("localhost", "root", "", "db_proj"); 
$userX = $_SESSION['login_user'];    


$query1 = "SELECT * from `ordr` where username = '".$userX."'"; 
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
	<title>List Of Addresses</title>
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
			<h1 class="display-4">Here Are Your Orders</h1>
		</div>
		<hr>
	</div>
</div>



<?php if(count($orArr) > 0):?>



<div class="container-fluid padding">
	<div class="row padding">
	
    <?php $cnti = 1; foreach($orArr as $subarray): 
        if($subarray["status"] != "Cancelled" && $subarray["status"] != "Delivered")
        {
            $delcharge = 0;

            $query5 = "SELECT ci.*, i.item_name, i.description AS itdes ,ic.description AS itcustom ,ic.price from `cart_item` ci, `item` i, `item_custom` ic WHERE ci.username = '".$userX."' AND ci.cartId = '".$subarray["cartId"]."'  AND ic.rId = ci.rId AND ic.menu = ci.menu AND ic.itemId = ci.itemId AND ic.customId = ci.customId AND i.itemId = ci.itemId AND i.rId = ci.rId AND i.menu = ci.menu"; 
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

            $query3 = "SELECT * from `usr_address` where username = '".$userX."' AND addressID= '".$subarray["addressID"]."' LIMIT 1"; 
            $ses_sql = mysqli_query($conn, $query3); 
            
            $thisaddArr;
            while($row = mysqli_fetch_assoc($ses_sql)) 	
            {
                $thisaddArr=$row;
            }
            if(!is_null($thisaddArr))
            { 
                $forcityX = $thisaddArr["city"];
                $forareaX = $thisaddArr["area_name"];
    
            $forcartX = $subarray["cartId"];
            $queryX = "SELECT DISTINCT rId from `cart_item` where username = '".$userX."' AND cartId= '".$forcartX."' LIMIT 1"; 
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

<div class="container-fluid padding">
	<div class="row welcome text-center">
		<div class="col-12">
			<h1 class="display-4">Here Are Your Previous Orders</h1>
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
            $query5 = "SELECT ci.*, i.item_name, i.description AS itdes ,ic.description AS itcustom ,ic.price from `cart_item` ci, `item` i, `item_custom` ic WHERE ci.username = '".$userX."' AND ci.cartId = '".$subarray["cartId"]."'  AND ic.rId = ci.rId AND ic.menu = ci.menu AND ic.itemId = ci.itemId AND ic.customId = ci.customId AND i.itemId = ci.itemId AND i.rId = ci.rId AND i.menu = ci.menu"; 
            //$pre_query = mysqli_real_escape_string($conn,$query);
            $ses_sql = mysqli_query($conn, $query5); 
        
            $cartArr = [];
            while($row = mysqli_fetch_assoc($ses_sql)) 
            {
                if($row["deleted"] == 0)
                    $cartArr[]=$row;
            }     

            $forpromoX = $subarray["promocode"];
            if(is_null($forpromoX)||$forpromoX=="x1b2v1z4")
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
            if(is_null($promoArr2) ){$disc = 0;} else {$disc = $promoArr2["discount"];}
            }

            $query3 = "SELECT * from `usr_address` where username = '".$userX."' AND addressID= '".$subarray["addressID"]."' LIMIT 1"; 
            $ses_sql = mysqli_query($conn, $query3); 
            
            $thisaddArr;
            while($row = mysqli_fetch_assoc($ses_sql)) 	
            {
                $thisaddArr=$row;
            }
            if(!is_null($thisaddArr))
            { 
                $forcityX = $thisaddArr["city"];
                $forareaX = $thisaddArr["area_name"];
    
            $forcartX = $subarray["cartId"];
            $queryX = "SELECT DISTINCT rId from `cart_item` where username = '".$userX."' AND cartId= '".$forcartX."' LIMIT 1"; 
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
  			
                <?php $allTot = 0; foreach($cartArr as $smarr): ?>
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
        <a  class="btn btn-outline-secondary">Status: <?php echo $subarray["status"];?></a>
				</div>
			</div>
		</div>
    
    <?php } endforeach; ?>


	</div>
	
</div>

















<?php endif;?>

</body>
</html>
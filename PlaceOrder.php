<?php

session_start(); 
$conn = mysqli_connect("localhost", "root", "", "db_proj"); 
$TotCost = 0;
$invalidPromo = 0;
$disc = 0;
$delcharge = -1;

if($_GET)
{
	$branchX = $_GET["branch"];
    $cityX = $_GET["city"];
    $areaX = $_GET["area"];
    $restX = $_GET["rest"];
	
	$cartX = $_GET["cart"];
    $addX = $_GET["add"];
    $promoX = $_GET["promo"];

	$userX = $_SESSION['login_user'];
	
    $query1 = "SELECT * from `usr_address` ua where ua.username = '".$userX."' AND EXISTS(SELECT * from `branch_darea` bd where bd.rId = '".$restX."' and bd.bId = '".$branchX."' and bd.city=ua.city and bd.area_name= ua.area_name and bd.city = '".$cityX."' AND bd.area_name ='".$areaX."')"; 
    $ses_sql = mysqli_query($conn, $query1); 
	
    $addArr = [];
    while($row = mysqli_fetch_assoc($ses_sql)) 	
    {
        if($row["Deleted"] == 0)
	     $addArr[]=$row;
    }

	$query2 = "SELECT ci.*, i.item_name, i.description AS itdes ,ic.description AS itcustom ,ic.price from `cart_item` ci, `item` i, `item_custom` ic WHERE ci.username = '".$userX."' AND ci.cartId = '".$cartX."' AND ci.rId = '".$restX."' AND ic.rId = ci.rId AND ic.menu = ci.menu AND ic.itemId = ci.itemId AND ic.customId = ci.customId AND i.itemId = ci.itemId AND i.rId = ci.rId AND i.menu = ci.menu"; 
	//$pre_query = mysqli_real_escape_string($conn,$query);
	$ses_sql = mysqli_query($conn, $query2); 

	$cartArr = [];
	while($row = mysqli_fetch_assoc($ses_sql)) 
	{
		if($row["deleted"] == 0)
			$cartArr[]=$row;
	}

    if($addX != "x1b2v1z4")
    {
        $query3 = "SELECT * from `usr_address` where username = '".$userX."' AND addressID= '".$addX."' LIMIT 1"; 
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

            $query4 = "SELECT * from  `branch_darea` where rId = '".$restX."' and bId = '".$branchX."' and city = '".$forcityX."' and area_name ='".$forareaX."' LIMIT 1"; 
            $ses_sql = mysqli_query($conn, $query4); 
        
            while($row = mysqli_fetch_assoc($ses_sql)) 	
            {
                    $delArr =$row;
            }
            $delcharge = $delArr["delivery_charge"];
        }
    }

    if(isset($_POST["apromo"]))
	{
        $newPromo = $_POST["promo"];

        $promoquery1 = "SELECT * from `promocode_restaurant` pr WHERE pr.promoId = '".$newPromo."' AND pr.rId = '".$restX."'"; 
        //$pre_query = mysqli_real_escape_string($conn,$query);
        $ses_sql = mysqli_query($conn, $promoquery1); 
    
        $promoArr1;
        while($row = mysqli_fetch_assoc($ses_sql)) 
        {
                $promoArr1=$row;
        }
        if(is_null($promoArr1))
        {
            $invalidPromo = 1;
        }
        else
        {

            $promoquery2 = "SELECT * from `promocode` p WHERE p.promoId = '".$newPromo."' AND p.sdate <= NOW() AND p.edate >= NOW() AND p.deleted = 0"; 
            //$pre_query = mysqli_real_escape_string($conn,$query);
            $ses_sql = mysqli_query($conn, $promoquery2); 
        
            $promoArr2;
            while($row = mysqli_fetch_assoc($ses_sql)) 
            {
                    $promoArr2=$row;
            }
            if(is_null($promoArr2))
            {
                $invalidPromo = 1;
            }
            else{
                $promoquery3 = "SELECT * from `promocode_usr` pu WHERE pu.promoId = '".$newPromo."' AND pu.username = '".$userX."'"; 
                //$pre_query = mysqli_real_escape_string($conn,$query);
                $ses_sql = mysqli_query($conn, $promoquery3); 
            
                $promoArr3;
                while($row = mysqli_fetch_assoc($ses_sql)) 
                {
                        $promoArr3=$row;
                }

                if(is_null($promoArr3))
                {
                    $newtimes = 1;
                    $promoquery4 = "INSERT INTO `promocode_usr` (username, promoId, times_used) VALUES('".$userX."', '".$newPromo."','".$newtimes."')";
            
                    if( mysqli_query($conn,$promoquery4))
                    { 
                        $promoX = $newPromo;    
                        $disc = $promoArr2["discount"];
                    }
                    else
                    {
                        header("location: profile.php"); 
                    }

                }
                else
                {
                    if($promoArr3["times_used"] >= $promoArr1["times"])
                    {
                        $invalidPromo = 1;
                    }
                    else
                    {
                        $newtimes = $promoArr3["times_used"] + 1;
                        $query = "UPDATE `promocode_usr` SET times_used = '".$newtimes."' WHERE username = '".$userX."' AND promoId = '".$newPromo."'";
                
                        if( mysqli_query($conn,$query))
                        { 
                            $promoX = $newPromo;  
                            $disc = $promoArr2["discount"];  
                        }
                        else
                        {
                        header("location: Home.php"); 
                        }
                        
                    }
                }

            }
        }



    }

}
else
{	
	header("location: restaurants.php?searchval=x1b2v1z4&city=x1b2v1z4&area=x1b2v1z4&cuis=x1b2v1z4");
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
			<h1 class="display-4">Final Steps Before Checkout</h1>
		</div>
		<hr>
	</div>
</div>



<div class="container-fluid padding">
	<div class="row padding">
	
    <div class="col-md-4">
			<div class="card">
				<div class="card-body">
                <h3 class="card-title"><?php echo "Your Cart"; ?></h3>
				<ul class="list-group">
  			
				<?php $allTot=0; foreach($cartArr as $subarray): ?>
  				<a href="carteditor.php?item=<?php echo $subarray["itemId"], "&menu=",$subarray["menu"],"&rest=", $restX,"&branch=",$branchX,"&city=",$cityX,"&area=",$areaX,"&cart=",$cartX;?>" class="list-group-item list-group-item-action">
					<div><h4 class = "d-flex justify-content-between align-items-center"><?php echo $subarray["item_name"];?> <span class="badge badge-primary badge-pill"><?php $tot = $subarray["price"]*$subarray["cnt"]; $allTot=$allTot+$tot; echo $tot, "EGP";?></span></h3>
					</div>
					<br>
					<div>
					<p> Number of items: <?php echo $subarray["cnt"];?></p>
					</div>
					<div>
					<p> Item Description: <?php echo $subarray["itdes"];?></p>
					</div>
					<div>
					<p> Custom Description: <?php echo $subarray["itcustom"];?></p>
					</div>
					<div>
					<p> Special Customization: <?php echo $subarray["customization"];?></p>
					</div>
				</a>
				<?php endforeach; ?>
				</ul>
				<div>
                    <h4> After Discount: <?php $allTot = $allTot- $allTot*$disc; echo $allTot; ?></h4>
                </div>
                
                <div>
					<h4> Taxes 14%: <?php echo $allTot*0.14, " EGP";?></h4>
				</div>
                
                <div>
                    <h4> Delivery Cost: <?php if($delcharge!=-1){echo $delcharge;} else { echo "Choose Address First";}?></h4>
				</div>

                <div>
					<h4> Total Cost: <?php if($delcharge != -1){$TotCost= $allTot + $allTot*0.14 + $delArr["delivery_charge"]; echo $TotCost, " EGP";}?></h4>
				</div>
			        <a href = "<?php if($addX == "x1b2v1z4"){ echo "#"; } else {echo "order.php?city=",$thisaddArr["city"],"&area=",$thisaddArr["area_name"],"&cart=",$cartX,"&add=", $addX,"&promo=",$promoX;}?>" class="btn btn-primary">Place Order</a>
				</div>
			</div>
		</div>

        <form class="" method="post" action="">
    	<div class="justify-content-between align-items-center">
		
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
                <p class="lead">Promocode:</p>
            </div>

            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Qxz1v1" name="promo" id = "promo">
            </div>
            <?php if($invalidPromo == 1):?><div><small id="addHelpBlock" class="form-text text-danger">
                 Invalid Promocode
             </small></div> <?php endif;?>

            <div class="form-group container-login100-form-btn m-t-32 col">
                <input  name="apromo"  type = "submit" class="login100-form-btn" value = "Add Promocode">
            </div>
    	    </div>
         </form>

         <?php foreach($addArr as $subarray): if($subarray["addressID"] == $addX):?>
            <div class="col-md-4">
			<div class="card">
				<div class="card-body">
                <h4 class="card-title"> Current Delivery Address</h4>				
                	    <p>City: <?php echo $subarray["city"];?></p>
					    <br>
                        <p>Area: <?php echo $subarray["area_name"];?></p>
					    <br>
                        <p>Address: <?php echo $subarray["address"];?></p>
					    <br>
                        <p>Apartment Number: <?php echo $subarray["apartmentNo"];?></p>
					    <br>
                        <p>Floor Number: <?php echo $subarray["floorNo"];?></p>
					    <br>
                        <p>Extra Comments: <?php echo $subarray["comment"];?></p>
					    
        <a href="edit_address.php?city=<?php echo $subarray["city"],"&area=",$subarray["area_name"],"&addId=",$subarray["addressID"];?>" class="btn btn-outline-secondary">Edit Address</a>
				</div>
			</div>
		</div>

<?php endif; endforeach; ?>


         <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
            <p class="lead">List of Delivery Supported Addresses:</p>
        </div>
        <button class="btn btn-danger btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Select Address
        </button>
        <div class="dropdown-menu">
            <?php foreach($addArr as $subarray): ?>
              <a class="dropdown-item" href="PlaceOrder.php?promo=<?php echo $promoX,"&add=",$subarray["addressID"],"&city=",$cityX,"&area=",$areaX,"&branch=", $branchX, "&rest=", $restX,"&cart=", $cartX;?>"> <?php echo $subarray["city"],", ", $subarray["area_name"],", ", $subarray["address"]; ?> </a>
            <?php endforeach; ?>  
        </div>

        



	</div>
</div>


<div>
    <button type ="button" class="btn btn-primary btn-lg" onclick="location.href='add_address.php?city=x1b2v1z4&area=x1b2v1z4'">Add Address</button>
</div>

</body>
</html>


<?php

session_start(); 
$conn = mysqli_connect("localhost", "root", "", "db_proj"); 

$TotCost=0;

if($_GET)
{
	$branchX = $_GET["branch"];
    $cityX = $_GET["city"];
    $areaX = $_GET["area"];
    $restX = $_GET["rest"];
	$menuX = $_GET["menu"];
	$cartX = $_GET["cart"];
	
	$userX = $_SESSION['login_user'];
	
	if($cartX == "x1b2v1z4")
	{
		header("location: cart_creator.php?menu=$menuX&rest=$restX&branch=$branchX&city=$cityX&area=$areaX&cart=$cartX");
	}

    $query1 = "SELECT * from `restaurant` WHERE rId = '".$restX."' LIMIT 1"; 
	//$pre_query = mysqli_real_escape_string($conn,$query);
	$ses_sql = mysqli_query($conn, $query1); 

	while($row = mysqli_fetch_assoc($ses_sql)) 
	{
		if($row["active"] == 1)
            $mainArr=$row;
        else
            header("location: restaurants.php?searchval=x1b2v1z4&city=x1b2v1z4&area=x1b2v1z4&cuis=x1b2v1z4");
    }
    

    $query2 = "SELECT * from `restaurant_branch` WHERE rId = '".$restX."' AND bId ='".$branchX."' AND city = '".$cityX."' AND area_name = '".$areaX."' LIMIT 1"; 
	//$pre_query = mysqli_real_escape_string($conn,$query);
	$ses_sql = mysqli_query($conn, $query2); 

	while($row = mysqli_fetch_assoc($ses_sql)) 
	{
		if($row["deleted"] == 0)
            $branchArr=$row;
        else
            header("location: restaurants.php?searchval=x1b2v1z4&city=x1b2v1z4&area=x1b2v1z4&cuis=x1b2v1z4");
    }


    $query3 = "SELECT * from `menu` WHERE rId = '".$restX."'"; 
	//$pre_query = mysqli_real_escape_string($conn,$query);
	$ses_sql = mysqli_query($conn, $query3); 

	$menuArr = [];
	while($row = mysqli_fetch_assoc($ses_sql)) 
	{
		if($row["deleted"] == 0)
            $menuArr[]=$row;
    }
    
    if($menuX != "x1b2v1z4")
    {
        $query4 = "SELECT i.*,MIN(ic.price) AS MinPrice, MAX(ic.price) AS MaxPrice from `item` i, `item_custom` ic WHERE i.rId = '".$restX."' AND i.menu = '".$menuX."' AND i.rId = ic.rId AND i.menu = ic.menu AND i.itemId = ic.itemId GROUP BY i.rId, i.menu, i.itemId"; 
        //$pre_query = mysqli_real_escape_string($conn,$query);
        $ses_sql = mysqli_query($conn, $query4); 
    
        $itemArr = [];
        while($row = mysqli_fetch_assoc($ses_sql)) 
        {
            if($row["deleted"] == 0)
                $itemArr[]=$row;
        }
	}
	

	$query5 = "SELECT ci.*, i.item_name, i.description AS itdes ,ic.description AS itcustom ,ic.price from `cart_item` ci, `item` i, `item_custom` ic WHERE ci.username = '".$userX."' AND ci.cartId = '".$cartX."' AND ci.rId = '".$restX."' AND ic.rId = ci.rId AND ic.menu = ci.menu AND ic.itemId = ci.itemId AND ic.customId = ci.customId AND i.itemId = ci.itemId AND i.rId = ci.rId AND i.menu = ci.menu"; 
	//$pre_query = mysqli_real_escape_string($conn,$query);
	$ses_sql = mysqli_query($conn, $query5); 

	$cartArr = [];
	while($row = mysqli_fetch_assoc($ses_sql)) 
	{
		if($row["deleted"] == 0)
			$cartArr[]=$row;
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
	<title>Order from <?php echo $mainArr["rname"];?></title>
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
			<h1 class="display-4"><?php echo $mainArr["rname"];?></h1>
		</div>
		<hr>
	</div>
</div>

<div class="container-fluid padding">
	<div class="row padding">
		<div class="col-md-12 col-lg-6">
			<h2>The <?php echo $areaX, ", ", $cityX, " Branch";?></h2>
            <br>
            <br>
            <h5>Phone Number: <?php echo $mainArr["mnumber"];?></h5>
			<br>
			<h5>Address: <?php echo $branchArr["address"];?></h5>
			<br>
			<h5>Opening Hours: <?php echo $branchArr["opening_Hours"];?></h5>
            <br>
            <br>
            <br>
            <button class="btn btn-danger btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Select Menu
            </button>
            <div class="dropdown-menu">
            <?php foreach($menuArr as $subarray): ?>
                 <a class="dropdown-item" href="restaurant.php?menu=<?php echo $subarray["menu"],"&rest=", $restX,"&branch=",$branchX,"&city=",$cityX,"&area=",$areaX,"&cart=",$cartX;?>"> <?php echo $subarray["menu"]; ?> </a>
            <?php endforeach; ?>  </div>
		</div>
		<div class="col-lg-6">
			<img src="<?php if(is_null ($mainArr["imgurl"])) {echo  "img\home1.jpg";}else{ echo $mainArr["imgurl"];}?>" class="img-fluid">
		</div>
	</div>
</div>


<div class="container-fluid padding">
	<div class="row welcome text-center">
		<div class="col-12">
			<h1 class="display-4">Your Cart</h1>
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
					<h4> Taxes 14%: <?php echo $allTot*0.14, " EGP";?></h4>
				</div>
				<div>
					<h4> Total Cost: <?php $TotCost= $allTot + $allTot*0.14; echo $TotCost, " EGP";?></h4>
				</div>
			        <a href = "PlaceOrder.php?promo=x1b2v1z4&add=x1b2v1z4&city=<?php echo $cityX,"&area=",$areaX,"&branch=", $branchX, "&rest=", $restX,"&cart=", $cartX;?>" class="btn btn-primary">Proceed To Checkout</a>
				</div>
			</div>
		</div>
	</div>
</div>





<div class="container-fluid padding">
	<div class="row welcome text-center">
		<div class="col-12">
			<h1 class="display-4">Start Your Order</h1>
		</div>
		<hr>
	</div>
</div>

<?php if($menuX != "x1b2v1z4"):?>
<div class="list-group">
<?php foreach($itemArr as $subarray): ?>
  <a href="item.php?item=<?php echo $subarray["itemId"], "&menu=",$menuX,"&rest=", $restX,"&branch=",$branchX,"&city=",$cityX,"&area=",$areaX,"&cart=",$cartX;?>" class="list-group-item list-group-item-action">
	<h3 class = "d-flex justify-content-between align-items-center"><?php echo $subarray["item_name"];?> <span class="badge badge-primary badge-pill"><?php echo $subarray["MinPrice"],"-",$subarray["MaxPrice"];?></span></h3>
	<p><?php echo $subarray["description"];?></p>
  </a>
  <?php endforeach; ?>
 </div>
<?php endif;?>

</body>
</html>
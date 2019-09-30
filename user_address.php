
<?php

session_start(); 
$conn = mysqli_connect("localhost", "root", "", "db_proj"); 
$userX = $_SESSION['login_user'];    

$query1 = "SELECT * from `usr_address` where username = '".$userX."'"; 
$ses_sql = mysqli_query($conn, $query1); 
	
$addArr = [];
while($row = mysqli_fetch_assoc($ses_sql)) 	
{
    if($row["Deleted"] == 0)
	    $addArr[]=$row;
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
			<h1 class="display-4">Here Are Your Registered Addresses</h1>
		</div>
		<hr>
	</div>
</div>



<?php if(count($addArr) > 0):?>
<div class="container-fluid padding">
	<div class="row padding">
	
    <?php $cnti = 1; foreach($addArr as $subarray): ?>
    <div class="col-md-4">
			<div class="card">
				<div class="card-body">
                <h4 class="card-title">Address <?php echo $cnti; $cnti = $cnti+1;?></h4>				
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

    <?php endforeach; ?>


	</div>
	
</div>
<?php endif;?>


<div>
    <button type ="button" class="btn btn-primary btn-lg" onclick="location.href='add_address.php?city=x1b2v1z4&area=x1b2v1z4'">Add Address</button>
</div>

</body>
</html>
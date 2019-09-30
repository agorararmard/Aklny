
<?php
			
$conn = mysqli_connect("localhost", "root", "", "db_proj"); 
$userX = $_SESSION['login_user'];    

            $userinfoquery15 = "SELECT * from `usr` where username = '".$userX."' LIMIT 1"; 
            $ses_sql = mysqli_query($conn, $userinfoquery15); 
            
            $userinfoArr;
            while($row = mysqli_fetch_assoc($ses_sql)) 	
            {
                $userinfoArr=$row;
            }

?>


<!-- Navigation -->
<nav class ="navbar navbar-expand-md navbar-light bg-light sticky-top">
<div class ="container-fluid">
	<a class="navbar-brand" href="#"></a>
	<button class ="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarResponsive">
		<ul class="navbar-nav ml-auto">
			<?php if($userinfoArr["usertype"] == 1){?>
			<li class="nav-item">
				<a class = "nav-link" href="staff_carts.php">Staff Orders</a>
			</li>	
			<?php }else if($userinfoArr["usertype"] == 2):?>
			<li class="nav-item">
				<a class = "nav-link" href="adminViewRest.php">Admin Panel</a>
			</li>
			<?php endif;?>
			<li class="nav-item">
				<a class = "nav-link" href="Home.php">Home</a>
			</li>
			<li class="nav-item">
				<a class = "nav-link" href="user_carts.php">Your Orders</a>
			</li>
			
			<li class="nav-item">
				<a class = "nav-link" href="profile.php">Profile</a>
			</li>
			<li class="nav-item">
				<a class = "nav-link" href="restaurants.php">Order</a>
			</li>
			<li class="nav-item">
				<a class = "nav-link" href="#">Team</a>
			</li>
			<li class="nav-item">
				<a class = "nav-link" href="logout">Logout</a>
			</li>
		</ul>
	</div>
</div>
</nav>

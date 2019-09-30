<!DOCTYPE html>
<html lang="en">
<link rel="icon" type="image/png" href="img/logo1.png"/>  <!--for icon-->

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Aklny</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
	<link href="style.css" rel="stylesheet">
</head>
<body>

<?php include "navHead.php";?>

<!--- Image Slider -->
<div id="slides" class="carousel slide" data-ride="carousel">
<ul class="carousel-indicators">
	<li data-target="#slides" data-slide-to="0" class = "active"></li>
	
	<li data-target="#slides" data-slide-to="1"></li>
	
	<li data-target="#slides" data-slide-to="2"></li>	
</ul>
<div class ="carousel-inner">
	<div class ="carousel-item active">
		<img src="img/home1.jpg">
		<div class= "carousel-caption">
			<h1 class="display-2">Aklny</h1>
			<h3>Complete Food Ordering Service</h3>
			<button type="button" class="btn btn-outline-light btn-lg" onclick="location.href='index.php'">Sign In</button>
			<button type ="button" class="btn btn-primary btn-lg" onclick="location.href='register.php'">Get Started</button>
		</div>
	</div>
	
	<div class ="carousel-item">
		<img src="img/home2.jpg">
	</div>
		
	<div class ="carousel-item">
		<img src="img/home3.png">
	</div>
</div>
</div>

<!--- Jumbotron -->
<div class="container-fluid">
	<div class="row jumbotron">
		<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
			<p class="lead">Here we have some words written that we can use later so Hi ya amor 3aml eh delw2t?</p>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-2">
				<a href="#"><button type="button" class="btn btn-outline-secondary btn-lg">Web Hosting</button></button></a>
		</div>
	</div>
</div>

<!--- Welcome Section -->
<div class="container-fluid padding">
	<div class="row welcome text-center">
		<div class="col-12">
			<h1 class="display-4">Built with ease.</h1>
		</div>
		<hr>
		<div class="col-12">
			<p class="lead">some words written kuasf werwerqrqwer werqwer wsdf a s f that's it</p>
		</div>
	</div>
</div>

<!--- Three Column Section -->
<div class ="container-fluid padding">
	<div class ="row text-center padding">
		<div class="col-xs-12 col-sm-6 col-md-4">
			<i class="fas fa-code"></i>
			<h3>HTML5</h3>
			<p>some words about HTML</p>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-4">
			<i class="fas fa-bold"></i>
			<h3>Bootstrap</h3>
			<p>some words about bootstrap</p>
		</div>
		<div class="col-sm-12 col-md-4">
			<i class="fab fa-css3"></i>
			<h3>CSS3</h3>
			<p>some words about CSS</p>
		</div>
	</div>
	<hr class="my-4">

</div>

<!--- Two Column Section -->
<div class="container-fluid padding">
	<div class="row padding">
		<div class="col-md-12 col-lg-6">
			<h2>If you build it...</h2>
			<p>First paragraph saying stuff and things</p>
			
			<p>Second paragraph saying stuff and things</p>
			
			<p>third paragraph saying stuff and things</p>
			<br>
			<a href="#" class="btn btn-primary">Learn More</a>
		</div>
		<div class="col-lg-6">
			<img src="img/desk.png" class="img-fluid">
		</div>
	</div>
</div>

<!--- Fixed background -->


<!--- Emoji Section -->

  
<!--- Meet the team -->
<div class="container-fluid padding">
	<div class="row welcome text-center">
		<div class="col-12">
			<h1 class="display-4">Meet The Team</h1>
		</div>
		<hr>
	</div>
</div>

<!--- Cards -->
<div class="container-fluid padding">
	<div class="row padding">
		<div class="col-md-4">
			<div class="card">
				<img class="card-img-top" src="img/team1.png">
				<div class="card-body">
					<h4 class="card-title">John Doe</h4>
					<p>He's just another employee</p>
					<a href="#" class="btn btn-outline-secondary">See Profile</a>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card">
				<img class="card-img-top" src="img/team2.png">
				<div class="card-body">
					<h4 class="card-title">Madeha Doe</h4>
					<p>She's just another employee</p>
					<a href="#" class="btn btn-outline-secondary">See Profile</a>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card">
				<img class="card-img-top" src="img/team3.png">
				<div class="card-body">
					<h4 class="card-title">Mostafa Jo</h4>
					<p>He's just another employee other than John</p>
					<a href="#" class="btn btn-outline-secondary">See Profile</a>
				</div>
			</div>
		</div>
	</div>
</div>

<!--- Two Column Section -->


<!--- Connect -->


<!--- Footer -->

   
</body>
</html>




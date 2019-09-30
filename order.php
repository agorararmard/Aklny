<?php

session_start(); 
$conn = mysqli_connect("localhost", "root", "", "db_proj"); 

if($_GET)
{
	$cityX = $_GET["city"];
    $areaX = $_GET["area"];
   
	$cartX = $_GET["cart"];
    $addX = $_GET["add"];
    $promoX = $_GET["promo"];
    if($promoX == "x1b2v1z4")
    {
        $promoX = NULL;
    }

	$userX = $_SESSION['login_user'];
    
    $orId = ((string)mt_rand());
    $orId  .= ((string)mt_rand());
    $orId  .= ((string)mt_rand());
    $orId  .= ((string)mt_rand());
    $orId  .= ((string)mt_rand());

    $query1 = "INSERT INTO `ordr` (username, cartId,orderId,city,area_name,addressID,promocode,status, deleted) VALUES('".$userX."', '".$cartX."','".$orId."','".$cityX."','".$areaX."','".$addX."','".$promoX."','Pending Approval',0)";
            
    if( mysqli_query($conn,$query1))
    { 
    
    }
    else
    {
        header("location: profile.php"); 
    }
    header("location: Home.php");
}
?>

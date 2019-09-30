<?php

session_start(); 
$conn = mysqli_connect("localhost", "root", "", "db_proj"); 
if($_GET)
{
	$branchX = $_GET["branch"];
    $cityX = $_GET["city"];
    $areaX = $_GET["area"];
    $restX = $_GET["rest"];
    $menuX = $_GET["menu"];
    $cartX = $_GET["cart"];
    $userX = $_SESSION['login_user'];
    
    $query1 = "SELECT uc.* FROM `usr_cart` uc, `cart_item` ci
    WHERE uc.username = ci.username
    AND uc.cartId = ci.cartId
    AND ci.username = '".$userX."'
    AND ci.rId ='".$restX."'
    AND NOT EXISTS(
        SELECT * FROM `ordr` o
	    WHERE uc.username = o.username
	    AND uc.cartId = o.cartId
    ) LIMIT 1"; 

	//$pre_query = mysqli_real_escape_string($conn,$query);
	$ses_sql = mysqli_query($conn, $query1); 
    $pcartArr;
	while($row = mysqli_fetch_assoc($ses_sql)) 
	{
		if($row["deleted"] == 0)
            $pcartArr = $row;
    }
    
    if(is_null($pcartArr))
    {
        $cartX = ((string)mt_rand());
        $cartX .= ((string)mt_rand());
        $cartX .= ((string)mt_rand());

        $query = "INSERT INTO usr_cart (`username`, `cartId`, `deleted`) VALUES ('".$userX."', '".$cartX."', 0)";
       
        if( mysqli_query($conn,$query))
        { 
            
        }
        else
        {
          header("location: Home.php"); 
        }   
    }
    else{
        $cartX = $pcartArr["cartId"];
    }
    
    header("location: restaurant.php?menu=$menuX&rest=$restX&branch=$branchX&city=$cityX&area=$areaX&cart=$cartX");
}

mysqli_close($conn); // Closing Connection 
?>
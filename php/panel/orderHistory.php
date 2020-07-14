<?php 
	
	require_once "../database/lberDataOperation.php";


	if($_SERVER["REQUEST_METHOD"] == "GET")
	{
		if(isset($_COOKIE["token"]))
		{
			$token = $_COOKIE["token"];
			getOrderHistory($token, $_POST["userType"]);
		}
		else
		{
			echo "invalidate log in";
		}
			
	}	
 ?>
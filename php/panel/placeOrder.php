<?php 
	
	require_once "../database/lberDataOperation.php";
	require_once "../form/formUtil.php";

	if($_SERVER["REQUEST_METHOD"] == "GET")
	{
		if(checkPlaceOrder())
		{
			if(isset($_COOKIE["token"]))
			{
				$token = $_COOKIE["token"];
				placeOrder($token, $_POST);
			}
			else
			{
				echo "invalidate log in";
			}
		}
			
	}	
 ?>
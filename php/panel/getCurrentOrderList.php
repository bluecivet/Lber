<?php 
	
	require_once "../database/lberDatabaseOperation.php";

	if($_SERVER["REQUEST_METHOD"] == "GET")
	{
		if(isset($_COOKIE["token"]))
		{
			$token = $_COOKIE["token"];
			if(isset($_GET["city"]))
				getCurrentOrderList($token, "driver", $_GET["city"]);

		}
		else
		{
			echo "invalidate log in";
		}
		
	}	
 ?>
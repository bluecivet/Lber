<?php 
	
	require_once "../database/lberDatabaseOperation.php";

	if($_SERVER["REQUEST_METHOD"] == "GET")
	{
		if(isset($_COOKIE["token"]))
		{
			$token = $_COOKIE["token"];
			generalSetup("user", $token);

		}
		else
		{
			echo "invalidate log in";
		}
		
	}	
 ?>
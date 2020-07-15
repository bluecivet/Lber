<?php 
	
	require_once "../database/lberDatabaseOperation.php";


	if($_SERVER["REQUEST_METHOD"] == "GET")
	{
		if(isset($_COOKIE["token"]))
		{
			$token = $_COOKIE["token"];
			if(isset($_GET["userType"]))
			getCurrentOrder($token, $_GET["userType"]);
		}
		else
		{
			echo "invalidate log in";
		}
			
	}	
 ?>
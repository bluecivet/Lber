<?php 
	
	require_once "../database/lberDatabaseOperation.php";


	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if(isset($_COOKIE["token"]))
		{
			$token = $_COOKIE["token"];
			if(isset($_POST["orderId"]) && isset($_POST["userType"]))
				acceptOrder($token, $_POST["userType"], $_POST["orderId"]);
		}
		else
		{
			echo "invalidate log in";
		}
			
	}	
 ?>
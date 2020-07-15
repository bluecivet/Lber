<?php 
	
	require_once "../database/lberDatabaseOperation.php";
	require_once "../form/formUtil.php";

	if($_SERVER["REQUEST_METHOD"] == "GET")
	{
		if(checkAddingPoint())
		{
			if(isset($_COOKIE["token"]))
			{
				$token = $_COOKIE["token"];
				addPoint($token, $_POST["userType"], $_POST);
			}
			else
			{
				echo "invalidate log in";
			}
		}
			
	}	
 ?>
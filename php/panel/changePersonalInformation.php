<?php 
	
	require_once "../database/lberDataOperation.php";
	require_once "../form/formUtil.php";

	if($_SERVER["REQUEST_METHOD"] == "GET")
	{
		if(checkPerosonalInformation())
		{
			if(isset($_COOKIE["token"]))
			{
				$token = $_COOKIE["token"];
				if($_POST["userType"] == "user")
					changeUserPersonalInformation($token, $_POST)
				else if($_POST["userType"] == "driver")
					changeDriverPersonalInformation($token, $_POST);
			}
			else
			{
				echo "invalidate log in";
			}
		}
			
	}	
 ?>
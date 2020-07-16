<?php 
	
	require_once "../database/lberDatabaseOperation.php";
	require_once "../form/formUtil.php";

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if(checkPerosonalInformation())
		{
			if(isset($_COOKIE["token"]))
			{
				$token = $_COOKIE["token"];
				if($_POST["userType"] == "user")
					changeUserPersonalInformation($token, $_POST);
				elseif($_POST["userType"] == "driver")
					changeDriverPersonalInformation($token, $_POST);
			}
			else
			{
				echo "invalidate log in";
			}
		}
			
	}	
 ?>
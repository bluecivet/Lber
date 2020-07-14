<?php 
	require_once "../database/lberDatabaseOperation.php";
	require_once "../form/formUtil.php";

	//var_dump($_POST);
	// echo endl;
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		// check the form are filled and we have everything that is need 
		if(checkLoginForm("user"))
		{
			// if everything is seted then procee to database
			userLogin($_POST);
		}
	}
	else
	{
		echo "can not get post requet";
	}


 ?>
<?php 
	require_once "../database/lberDatabaseOperation.php";
	require_once "../form/formUtil.php";

	var_dump($_POST);
	echo endl;

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if(checkSigninForm("driver"))
		{
			// if everything is seted then procee to database
			echo "enter user sign in function" . endl;
			driverSignin($_POST);
		}

	}
	else
	{
		echo "can not get post requet";
	}


	// example request

	// array(11) { ["hasAccount"]=> string(2) "no" ["firstName"]=> string(7) "Zhilong" ["lastName"]=> string(3) "Gan" ["age"]=> string(2) "20" ["birthDate"]=> string(10) "2020-07-05" ["signinDriverName"]=> string(0) "" ["email"]=> string(16) "223380934@qq.com" ["phone"]=> string(10) "7783613313" ["user"]=> string(3) "Ben" ["password"]=> string(6) "123456" ["passwordConfirm"]=> string(6) "123456" }


	// array(7) { ["hasAccount"]=> string(3) "yes" ["signinDriverName"]=> string(4) "dsaf" ["email"]=> string(16) "223380934@qq.com" ["phone"]=> string(10) "7783613313" ["user"]=> string(3) "Ben" ["password"]=> string(6) "123456" ["passwordConfirm"]=> string(6) "123456" }
 ?>
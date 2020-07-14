<?php 
	function checkSigninForm($signinType)
	{
		// check the form are filled and we have everything that is need 
		if(!isset($_POST["hasAccount"]))
		{
			echo "can not find hasAccount";
			return false;
		}
		
		$hasAccount = $_POST["hasAccount"];

		if($hasAccount == "no")	// check personal information
		{
			if(!isset($_POST["firstName"]) || !isset($_POST["lastName"]) || !isset($_POST["age"]) || !isset($_POST["birthDate"]))
			{
				echo "can enough personal information";
				return false;
			}
		}

		if($hasAccount == "yes")
		{
			if($signinType == "driver" && !isset($_POST["signinUserName"]))
			{
				echo "missing signin user name";
				return false;
			}
			else if($signinType == "user" && !isset($_POST["signinDriverName"]))
			{
				echo "missing signin driver name";
				return false;
			}
		}

		if(!checkPerosonalInformation())
			return false;

		return true;
	}



	function checkLoginForm()
	{
		if(!isset($_POST["user"]))
		{
			echo "missing user name";
			return false;
		}

		if(!isset($_POST["password"]))
		{
			echo "missing password";
			return false;
		}
		return true;
	}



	function checkPlaceOrder()
	{
		if(!isset($_POST["carrying"]) || !isset($_POST["deliveryDate"]) )
		{
			echo "missing information";
			return false;
		}

		if(!isset($_POST["fromCity"]) || !isset($_POST["fromAddress"]) || !isset($_POST["toCity"]) || !isset($_POST["toAddress"]))
		{
			echo "missing addresses";
			return false;
		}

		return true;
	}



	function checkPerosonalInformation()
	{
		if(!isset($_POST["email"]) || !isset($_POST["phone"]) || !isset($_POST["user"]) || !isset($_POST["password"]))
		{
			echo "not enough information";
			return false;
		}

		return true;
	}


	function checkAddingPoint()
	{
		if(!isset($_POST["addingMoney"]) || !isset($_POST["creditCard"]))
		{
			echo "not enough information";
			return false;
		}
		return true;
	}
 ?>
<?php 
	
	require_once "lberDatabaseUtil.php";
	define("endl", "<br>");

	function userSignin($request)
	{
		$hasAccount = $request["hasAccount"] == "yes" ? true : false;
		$pdo = getPDO();
		if($hasAccount)
		{
			echo "has account" . endl;
			// check driver user name get the driver id
			$driverId = getDriverIdFromDriverInfo($pdo, $request["signinDriverName"]);

			// check if the dirver id exist
			if($driverId == -1)
			{
				echo "can not find user";
				return false;
			}

			// if exist create a user in costumer table 
			$rowEffect =insertUserInfo($pdo, $request["user"], $request["password"]);
			echo "row effect" . $rowEffect. endl;
			if( $rowEffect === -1)
			{
				echo "insert error";
				return false;
			}

			// get the userinfo id
			$id = getUserIdFromUserInfo($pdo, $request["user"]);

			//	use driver id to find general user table and update user id
			updateUserIdInGeneralUserByDriverId($pdo, $driverId, $id);
		}
		else
		{
			echo "enter no account" . endl;
			// create in costumer table
			insertUserInfo($pdo, $request["user"], $request["password"]);

			echo "finish insert user info". endl;

			// get the user id 
			$userId = getUserIdFromUserInfo($pdo, $request["user"]);
			echo "finish get user id" . endl;
			if($userId == -1)
			{
				echo "can not find user id";
				return false;
			}
			// update general user table

			$firstName = $request["firstName"];
			$lastName = $request["lastName"];
			$age = $request["age"];
			$birthDate = $request["birthDate"];
			$email = $request["email"];
			$phone = $request["phone"];
			$password = $request["password"];

			echo "going to createGeneraluserTable" . endl;
			createGeneraluserTable($pdo, true, $userId, $firstName, $lastName, $age, $birthDate, $email, $phone);
			echo "finish to createGeneraluserTable" . endl;
		}

		echo "good";
		return true;
	}	


	//-------------------------------------------------------------


	function driverSignin($request)
	{
		$hasAccount = $request["hasAccount"] == "yes" ? true : false;
		$pdo = getPDO();
		if($hasAccount)
		{
			echo "has account" . endl;
			// check user name get the user id
			$userId = getUserIdFromUserInfo($pdo, $request["signinUserName"]);

			// check if the user id exist
			if($userId == -1)
			{
				echo "can not find user";
				return false;
			}

			// if exist create a user in driver table 
			$effectRow = insertDriverInfo($pdo, $request["user"], $request["password"]) ;
			if($effectRow === -1)
			{
				echo "insert error";
				return false;
			}

			// get the driver info id
			$id = getDriverIdFromDriverInfo($pdo, $request["user"]);

			//	use driver id to find general user table and update user id
			updateDriverIdInGeneralUserByUserId($pdo, $userId, $id);
		}
		else
		{
			echo "enter no account" . endl;
			// create in driver table
			insertDriverInfo($pdo, $request["user"], $request["password"]);

			echo "finish insert driver info". endl;

			// get the driver id 
			$driverId = getDriverIdFromDriverInfo($pdo, $request["user"]);
			echo "finish get driver id" . endl;
			if($driverId == -1)
			{
				echo "can not find driver id";
				return false;
			}
			// update general user table

			$firstName = $request["firstName"];
			$lastName = $request["lastName"];
			$age = $request["age"];
			$birthDate = $request["birthDate"];
			$email = $request["email"];
			$phone = $request["phone"];
			$password = $request["password"];

			echo "going to createGeneraluserTable" . endl;
			createGeneraluserTable($pdo, false, $driverId, $firstName, $lastName, $age, $birthDate, $email, $phone);
			echo "finish to createGeneraluserTable" . endl;
		}

		echo "good";
		return true;
	}


	//-------------------------------------------------------------


	function placeOrder()
	{

	}


	//-------------------------------------------------------------


	function getOrderHistory()
	{

	}



	//-------------------------------------------------------------------


	function getCurrentOrder()
	{
		
	}
	
 ?>
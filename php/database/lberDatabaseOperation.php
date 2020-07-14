<?php 
	
	require_once "lberDatabaseUtil.php";
	require_once "../vertifyConfig.php";
	require_once "../vertify.php";
	

	define("endl", "<br>");

	function userSignin($request)
	{
		$hasAccount = $request["hasAccount"] == "yes" ? true : false;
		$pdo = getPDO();

		// check if the user name exist in the database or not
		if(checkUserName($pdo, "user", $request["user"]))
		{
			echo '{"userName":"user name already exist"}';
			return;
		}

		if($hasAccount)
		{
			// check driver user name get the driver id
			$driverId = getDriverIdFromDriverInfo($pdo, $request["signinDriverName"]);

			// check if the dirver id exist
			if($driverId == -1)
			{
				$errorMessage = '{"signinUserName" : "driver name: can not find user"}';
				echo $errorMessage;
				return false;
			}

			// check if driver id exist then check if it sigin as user before
			if(getUserIdFromGeneralUser($pdo, $driverId) != -1)
			{
				$errorMessage = '{"signinUserName" : "you sign in already"}';
				echo $errorMessage;
				return false;
			}

			// if not exist create a user in costumer table 
			$rowEffect =insertUserInfo($pdo, $request["user"], $request["password"]);
			
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
			// create in costumer table
			insertUserInfo($pdo, $request["user"], $request["password"]);

			// get the user id 
			$userId = getUserIdFromUserInfo($pdo, $request["user"]);
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

			createGeneraluserTable($pdo, true, $userId, $firstName, $lastName, $age, $birthDate, $email, $phone);
		}

		echo "good";
		return true;
	}	


	//-------------------------------------------------------------


	function driverSignin($request)
	{
		$hasAccount = $request["hasAccount"] == "yes" ? true : false;
		$pdo = getPDO();

		// check if the user name exist in the database or not
		if(checkUserName($pdo, "driver", $request["user"]))
		{
			echo '{"userName":"user name already exist"}';
			return;
		}

		if($hasAccount)
		{
			// check user name get the user id
			$userId = getUserIdFromUserInfo($pdo, $request["signinUserName"]);

			// check if the user id exist
			if($userId == -1)
			{
				$errorMessage = '{"signinUserName" : "user name: can not find user"}';
				echo $errorMessage;
				return false;
			}

			// check if driver id exist then check if it sigin as user before
			if(getDriverIdFromGeneralUser($pdo, $userId) != -1)
			{
				$errorMessage = '{"signinUserName" : "you sign in already"}';
				echo $errorMessage;
				return false;
			}

			// if not exist create a user in driver table 
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
			// create in driver table
			insertDriverInfo($pdo, $request["user"], $request["password"]);


			// get the driver id 
			$driverId = getDriverIdFromDriverInfo($pdo, $request["user"]);
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

			createGeneraluserTable($pdo, false, $driverId, $firstName, $lastName, $age, $birthDate, $email, $phone);
		}

		echo "good";
		return true;
	}


	//-------------------------------------------------------------


	function userLogin($request)
	{
		setcookie("token", "", time() - 3600 * 10, "/");// clear cookie first

		$pdo = getPdo();
		if(!checkUserName($pdo, "user", $request["user"]))
		{
			echo '{"userName":"user: can not find user name"}';
			return;
		}

		$databasePassword = getPassword($pdo, "user", $request["user"]);

		if($databasePassword !== $request["password"])
		{
			echo '{"password":"password: wrong passowrd"}';
			return;
		}

		$tokenUtil = new TokenUtil();
		$token = $tokenUtil->getToken($request["user"], $request["password"], secreKey, a, b);

		setcookie("token", $token, time() + 3600 * 3, "/");	// set expire to 3 hour and send token as cookie

		echo "good";
	}


	//-------------------------------------------------------------


	function driverLogin($request)
	{
		setcookie("token", "", time() - 3600 * 10, "/");// clear cookie first

		$pdo = getPdo();
		if(!checkUserName($pdo, "driver", $request["user"]))
		{
			echo '{"userName":"user: can not find user name"}';
			return;
		}

		$databasePassword = getPassword($pdo, "driver", $request["user"]);

		if($databasePassword !== $request["password"])
		{
			echo '{"password":"password: wrong passowrd"}';
			return;
		}

		$tokenUtil = new TokenUtil();
		$token = $tokenUtil->getToken($request["user"], $request["password"], secreKey, a, b);

		setcookie("token", $token, time() + 3600 * 3, "/");	// set expire to 3 hour and send token as cookie

		echo "good";
	}


	//-------------------------------------------------------------

	function generalSetup($userType, $token)
	{
		$pdo = getPdo();
		$tokenUtil = new TokenUtil($token);
		if(!checkToken($pdo, $userType, $tokenUtil))
			return

		// pass validation 
		$payload = $tokenUtil->getPayloadMap();
		$userName = $payload["user"];

		// do what you need to do
		echo '{"name":"'.$userName.'"}';

	}


	//-------------------------------------------------------------


	function checkToken($pdo, $userType, $tokenUtil)
	{
		
		$payload = $tokenUtil->getPayloadMap();
		$pdo = getPdo();
		$userName = $payload["user"];
		$password = $payload["password"];
		if(!checkUserName($pdo, $userType, $userName))
		{
			echo "no this user name";
			return false;
		}

		$databasePassword = getPassword($pdo, $userType, $userName);

		if($passowrd !== $databasePassword)
		{
			echo "password not match";
			return false;
		}

		return true;
	}


	//-------------------------------------------------------------


	function placeOrder($token, $request)
	{
		$tokenUtil = new TokenUtil($token);
		if(!checkToken($token, "user", $tokenUtil))
		{
			echo "not validat user";
			return;
		}

		$payload = $tokenUtil->getPayloadMap();
		$userName = $payload["user"];

		$order = Array();
		$orderName = $request["orderName"] ?? "";
		$carry = $request["carrying"];
		$deliveryDate = $request["deliveryDate"];
		$fromCity = $request["fromCity"];
		$fromAddress = $request["fromAddress"];
		$toCity = $request["toCity"];
		$toAddress = $request["toAddress"];
		$description = $request["orderDescription"] ?? "";

		$from = $fromAddress . " " . $fromCity;
		$to = $toAddress . " " . $toCity;
		$userId = getUserIdFromUserInfo($pdo, $userName);

		insertOrder($pdo, $orderName, $carry, $deliveryDate $userId, $from, $to, $description);
		$orderId = getLastInsertId($pdo);

		insertCurrentOrder($pdo, $orderId, $orderName, $carry, $deliveryDate $userId, $from, $to, $description);
	}


	//-------------------------------------------------------------


	function getOrderHistory($token, $userType)
	{
		$tokenUtil = new TokenUtil($token);
		if(!checkToken($token, $userType, $tokenUtil))
		{
			echo "not validat user";
			return;
		}

		$payload = $tokenUtil->getPayloadMap();
		$name = $payload["user"];
		$pdo = getPdo();

		$id = 0;
		$result = null;
		if($userType == "user")
		{
			$id = getUserIdFromUserInfo($pdo, $name);
			$result = getOrdersByUserId($pdo, $id);
		}
		else if($userType == "driver")
		{
			$id = getDriverIdFromDriverInfo($pdo, $name);
			$result = getOrdersByDriverId($pdo, $id);
		}

		echo json_encode($result);
	}



	//-------------------------------------------------------------------


	function getCurrentOrder($token, $userType)
	{
		$tokenUtil = new TokenUtil($token);
		if(!checkToken($token, $userType, $tokenUtil))
		{
			echo "not validat user";
			return;
		}

		$payload = $tokenUtil->getPayloadMap();
		$name = $payload["user"];
		$pdo = getPdo();

		$id = 0;
		$result = null;
		if($userType == "user")
		{
			$id = getUserIdFromUserInfo($pdo, $name);
			$result = getCurrentOrdersByUserId($pdo, $id);
		}
		else if($userType == "driver")
		{
			$id = getDriverIdFromDriverInfo($pdo, $name);
			$result = getCurrentOrdersByDriverId($pdo, $id);
		}

		echo json_encode($result);
	}
	


	//-----------------------------------------------------------


	function getPersonalInformation($token, $userType)
	{
		$tokenUtil = new TokenUtil($token);
		if(!checkToken($token, $userType, $tokenUtil))
		{
			echo "not validat user";
			return;
		}

		$payload = $tokenUtil->getPayloadMap();
		$name = $payload["user"];
		$pdo = getPdo();

		$id = 0;
		$result = null;
		if($userType == "user")
		{
			$id = getUserIdFromUserInfo($pdo, $name);
			$result = getGeneralUserByUserId($pdo, $id);
		}
		else if($userType == "driver")
		{
			$id = getDriverIdFromDriverInfo($pdo, $name);
			$result = getGeneralUserByDriverId($pdo, $id);
		}
		$result["userName"] = $name;
		echo json_encode($result);
	}



	//-----------------------------------------------------------


	function changeUserPersonalInformation($token, $request)
	{
		$tokenUtil = new TokenUtil($token);
		if(!checkToken($token, "user", $tokenUtil))
		{
			echo "not validat user";
			return;
		}

		$payload = $tokenUtil->getPayloadMap();
		$userName = $payload["user"];
		$pdo = getPdo();

		// check passed user name
		$name = $request["user"];
		$password = $request["password"];
		$email = $request["email"];
		$phone = $request["phone"];
		if(getUserIdFromUserInfo($pdo, $name) != -1)
		{
			echo '{"user":"user name exist already"}';
			return;
		}

		$userId = getUserIdFromUserInfo($pdo, $userName);
		updateUserTableByUserId($pdo, $userId, $name, $passowrd, null);
		updateGeneralUserByUserId($pdo, $userId $email, $phone);

		echo "good";
	}



	//-----------------------------------------------------------


	function changeDriverPersonalInformation($token, $request)
	{
		$tokenUtil = new TokenUtil($token);
		if(!checkToken($token, "driver", $tokenUtil))
		{
			echo "not validat user";
			return;
		}

		$payload = $tokenUtil->getPayloadMap();
		$driverName = $payload["user"];
		$pdo = getPdo();

		// check passed user name
		$name = $request["user"];
		$password = $request["password"];
		$email = $request["email"];
		$phone = $request["phone"];
		if(getDriverIdFromDriverInfo($pdo, $name) != -1)
		{
			echo '{"user":"user name exist already"}';
			return;
		}

		$driverId = getDriverIdFromDriverInfo($pdo, $driverName);
		updateUserTableByDriverId($pdo, $driverId, $name, $passowrd, null, null);
		updateGeneralUserByDriverId($pdo, $driverId $email, $phone);

		echo "good";
	}


	//-----------------------------------------------------------


	function addPoint($token, $userType, $request)
	{
		$tokenUtil = new TokenUtil($token);
		if(!checkToken($token, "driver", $tokenUtil))
		{
			echo "not validat user";
			return;
		}

		$payload = $tokenUtil->getPayloadMap();
		$name = $payload["user"];
		$pdo = getPdo();

		$value = $request["addingMoney"] ?? 0;

		$id = 0;
		$result = null;
		if($userType == "user")
		{
			$id = getUserIdFromUserInfo($pdo, $name);
			$result = getGeneralUserByUserId($pdo, $id);
			$point = $result[0]["point"];
			$point += $value;
			updatePointInGeneralUserByUserId($pdo, $id, $value)
		}
		else if($userType == "driver")
		{
			$id = getDriverIdFromDriverInfo($pdo, $name);
			$result = getGeneralUserByDriverId($pdo, $id);
			$point = $result[0]["point"];
			$point += $value;
			updatePointInGeneralUserByDriverId($pdo, $id, $value)
		}

		echo "good";
	}
 ?>
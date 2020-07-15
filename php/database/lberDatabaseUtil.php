<?php 
	require_once "pdoUtil.php";

	function checkUserName($pdo, $type, $name)
	{
		$sql = "";
		if($type == "user")
			$sql = "SELECT userName FROM userinfo where userName = '".$name."'";
		else if($type == "driver")
			$sql = "SELECT userName FROM driverinfo where userName = '".$name."'";

		$result = find($pdo, $sql);

		if(isset($result[0]["userName"]))
			return true;
		else
			return false;
	}

	function getPassword($pdo, $type, $name)
	{
		$sql = "";
		if($type == "user")
			$sql = "SELECT password FROM userinfo where userName = '".$name."'";
		else if($type == "driver")
			$sql = "SELECT password FROM driverinfo where userName = '".$name."'";

		$result = find($pdo, $sql);

		return $result[0]["password"];
	}

	function getDriverIdFromDriverInfo($pdo, $driverName)
	{
		$sql = "SELECT id FROM driverinfo where userName = '".$driverName."'";
		$result = find($pdo, $sql);

		if(!isset($result[0]["id"]))
			return -1;
		else
			return $result[0]["id"];
	}


	function getUserIdFromUserInfo($pdo, $userName)
	{
		$sql = "SELECT id FROM userinfo WHERE userName = '".$userName."'";
		$result = find($pdo, $sql);
		if(!isset($result[0]["id"]))
			return -1;
		return $result[0]["id"];
	}


	function getUserIdFromGeneralUser($pdo, $driverId)
	{
		$sql = "SELECT userId FROM generaluser WHERE driverId = '".$driverId."'";
		$result = find($pdo, $sql);
		if(!isset($result[0]["userId"]) || $result[0]["userId"] == NULL)
			return -1;
		return $result[0]["userId"];
	}

	function getDriverIdFromGeneralUser($pdo, $userId)
	{
		$sql = "SELECT driverId FROM generaluser WHERE userId = '".$userId."'";
		$result = find($pdo, $sql);
		if(!isset($result[0]["driverId"]) || $result[0]["driverId"] == NULL)
			return -1;
		return $result[0]["driverId"];
	}


	function getOrdersByUserId($pdo, $userId)
	{
		$sql = "SELECT * FROM orders WHERE userId = '". $userId ."'";
		$result = find($pdo, $sql);
		return $result;
	}


	function getOrdersByDriverId($pdo, $driverId)
	{
		$sql = "SELECT * FROM orders WHERE driverId = '". $driverId ."'";
		$result = find($pdo, $sql);
		return $result;
	}


	function getCurrentOrdersByUserId($pdo, $userId)
	{
		$sql = "SELECT * FROM orders WHERE userId = '". $userId ."' AND waitingState = 1 AND finishState = 0";
		$result = find($pdo, $sql);
		return $result;
	}


	function getCurrentOrdersByDriverId($pdo, $driverId)
	{
		$sql = "SELECT * FROM orders WHERE driverId = '". $driverId ."' AND waitingState = 1 AND finishState = 0";
		$result = find($pdo, $sql);
		return $result;
	}


	function getGeneralUserByUserId($pdo, $userId)
	{
		$sql = "SELECT * FROM generaluser WHERE userId = '".$userId."'";
		$result = find($pdo, $sql);
		return $result;
	}


	function getGeneralUserByDriverId($pdo, $driverId)
	{
		$sql = "SELECT * FROM generaluser WHERE driverId = '".$driverId."'";
		$result = find($pdo, $sql);
		return $result;
	}

	function insertUserInfo($pdo, $name, $password)
	{
		$sql = "INSERT INTO userinfo (userName, password) values (?,?)";
		$i = update($pdo, $sql, $name, $password);
		return $i;
	}


	function insertDriverInfo($pdo, $name, $password)
	{
		$sql = "INSERT INTO driverinfo (userName, password) values (?,?)";
		return update($pdo, $sql, $name, $password);
	}


	function updateUserIdInGeneralUserByDriverId($pdo, $driverId, $userId)
	{
		$sql = "UPDATE generaluser SET userId = ? where driverId = ?";
		return update($pdo, $sql, $userId, $driverId);
	}

	function updateDriverIdInGeneralUserByUserId($pdo, $userId, $driverId)
	{
		$sql = "UPDATE generaluser SET driverId = ? where userId = ?";
		return update($pdo, $sql, $driverId, $userId);
	}


	function updateUserTableByUserId($pdo, $userId, $name, $passowrd, $description)
	{
		$sql = "UPDATE userinfo SET userName = ?, password = ?, selfDescription = ? where userId = ?";
		return update($pdo, $sql, $name, $password, $description, $userId);
	}


	function updateDriverTableByDriverId($pdo, $driverId, $name, $passowrd, $description, $carType)
	{
		$sql = "UPDATE driverinfo SET driverName = ?, password = ?, selfDescription = ?, carType = ? where driverId = ?";
		return update($pdo, $sql, $name, $password, $description, $carType, $driverId);
	}


	function updateGeneralUserByUserId($pdo, $userId, $email, $phone)
	{
		$sql = "UPDATE generaluser SET email = ?, phone = ? WHERE userId = ?";
		return update($pdo, $sql, $email, $phone, $userId);
	}


	function updateGeneralUserByDriverId($pdo, $driverId, $email, $phone)
	{
		$sql = "UPDATE generaluser SET email = ?, phone = ? WHERE driverId = ?";
		return update($pdo, $sql, $email, $phone, $driverId);
	}


	function updatePointInGeneralUserByUserId($pdo, $userId, $value)
	{
		$sql = "UPDATE generaluser SET point = ? WHERE userId = ?";
		return update($pdo, $sql, $value, $userId);
	}

	function updatePointInGeneralUserByDriverId($pdo, $driverId, $value)
	{
		$sql = "UPDATE generaluser SET point = ? WHERE driverId = ?";
		return update($pdo, $sql, $value, $driverId);
	}

	function createGeneraluserTable($pdo, $isCreateUser, $id, $firstName, $lastName, $age, $birthDate, $email, $phone)
	{

		$sql = "";
		if($isCreateUser)	// create user
			$sql = "INSERT INTO generaluser (userId, firstName, lastName, age, birthDate, email, phone, rigesterTime) values(?,?,?,?,?,?,?,?)";
		else // create driver 
			$sql = "INSERT INTO generaluser (driverId, firstName, lastName, age, birthDate, email, phone, rigesterTime) values(?,?,?,?,?,?,?,?)";

		$time = date("Y-m-d H:i:s", time());
		return update($pdo, $sql, $id, $firstName, $lastName, $age, $birthDate, $email, $phone, $time);
	}


	function insertOrder($pdo, $orderName, $carry, $deliveryDate, $userId, $from, $to, $description)
	{
		$sql = "INSERT INTO orders(orderName, carring, placeOrderTime, deliveryDate, userId, waitingState, fromAddress, toAddress, description) VALUES (?,?,?,?,?,?,?,?,?)";

		$time = date("Y-m-d H:i:s", time());
		
		return update($pdo, $sql, $orderName, $carry, $time, $deliveryDate, $userId, 1, $from, $to, $description);
	}

	function insertCurrentOrder($pdo, $orderId, $orderName, $carry, $deliveryDate, $userId, $from, $to, $description)
	{
		$sql = "INSERT INTO currentorders(orderId, orderName, carring,  deliveryDate, userId, fromAddress, toAddress, description) VALUES (?,?,?,?,?,?,?,?)";

		return update($pdo, $sql, $orderId, $orderName, $carry, $deliveryDate, $userId, $from, $to, $description);
	}

	function getLastInsertId($pdo)
	{
		$sql = "SELECT LAST_INSERT_ID()";
		return find($pdo, $sql)[0][0];
	}
 ?>
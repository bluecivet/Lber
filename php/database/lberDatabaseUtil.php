<?php 
	require_once "pdoUtil.php";

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
		var_dump($result);
		if(!isset($result[0]["id"]))
			return -1;
		return $result[0]["id"];
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

 ?>
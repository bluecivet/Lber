<?php 
	
	require_once "databaseConfig.php";

	function getPdo()
	{
		$pdo = null;
		try
		{
			$pdo = new PDO(URL, USERNAME, PASSWORD);
			$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		}
		catch(PAOException $e)
		{
			die($e->getMessage());
		}

		return $pdo;
	}


	function find($pdo, $sql)
	{
		try
		{
			$result = $pdo->query($sql);
			return $result->fetchAll();
		}
		catch(PDOException $e)
		{
			die($e->getMessage());
		}

		return -1;
	}


	function update()
	{
		$n = func_num_args();

		if($n < 2)
			return -1;

		$args = func_get_args();
		$pdo = $args[0];
		$sql = $args[1];

		try
		{
			$statement = $pdo->prepare($sql);

			for($i = 2; $i < $n; $i++)
			{
				$statement->bindValue($i - 1, $args[$i]);
			}

			return $statement->execute();
		}
		catch(PDOException $e)
		{
			die($e->getMessage());
		}

		return -1;
		
	}
 ?>
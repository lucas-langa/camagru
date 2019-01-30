<?php 
	require "./db.class.php";
	require "./config/database.php";
	
	if (isset($_GET['ash']) && isset($_GET['email']))
	{
		include_once "refiner.php";
		$net = new connection($DB_DSN."dbname=x", $DB_USER, $DB_PASSWORD);
		$query = $net->conn->prepare("SELECT * FROM users WHERE `email` =? AND chash =?");
		$query->execute([$_GET['email'], $_GET['ash']]);
		$result = $query->fetch();
		if ($result > 0)
		{
			$nquery = $net->conn->prepare("UPDATE `users` SET `confirm` =? WHERE `email` =?");
			$n = 1;
			$nquery->execute([1, $_GET['email']]);
			header("Location: http://localhost:8080/camagru/login.php");
		}
		else
		{
			echo "ACcount not found";
		}
	}
	else
	{
		echo "err";
	}
?> 

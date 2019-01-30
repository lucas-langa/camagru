<?php
	require "./config/database.php";
	require "./db.class.php";
	include_once "refiner.php";
	sanitize();
	
	// $dbx = [$DB_DSN."dbname=x", $DB_USER, $DB_PASSWORD];
	$hex = explode('&',$_SERVER['QUERY_STRING']);
	// echo $_SERVER['REQUEST_METHOD'];
	//logging in
	if ($_SERVER['REQUEST_METHOD'] === "POST")
	{
		if (isset($_POST['username']) && isset($_POST['password']))
		{
			$pwd = hash("whirlpool", $_POST['password']);
			$net = new connection($DB_DSN."dbname=x", $DB_USER, $DB_PASSWORD);
			$x = $net->conn->prepare("SELECT * FROM `users` WHERE `username` = ? AND `password` = ? AND `confirm` = 1");
			$x->execute([$_POST['username'], $pwd]);
			$q = $x->fetch();
			
			if ($q['confirm'] === 0)
			{
				echo "account hasn't been activated";
				die();
			}
			if ((!password_verify($_POST['password'] , $q['password'])))
			{
				echo "no";
				
				die();
			}
			if ($q && password_verify($_POST['password'] , $q['password']))
			{
				echo "account hasn't been activated";
				die();
			}
			if ($q['password'] === $pwd)
			{
				echo "login";
				die();
			}
			if (!$q)
			{
				echo "invalid combo";
				die();
			}
		}
	}
	// $dbx = [$DB_DSN."dbname=x", $DB_USER, $DB_PASSWORD];
	
	else if ($_SERVER['REQUEST_METHOD'] === "GET")
	{
		if ($hex[0] === "details=view" && isset($hex[1]))
		{
			$nombre = substr($hex[1], (strpos($hex[1], '=') + 1));
			$net = new connection($DB_DSN."dbname=x", $DB_USER, $DB_PASSWORD);
			$x = $net->conn->prepare("SELECT `username`,`email` FROM `users` WHERE `username`=?");
			$x->execute([$nombre]);
			$q = $x->fetch();
			echo json_encode($q);
			die();
		}
		if ($hex[0] === "login=yes" && isset($hex[1]))
		{
			if (isset($_GET['username']))
			{
				$net = new connection($DB_DSN."dbname=x", $DB_USER, $DB_PASSWORD);
				$x = $net->conn->prepare("SELECT * FROM `users` WHERE `username` = ?");
				$x->execute([$_GET['username']] );
				$q = $x->fetch();
				if ($q){
					if ($q['confirm'] == '1'){
						if ($q['password'] === hash("whirpool") )
						echo "letthemin";
					}	
				}
				else{
					echo "fuckoff";
				}
			}
		}
		else if ($hex[0] === "login=no" && isset($hex[1])) {
			$net = new connection($DB_DSN."dbname=x", $DB_USER, $DB_PASSWORD);
			$x = $net->conn->prepare("SELECT * FROM `users` where username = ?");
			$x->execute([$_GET['username']]);
			$q = $x->fetch();
			if ($q) {
				echo "found";
			}
			echo "notfound";
			$do = new connection($DB_DSN."dbname=x", $DB_USER, $DB_PASSWORD);
			$do->setup_db_query("UPDATE `users` SET `confirm` = 1");
			return ("notfound");
		}
	}

?>
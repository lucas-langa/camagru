<?php
	

	class connection{
		protected $username;
		protected $servername;
		protected $password;
		public $conn;

		function    __construct($DB_DSN, $DB_USER, $DB_PASSWORD){
			if (!isset($DB_DSN, $DB_USER, $DB_PASSWORD)){
				echo "missing some details friend\n";
				return (FALSE);
			}
			try{
				$username = $DB_USER;
				$servername = $DB_DSN;
				$password = $DB_PASSWORD;
				$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
								PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
								PDO::ATTR_EMULATE_PREPARES   => true,];
				$this->conn = new PDO("$servername", $username, $password, $options);
				// echo "connected\n".PHP_EOL;
				}
				catch (PDOException $e){
					// echo "shit went wrong with the connection\n" . $e->getMessage() ."\n";
					exit(1);
				}
		}
		function    setup_db_query($query){   
			if (isset($query) == FALSE)
				return ("??");
			$this->conn->exec($query);
		}

		function    __destruct(){
			$this->conn = NULL;
			// echo "destroy\n";
		}
	}
	include_once "refiner.php";
	/* function sanitize()
	{
		if ($_SERVER['REQUEST_METHOD'] == "POST" || $_SERVER['REQUEST_METHOD'] == "GET")
		{
			$target = $_SERVER['REQUEST_METHOD'];
			$arr = $GLOBALS["_".$target];
			foreach($GLOBALS["_".$target] as $key => $value)
			{
				$GLOBALS["_".$target][$key] = htmlspecialchars($value);
				$GLOBALS["_".$target][$key] = stripslashes($value);
				$GLOBALS["_".$target][$key] = strip_tags($value);
			}
		}
	}
	// saint Tiimbre
	*/
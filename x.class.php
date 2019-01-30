<?php
	require $_SERVER['DOCUMENT_ROOT']."./config/setup.php";
	require $_SERVER['DOCUMENT_ROOT']."./config/database.php";
	include_once "refiner.php";
	$DSN = $DB_DSN."dbname=x";

	class user extends connection
	{
		private $details;
		private $confirm;
		public $subject = "confirming an account";
		public $headers = 'MIME-Version: 1.0\r\nContent-type: text/html;charset=UTF-8'.'From: <llanga@student.wethinkcode.co.za>';

		function __construct($DSN,$DB_USER, $DB_PASSWORD)
		{
			parent::__construct($DSN, $DB_USER, $DB_PASSWORD);
		}

		public function 	check()
		{
			foreach ($this->details as $value)
			{
				if (!isset($value))
					return (FALSE);
			}
			return (TRUE);
		}
		
		static function display($username)
		{
			$q = $this->conn->prepare("SELECT username from `users` where username=?");
			$q->execute($username);
			$result = $q->fetch();
			// "SELECT username, email FROM users WHERE username=:username AND email=:email";
		}

		public function insert_user()
		{
			$params = [];
			$allowed = ["name","surname","email", "chash","username","password","confirm"];
			$setStr = "";
			foreach ($allowed as $key)
			{
				if ($key === "passwd_verify")
					continue ;
				if (isset($_POST[$key]) && $key != "id")
				{
					$setStr .= "`" . str_replace("`", "`", $key)."` = :".$key.",";
					if ($key === "password")
					{
						if ($_POST[$key] === $_POST['passwd_verify'])
						{
							if (preg_match("/(?=\S*\d)(?=\S*[a-z])(?=\S*[A-Z])\S*/", $_POST[$key]) && strlen($_POST[$key]) >= 8)
							{
								$params[$key] = hash("whirlpool", $_POST[$key]);
								continue ;
							}
							else
							{
								header("location: http://localhost:8080/camagru/salty_error.php?message=password requirements, 8 chars, upper and lowercase number and at least a digit");
							}
						}			
						else
						{
							die();
						}			
					}	
					if ($key === "email")
					{
						if (filter_var($_POST[$key], FILTER_VALIDATE_EMAIL))
						{
							$this->confirm = hash("md5", $_POST['email']);
							$params['chash'] = $this->confirm;
							$setStr .= "`" . str_replace("`", "`", "chash")."` = :"."chash".",";
							$email = $_POST['email'];
						}
						else
						{
							echo "invalid email address";
							die();
						}
					}
					$params[$key] = $_POST[$key];
				}
			}
			$params['confirm'] = 0;
			$setStr .= "`" . str_replace("`", "`", "confirm")."` = :"."confirm".",";
			$setStr = rtrim($setStr, ",");
			$q = $this->conn->prepare("INSERT INTO users SET $setStr");
			$q->execute($params);
			$ms = "http://localhost:8080/camagru/verify.php?ash=".$this->confirm."&email=".$email;
			mail("lucaslanga121@gmail.com", $this->subject, $ms, $this->headers);
		}

		function __destruct()
		{
			parent::__destruct();
		}
	}
	?>
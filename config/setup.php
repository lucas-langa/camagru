<?php
    require $_SERVER['DOCUMENT_ROOT']."/camagru/config/database.php";
    require $_SERVER['DOCUMENT_ROOT']."/camagru/db.class.php";

	
	
	$start = new connection($DB_DSN, $DB_USER, $DB_PASSWORD);
    $start->setup_db_query("CREATE DATABASE IF NOT EXISTS x");
    $db_name = "x";
    $query = "CREATE TABLE IF NOT EXISTS $db_name.users(
        `id` INT(3) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        `name` VARCHAR(30) NOT NULL,
        `surname` VARCHAR(30) NOT NULL,
        `email` VARCHAR(50) NOT NULL,
        `username` VARCHAR(50) NOT NULL,
        `password` CHAR(128) NOT NULL,
        `confirm` BOOLEAN NOT NULL,
        `chash` varchar(128),
        `notification` int(1) DEFAULT '1'
        )";
    $start->setup_db_query($query);
    $query = "CREATE TABLE IF NOT EXISTS $db_name.media(
        `id` INT(3) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `uploader` VARCHAR(50) NOT NULL,
        `filename` TEXT NOT NULL,
        `date` DATETIME NOT NULL
		)";
	$start->setup_db_query($query);

	$query = "CREATE TABLE IF NOT EXISTS $db_name.comments(
		comment_id VARCHAR(40) PRIMARY KEY,
		id INT(3) UNSIGNED AUTO_INCREMENT,
		FOREIGN KEY (id)  REFERENCES $db_name.users(id),
		`filename` TEXT NOT NULL,
		`comment` VARCHAR(300),
		`commenter` VARCHAR(50),
		`date` DATETIME NOT NULL)";
	$start->setup_db_query($query);

	$query = "CREATE TABLE IF NOT EXISTS $db_name.likes(
		img_id VARCHAR(40) PRIMARY KEY,
		`user_id` INT(3) UNSIGNED AUTO_INCREMENT,
		FOREIGN KEY (`user_id`) REFERENCES $db_name.users(id),
		`filename` TEXT NOT NULL,
		`liker` VARCHAR(50))";
	$start->setup_db_query($query);
	function resolve_user($user)
	{
		require "config/database.php";
		$start = new connection($DB_DSN, $DB_USER, $DB_PASSWORD);
		$res = $start->conn->prepare("SELECT id FROM x.users WHERE username =:human");
		$res->bindValue(':human', $user);
		$res->execute();
		$start->__destruct();
		$digit = $res->fetch();
		return ($digit['id']);
	}
	?>